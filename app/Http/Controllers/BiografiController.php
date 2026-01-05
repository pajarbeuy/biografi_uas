<?php

namespace App\Http\Controllers;

use App\Models\Biografi;
use App\Models\Category;
use App\Http\Requests\StoreBiografiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BiografiController extends Controller
{
    /**
     * Display a listing of published biographies.
     */
    public function index(Request $request)
    {
        // Build query with eager loading - only show PUBLISHED to public
        $query = Biografi::with(['category', 'user'])
            ->where('status', 'published'); // Only published biografis are public
        
        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");
        }
        
        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Order by created date and paginate
        $biografis = $query->orderBy('created_at', 'desc')
            ->paginate(3)
            ->withQueryString();

        return view('profile-tokoh', compact('biografis'));
    }

    /**
     * Show the form for creating a new biography.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('tambah-tokoh', compact('categories'));
    }

    /**
     * Store a newly created biography in storage.
     */
    public function store(StoreBiografiRequest $request)
    {
        $validated = $request->validated();

        // Auto-generate slug from name
        $validated['slug'] = Str::slug($validated['name']);
        
        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Biografi::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Set user_id to authenticated user
        $validated['user_id'] = auth()->id();

        // Set status to pending (admin will review)
        $validated['status'] = 'pending';

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('', 'public');
            $validated['image_path'] = $imagePath;
        }

        // Remove 'image' key from validated data (it's been processed)
        unset($validated['image']);
        
        // Sanitize HTML fields to prevent XSS
        if (isset($validated['life_story'])) {
            $validated['life_story'] = clean($validated['life_story']);
        }
        if (isset($validated['achievements'])) {
            $validated['achievements'] = clean($validated['achievements']);
        }

        // Create the biography
        $biografi = Biografi::create($validated);

        // Save references if provided
        if ($request->has('references') && is_array($request->references)) {
            foreach ($request->references as $refData) {
                // Only save if title is provided
                if (!empty($refData['title'])) {
                    $biografi->references()->create([
                        'title' => $refData['title'],
                        'author' => $refData['author'] ?? null,
                        'year' => $refData['year'] ?? null,
                        'url' => $refData['url'] ?? null,
                        'type' => $refData['type'] ?? 'website',
                    ]);
                }
            }
        }

        return redirect()->route('profile-tokoh')
            ->with('success', 'Biografi berhasil ditambahkan! Admin akan mereview sebelum dipublikasikan.');
    }
    /**
     * Display the specified biography.
     */
    public function show(Biografi $tokoh)
    {
        // Allow viewing if published or approved
        if (!in_array($tokoh->status, ['published', 'approved'])) {
            abort(404);
        }
        
        // Load references
        $tokoh->load('references');
        
        // Get view count
        $viewCount = $tokoh->views()->count();
        
        // Track view for analytics
        \App\Models\BiographyView::create([
            'biografi_id' => $tokoh->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'viewed_at' => now(),
        ]);
        
        return view('profile.detail', compact('tokoh', 'viewCount'));
    }
}
