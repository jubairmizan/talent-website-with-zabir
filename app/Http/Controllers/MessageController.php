<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Get messages for a specific conversation
     */
    public function index(Request $request, Conversation $conversation)
    {
        try {
            $user = Auth::user();

            // Check if user is part of this conversation
            if ($conversation->member_id !== $user->id && $conversation->creator_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to view this conversation.'
                ], 403);
            }

            // Check if conversation is blocked
            if ($conversation->is_blocked) {
                return response()->json([
                    'success' => false,
                    'message' => 'This conversation has been blocked.'
                ], 403);
            }

            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 50);

            $messages = Message::where('conversation_id', $conversation->id)
                ->with(['sender' => function($query) {
                    $query->select('id', 'name', 'avatar');
                }])
                ->orderBy('created_at', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);

            // Mark messages as read for the current user
            Message::where('conversation_id', $conversation->id)
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);

            $formattedMessages = $messages->getCollection()->map(function($message) use ($user) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_id' => $message->sender_id,
                    'sender_name' => $message->sender->name ?? 'Unknown User',
                    'sender_avatar' => $message->sender->avatar ?? null,
                    'is_own_message' => $message->sender_id === $user->id,
                    'is_read' => $message->is_read,
                    'created_at' => $message->created_at->toISOString(),
                    'formatted_time' => $message->created_at->format('H:i')
                ];
            })->reverse()->values();

            return response()->json([
                'success' => true,
                'messages' => $formattedMessages,
                'pagination' => [
                    'current_page' => $messages->currentPage(),
                    'last_page' => $messages->lastPage(),
                    'per_page' => $messages->perPage(),
                    'total' => $messages->total(),
                    'has_more_pages' => $messages->hasMorePages()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching messages: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error fetching messages'
            ], 500);
        }
    }

    /**
     * Send a new message
     */
    public function store(Request $request, Conversation $conversation)
    {
        try {
            $user = Auth::user();

            // Check if user is part of this conversation
            if ($conversation->member_id !== $user->id && $conversation->creator_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to send messages in this conversation.'
                ], 403);
            }

            // Check if conversation is blocked
            if ($conversation->is_blocked) {
                return response()->json([
                    'success' => false,
                    'message' => 'This conversation has been blocked.'
                ], 403);
            }

            $request->validate([
                'message' => 'required|string|max:1000'
            ]);

            DB::beginTransaction();

            // Create the message
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $user->id,
                'message' => trim($request->message),
                'is_read' => false
            ]);

            // Update conversation's last message timestamp
            $conversation->update([
                'last_message_at' => now()
            ]);

            DB::commit();

            // Load sender relationship
            $message->load(['sender' => function($query) {
                $query->select('id', 'name', 'avatar');
            }]);

            $formattedMessage = [
                'id' => $message->id,
                'message' => $message->message,
                'sender_id' => $message->sender_id,
                'sender_name' => $message->sender->name ?? 'Unknown User',
                'sender_avatar' => $message->sender->avatar ?? null,
                'is_own_message' => true,
                'is_read' => $message->is_read,
                'created_at' => $message->created_at->toISOString(),
                'formatted_time' => $message->created_at->format('H:i')
            ];

            // TODO: Broadcast the message to other participants using Laravel Echo
            // This would require setting up broadcasting and websockets
            // broadcast(new MessageSent($message, $conversation))->toOthers();

            return response()->json([
                'success' => true,
                'message' => $formattedMessage
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error sending message: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Unable to send message. Please try again.'
            ], 500);
        }
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request, Conversation $conversation)
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

            $messageIds = $request->get('message_ids', []);

            if (empty($messageIds)) {
                // Mark all unread messages as read
                Message::where('conversation_id', $conversation->id)
                    ->where('sender_id', '!=', $user->id)
                    ->where('is_read', false)
                    ->update([
                        'is_read' => true,
                        'read_at' => now()
                    ]);
            } else {
                // Mark specific messages as read
                Message::where('conversation_id', $conversation->id)
                    ->where('sender_id', '!=', $user->id)
                    ->whereIn('id', $messageIds)
                    ->where('is_read', false)
                    ->update([
                        'is_read' => true,
                        'read_at' => now()
                    ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Messages marked as read.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error marking messages as read: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Unable to mark messages as read.'
            ], 500);
        }
    }

    /**
     * Get unread message count for a conversation
     */
    public function getUnreadCount(Conversation $conversation)
    {
        try {
            $user = Auth::user();

            // Check if user is part of this conversation
            if ($conversation->member_id !== $user->id && $conversation->creator_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to view this conversation.'
                ], 403);
            }

            $unreadCount = Message::where('conversation_id', $conversation->id)
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->count();

            return response()->json([
                'success' => true,
                'unread_count' => $unreadCount
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting unread count: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error getting unread count'
            ], 500);
        }
    }

    /**
     * Get total unread messages count for user
     */
    public function getTotalUnreadCount()
    {
        try {
            $user = Auth::user();
            $totalUnread = 0;

            if ($user->isMember()) {
                $totalUnread = Message::whereHas('conversation', function($query) use ($user) {
                    $query->where('member_id', $user->id);
                })
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->count();
            } elseif ($user->isCreator()) {
                $totalUnread = Message::whereHas('conversation', function($query) use ($user) {
                    $query->where('creator_id', $user->id);
                })
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->count();
            }

            return response()->json([
                'success' => true,
                'total_unread' => $totalUnread
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting total unread count: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error getting unread count'
            ], 500);
        }
    }
}