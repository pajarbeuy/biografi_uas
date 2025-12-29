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
    public function index()
    {
        $biografis = Biografi::where('status', 'published')
            ->with(['category', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

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

        // Set status to draft (admin will review)
        $validated['status'] = 'draft';

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('', 'public');
            $validated['image_path'] = $imagePath;
        }

        // Remove 'image' key from validated data (it's been processed)
        unset($validated['image']);

        // Create the biography
        Biografi::create($validated);

        return redirect()->route('profile-tokoh')
            ->with('success', 'Biografi berhasil ditambahkan! Admin akan mereview sebelum dipublikasikan.');
    }
}
