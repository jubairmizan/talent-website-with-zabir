<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ConversationController extends Controller
{
    /**
     * Get or create a conversation between member and creator
     */
    public function getOrCreate(Request $request)
    {
        try {
            $request->validate([
                'creator_id' => 'required|exists:users,id'
            ]);

            $creatorId = $request->creator_id;
            $memberId = Auth::id();

            // Verify the target user is actually a creator
            $creator = User::findOrFail($creatorId);
            if (!$creator->isCreator()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only start conversations with creators.'
                ], 400);
            }

            // Verify the current user is a member
            if (!Auth::user()->isMember()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only members can initiate conversations with creators.'
                ], 403);
            }

            // Check if creator is active
            if (!$creator->isActive()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This creator is currently unavailable.'
                ], 400);
            }

            // Check if conversation already exists
            $conversation = Conversation::where('member_id', $memberId)
                ->where('creator_id', $creatorId)
                ->first();

            if (!$conversation) {
                // Create new conversation
                $conversation = Conversation::create([
                    'member_id' => $memberId,
                    'creator_id' => $creatorId,
                    'last_message_at' => now(),
                    'is_blocked' => false
                ]);
            }

            // Check if conversation is blocked
            if ($conversation->is_blocked) {
                return response()->json([
                    'success' => false,
                    'message' => 'This conversation has been blocked.'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'conversation' => [
                    'id' => $conversation->id,
                    'creator_id' => $conversation->creator_id,
                    'creator_name' => $creator->name,
                    'member_id' => $conversation->member_id,
                    'last_message_at' => $conversation->last_message_at,
                    'is_blocked' => $conversation->is_blocked
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting/creating conversation: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Unable to start conversation. Please try again.'
            ], 500);
        }
    }

    /**
     * Get all conversations for the authenticated user
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $conversations = collect();

            if ($user->isMember()) {
                // Get conversations where user is the member
                $conversations = Conversation::where('member_id', $user->id)
                    ->with(['creator' => function($query) {
                        $query->select('id', 'name', 'avatar');
                    }])
                    ->with(['messages' => function($query) {
                        $query->latest()->limit(1);
                    }])
                    ->orderBy('last_message_at', 'desc')
                    ->get()
                    ->map(function($conversation) {
                        $lastMessage = $conversation->messages->first();
                        return [
                            'id' => $conversation->id,
                            'participant_id' => $conversation->creator_id,
                            'participant_name' => $conversation->creator->name ?? 'Unknown Creator',
                            'participant_avatar' => $conversation->creator->avatar ?? null,
                            'last_message' => $lastMessage ? $lastMessage->message : 'No messages yet',
                            'last_message_at' => $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : 'No messages yet',
                            'is_blocked' => $conversation->is_blocked,
                            'unread_count' => $conversation->messages()->where('sender_id', '!=', Auth::id())->where('is_read', false)->count()
                        ];
                    });
            } elseif ($user->isCreator()) {
                // Get conversations where user is the creator
                $conversations = Conversation::where('creator_id', $user->id)
                    ->with(['member' => function($query) {
                        $query->select('id', 'name', 'avatar');
                    }])
                    ->with(['messages' => function($query) {
                        $query->latest()->limit(1);
                    }])
                    ->orderBy('last_message_at', 'desc')
                    ->get()
                    ->map(function($conversation) {
                        $lastMessage = $conversation->messages->first();
                        return [
                            'id' => $conversation->id,
                            'participant_id' => $conversation->member_id,
                            'participant_name' => $conversation->member->name ?? 'Unknown Member',
                            'participant_avatar' => $conversation->member->avatar ?? null,
                            'last_message' => $lastMessage ? $lastMessage->message : 'No messages yet',
                            'last_message_at' => $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : 'No messages yet',
                            'is_blocked' => $conversation->is_blocked,
                            'unread_count' => $conversation->messages()->where('sender_id', '!=', Auth::id())->where('is_read', false)->count()
                        ];
                    });
            }

            return response()->json([
                'success' => true,
                'conversations' => $conversations
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching conversations: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error fetching conversations'
            ], 500);
        }
    }

    /**
     * Block or unblock a conversation
     */
    public function toggleBlock(Request $request, Conversation $conversation)
    {
        try {
            $user = Auth::user();

            // Check if user is part of this conversation
            if ($conversation->member_id !== $user->id && $conversation->creator_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to modify this conversation.'
                ], 403);
            }

            $conversation->update([
                'is_blocked' => !$conversation->is_blocked,
                'blocked_by' => $conversation->is_blocked ? null : $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => $conversation->is_blocked ? 'Conversation blocked successfully.' : 'Conversation unblocked successfully.',
                'is_blocked' => $conversation->is_blocked
            ]);

        } catch (\Exception $e) {
            Log::error('Error toggling conversation block: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Unable to update conversation status.'
            ], 500);
        }
    }

    /**
     * Delete a conversation (soft delete by blocking)
     */
    public function destroy(Conversation $conversation)
    {
        try {
            $user = Auth::user();

            // Check if user is part of this conversation
            if ($conversation->member_id !== $user->id && $conversation->creator_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to delete this conversation.'
                ], 403);
            }

            // Instead of hard delete, we block the conversation
            $conversation->update([
                'is_blocked' => true,
                'blocked_by' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Conversation deleted successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting conversation: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete conversation.'
            ], 500);
        }
    }
}