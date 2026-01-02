<?php

namespace App\Http\Controllers;

use App\Models\Biografi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Display the user's dashboard with their submitted biografi.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all biografis created by the authenticated user
        $biografis = Biografi::where('user_id', $user->id)
            ->withCount('views')
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get statistics
        $stats = [
            'total' => $biografis->count(),
            'draft' => $biografis->where('status', 'draft')->count(),
            'pending' => $biografis->where('status', 'pending')->count(),
            'approved' => $biografis->where('status', 'approved')->count(),
            'published' => $biografis->where('status', 'published')->count(),
            'rejected' => $biografis->where('status', 'rejected')->count(),
        ];
        
        return view('user.dashboard', compact('biografis', 'stats'));
    }
    
    /**
     * Show the form for editing the specified biography.
     */
    public function edit($id)
    {
        $biografi = Biografi::with('references')->findOrFail($id);
        
        // Check ownership
        if ($biografi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Only allow editing draft or rejected biografi
        if (!in_array($biografi->status, ['draft', 'rejected'])) {
            return redirect()->route('user.dashboard')
                ->with('error', 'Anda hanya dapat mengedit biografi yang berstatus Draft atau Ditolak.');
        }
        
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('user.edit-biografi', compact('biografi', 'categories'));
    }
    
    /**
     * Update the specified biography in storage.
     */
    public function update(Request $request, $id)
    {
        $biografi = Biografi::findOrFail($id);
        
        // Check ownership
        if ($biografi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Only allow updating draft or rejected biografi
        if (!in_array($biografi->status, ['draft', 'rejected'])) {
            return redirect()->route('user.dashboard')
                ->with('error', 'Anda hanya dapat mengedit biografi yang berstatus Draft atau Ditolak.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_place' => 'nullable|string|max:255',
            'education' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'death_date' => 'nullable|date|after:birth_date',
            'category_id' => 'nullable|exists:categories,id',
            'achievements' => 'nullable|string',
            'life_story' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        
        // Update slug if name changed
        if ($validated['name'] !== $biografi->name) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
            
            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Biografi::where('slug', $validated['slug'])->where('id', '!=', $id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }
        
        // Handle image upload if new image is provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($biografi->image_path) {
                \Storage::disk('public')->delete($biografi->image_path);
            }
            
            $imagePath = $request->file('image')->store('', 'public');
            $validated['image_path'] = $imagePath;
        }
        
        // Remove 'image' key from validated data
        unset($validated['image']);
        
        // Sanitize HTML fields to prevent XSS
        if (isset($validated['life_story'])) {
            $validated['life_story'] = clean($validated['life_story']);
        }
        if (isset($validated['achievements'])) {
            $validated['achievements'] = clean($validated['achievements']);
        }
        
        // Set status back to pending for review
        $validated['status'] = 'pending';
        
        $biografi->update($validated);
        
        // Update references: delete existing and create new ones
        if ($request->has('references')) {
            // Delete existing references
            $biografi->references()->delete();
            
            // Create new references
            if (is_array($request->references)) {
                foreach ($request->references as $refData) {
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
        }
        
        return redirect()->route('user.dashboard')
            ->with('success', 'Biografi berhasil diperbarui dan dikirim untuk review!');
    }
    
    /**
     * Remove the specified biography from storage.
     */
    public function destroy($id)
    {
        $biografi = Biografi::findOrFail($id);
        
        // Check ownership
        if ($biografi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Delete image if exists
        if ($biografi->image_path) {
            \Storage::disk('public')->delete($biografi->image_path);
        }
        
        $biografi->delete();
        
        return redirect()->route('user.dashboard')
            ->with('success', 'Biografi berhasil dihapus!');
    }
}
