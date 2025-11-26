<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the portfolio items.
     */
    public function index()
    {
        $user = Auth::user();
        $creatorProfile = $user->creatorProfile;
        
        if (!$creatorProfile) {
            return redirect()->route('creator.dashboard')->with('error', 'Creator profile not found.');
        }

        $portfolioItems = $creatorProfile->portfolioItems()
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('creator.portfolio.index', compact('portfolioItems'));
    }

    /**
     * Show the form for creating a new portfolio item.
     */
    public function create()
    {
        return view('creator.portfolio.create');
    }

    /**
     * Store a newly created portfolio item in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $creatorProfile = $user->creatorProfile;
        
        if (!$creatorProfile) {
            return redirect()->route('creator.dashboard')->with('error', 'Creator profile not found.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480', // 20MB max
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('portfolio', $fileName, 'public');
        
        // Generate thumbnail for videos (placeholder for now)
        $thumbnailPath = null;
        $fileType = $this->getFileType($file->getMimeType());
        
        if ($fileType === 'video') {
            // For now, we'll use a placeholder. In production, you'd generate actual video thumbnails
            $thumbnailPath = 'portfolio/thumbnails/video-placeholder.jpg';
        }

        $portfolioItem = $creatorProfile->portfolioItems()->create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'thumbnail_path' => $thumbnailPath,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('creator.portfolio.index')
            ->with('success', 'Portfolio item created successfully!');
    }

    /**
     * Display the specified portfolio item.
     */
    public function show(PortfolioItem $portfolioItem)
    {
        $this->authorize('view', $portfolioItem);
        
        return view('creator.portfolio.show', compact('portfolioItem'));
    }

    /**
     * Show the form for editing the specified portfolio item.
     */
    public function edit(PortfolioItem $portfolioItem)
    {
        $this->authorize('update', $portfolioItem);
        
        return view('creator.portfolio.edit', compact('portfolioItem'));
    }

    /**
     * Update the specified portfolio item in storage.
     */
    public function update(Request $request, PortfolioItem $portfolioItem)
    {
        $this->authorize('update', $portfolioItem);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480', // 20MB max
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? $portfolioItem->sort_order,
            'is_active' => $request->boolean('is_active', $portfolioItem->is_active)
        ];

        // Handle file upload if new file is provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($portfolioItem->file_path && Storage::disk('public')->exists($portfolioItem->file_path)) {
                Storage::disk('public')->delete($portfolioItem->file_path);
            }
            
            // Delete old thumbnail
            if ($portfolioItem->thumbnail_path && Storage::disk('public')->exists($portfolioItem->thumbnail_path)) {
                Storage::disk('public')->delete($portfolioItem->thumbnail_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('portfolio', $fileName, 'public');
            
            $fileType = $this->getFileType($file->getMimeType());
            $thumbnailPath = null;
            
            if ($fileType === 'video') {
                $thumbnailPath = 'portfolio/thumbnails/video-placeholder.jpg';
            }

            $updateData = array_merge($updateData, [
                'file_path' => $filePath,
                'file_type' => $fileType,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'thumbnail_path' => $thumbnailPath
            ]);
        }

        $portfolioItem->update($updateData);

        return redirect()->route('creator.portfolio.index')
            ->with('success', 'Portfolio item updated successfully!');
    }

    /**
     * Remove the specified portfolio item from storage.
     */
    public function destroy(PortfolioItem $portfolioItem)
    {
        $this->authorize('delete', $portfolioItem);

        // Delete associated files
        if ($portfolioItem->file_path && Storage::disk('public')->exists($portfolioItem->file_path)) {
            Storage::disk('public')->delete($portfolioItem->file_path);
        }
        
        if ($portfolioItem->thumbnail_path && Storage::disk('public')->exists($portfolioItem->thumbnail_path)) {
            Storage::disk('public')->delete($portfolioItem->thumbnail_path);
        }

        $portfolioItem->delete();

        return redirect()->route('creator.portfolio.index')
            ->with('success', 'Portfolio item deleted successfully!');
    }

    /**
     * Toggle the active status of a portfolio item.
     */
    public function toggleStatus(PortfolioItem $portfolioItem)
    {
        $this->authorize('update', $portfolioItem);
        
        $portfolioItem->update([
            'is_active' => !$portfolioItem->is_active
        ]);

        $status = $portfolioItem->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Portfolio item {$status} successfully!");
    }

    /**
     * Update the sort order of portfolio items.
     */
    public function updateOrder(Request $request)
    {
        $user = Auth::user();
        $creatorProfile = $user->creatorProfile;
        
        if (!$creatorProfile) {
            return response()->json(['error' => 'Creator profile not found.'], 404);
        }

        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:portfolio_items,id',
            'items.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->items as $item) {
            $portfolioItem = PortfolioItem::where('id', $item['id'])
                ->where('creator_profile_id', $creatorProfile->id)
                ->first();
                
            if ($portfolioItem) {
                $portfolioItem->update(['sort_order' => $item['sort_order']]);
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Determine file type based on MIME type.
     */
    private function getFileType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } else {
            return 'other';
        }
    }
}