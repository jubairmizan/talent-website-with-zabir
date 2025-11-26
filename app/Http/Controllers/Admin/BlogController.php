<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts
     */
    public function index(Request $request)
    {
        $query = BlogPost::with(['author', 'category']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by author
        if ($request->filled('author')) {
            $query->where('author_id', $request->author);
        }

        // Sort by
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $blogPosts = $query->paginate(20)->appends($request->query());

        // Get filter options
        $categories = BlogCategory::where('is_active', true)->orderBy('name')->get();
        $authors = User::whereIn('role', ['admin', 'creator'])->orderBy('name')->get();
        $statuses = ['draft', 'published', 'pending', 'archived'];

        // Get statistics
        $stats = [
            'total' => BlogPost::count(),
            'published' => BlogPost::where('status', 'published')->count(),
            'draft' => BlogPost::where('status', 'draft')->count(),
            'pending' => BlogPost::where('status', 'pending')->count(),
        ];

        return view('admin.blog.index', compact('blogPosts', 'categories', 'authors', 'statuses', 'stats'));
    }

    /**
     * Show the form for creating a new blog post
     */
    public function create()
    {
        $categories = BlogCategory::where('is_active', true)->orderBy('name')->get();
        $authors = User::whereIn('role', ['admin', 'creator'])->orderBy('name')->get();

        return view('admin.blog.create', compact('categories', 'authors'));
    }

    /**
     * Store a newly created blog post
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'author_id' => 'required|exists:users,id',
            'status' => 'required|in:draft,published,pending,archived',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'action' => 'nullable|string|in:save_draft,publish',
        ]);
        // Handle action parameter to override status
        if ($request->has('action')) {
            if ($request->action === 'save_draft') {
                $validated['status'] = 'draft';
            } elseif ($request->action === 'publish') {
                $validated['status'] = 'published';
            }
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (BlogPost::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('blog/featured-images', $imageName, 'public');
            $validated['featured_image'] = $imagePath;
        }
        // Handle is_featured checkbox (defaults to false if not checked)
        $validated['is_featured'] = $request->has('is_featured') ? true : false;

        // Set published_at if status is published and no date is set
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Remove action from validated data before creating the post
        unset($validated['action']);

        $blogPost = BlogPost::create($validated);

        $message = $blogPost->status === 'published' ? 'Blog post published successfully!' : 'Blog post saved as draft successfully!';

        return redirect()->route('admin.blog.index')
            ->with('success', $message);
    }

    /**
     * Display the specified blog post
     */
    public function show(BlogPost $blogPost)
    {
        $blogPost->load(['author', 'category']);
        return view('admin.blog.show', compact('blogPost'));
    }

    /**
     * Show the form for editing the specified blog post
     */
    public function edit(BlogPost $blogPost)
    {
        $categories = BlogCategory::where('is_active', true)->orderBy('name')->get();
        $authors = User::whereIn('role', ['admin', 'creator'])->orderBy('name')->get();

        return view('admin.blog.edit', compact('blogPost', 'categories', 'authors'));
    }

    /**
     * Update the specified blog post
     */
    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blog_posts', 'slug')->ignore($blogPost->id)
            ],
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'author_id' => 'required|exists:users,id',
            'status' => 'required|in:draft,published,pending,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'action' => 'nullable|string|in:save_draft,update',
        ]);

        // Handle action parameter to override status
        if ($request->has('action')) {
            if ($request->action === 'save_draft') {
                $validated['status'] = 'draft';
            }
            // For 'update' action, keep the current status from the form
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure slug is unique (excluding current post)
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (BlogPost::where('slug', $validated['slug'])->where('id', '!=', $blogPost->id)->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blogPost->featured_image && Storage::disk('public')->exists($blogPost->featured_image)) {
                Storage::disk('public')->delete($blogPost->featured_image);
            }

            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('blog/featured-images', $imageName, 'public');
            $validated['featured_image'] = $imagePath;
        }

        // Set published_at if status is published and no date is set
        if ($validated['status'] === 'published' && empty($validated['published_at']) && $blogPost->status !== 'published') {
            $validated['published_at'] = now();
        }

        // Remove action from validated data before updating the post
        unset($validated['action']);

        $blogPost->update($validated);

        $message = $blogPost->status === 'published' ? 'Blog post updated and published successfully!' : 'Blog post updated successfully!';

        return redirect()->route('admin.blog.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified blog post
     */
    public function destroy(BlogPost $blogPost)
    {
        // Delete featured image if exists
        if ($blogPost->featured_image && Storage::disk('public')->exists(str_replace('/storage/', '', $blogPost->featured_image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $blogPost->featured_image));
        }

        $blogPost->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(BlogPost $blogPost)
    {
        $blogPost->update([
            'is_featured' => !$blogPost->is_featured
        ]);

        $status = $blogPost->is_featured ? 'featured' : 'unfeatured';
        return back()->with('success', "Blog post {$status} successfully!");
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,publish,draft,archive',
            'selected_posts' => 'required|array|min:1',
            'selected_posts.*' => 'exists:blog_posts,id'
        ]);

        $posts = BlogPost::whereIn('id', $request->selected_posts);

        switch ($request->action) {
            case 'delete':
                $posts->each(function ($post) {
                    if ($post->featured_image && Storage::disk('public')->exists(str_replace('/storage/', '', $post->featured_image))) {
                        Storage::disk('public')->delete(str_replace('/storage/', '', $post->featured_image));
                    }
                });
                $posts->delete();
                $message = 'Selected posts deleted successfully!';
                break;

            case 'publish':
                $posts->update([
                    'status' => 'published',
                    'published_at' => now()
                ]);
                $message = 'Selected posts published successfully!';
                break;

            case 'draft':
                $posts->update(['status' => 'draft']);
                $message = 'Selected posts moved to draft successfully!';
                break;

            case 'archive':
                $posts->update(['status' => 'archived']);
                $message = 'Selected posts archived successfully!';
                break;
        }

        return back()->with('success', $message);
    }

    /**
     * Upload image for CKEditor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('upload')) {
            $image = $request->file('upload');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('blog/content-images', $imageName, 'public');
            $imageUrl = asset('storage/' . $imagePath);

            return response()->json([
                'uploaded' => true,
                'url' => $imageUrl
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'Failed to upload image'
            ]
        ]);
    }
}