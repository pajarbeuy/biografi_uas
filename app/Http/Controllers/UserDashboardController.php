<?php

namespace App\Http\Controllers;

use App\Models\Biografi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller untuk Dashboard User (Non-Admin)
 * 
 * Controller ini mengelola dashboard khusus untuk user biasa (role: 'user').
 * User dapat melihat dan mengelola biografi yang mereka submit sendiri.
 * 
 * Fitur:
 * - View list biografi sendiri dengan statistik
 * - Edit biografi yang berstatus draft atau rejected
 * - Delete biografi sendiri
 * - Update biografi dengan validasi dan authorization
 * 
 * Access control ketat:
 * - User hanya bisa melihat/edit/delete biografi milik mereka sendiri
 * - Ownership verification di setiap action
 * - Status restriction: Hanya draft/rejected yang bisa diedit
 */
class UserDashboardController extends Controller
{
    /**
     * Tampilkan dashboard user dengan list biografi dan statistik
     * 
     * Method ini:
     * 1. Ambil semua biografi milik user yang login
     * 2. Include relasi category dan count views
     * 3. Hitung statistik berdasarkan status:
     *    - Total biografi
     *    - Count per status (draft, pending, approved, published, rejected)
     * 4. Return view dengan data biografis dan stats
     * 
     * View: resources/views/user/dashboard.blade.php
     * 
     * @return \Illuminate\View\View View dashboard user
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
     * Tampilkan form edit biografi
     * 
     * Method ini:
     * 1. Load biografi dengan  relasi references
     * 2. Verify ownership (user_id harus match dengan Auth::id())
     * 3. Cek status: Hanya draft atau rejected yang boleh diedit
     * 4. Load daftar categories untuk dropdown
     * 5. Return view edit form
     * 
     * Authorization:
     * - 403 jika bukan pemilik biografi
     * - Redirect dengan error jika status tidak memenuhi (bukan draft/rejected)
     * 
     * @param int $id ID biografi yang akan diedit
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse View edit atau redirect
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
     * Update biografi di database
     * 
     * Method ini sangat comprehensive:
     * 
     * 1. AUTHORIZATION:
     *    - Verify ownership (user_id = Auth::id())
     *    - Cek status: Hanya draft/rejected yang bisa diupdate
     * 
     * 2. VALIDASI:
     *    - Name, birth_place, education, dates, category_id, dll
     *    - Image: max 2MB, format jpg/jpeg/png
     * 
     * 3. SLUG UPDATE:
     *    - Jika nama berubah, generate slug baru
     *    - Ensure unique slug dengan counter
     * 
     * 4. IMAGE HANDLING:
     *    - Upload image baru jika ada
     *    - Delete old image dari storage
     * 
     * 5. XSS PROTECTION:
     *    - Clean life_story dan achievements dengan helper clean()
     *    - Sanitize HTML untuk mencegah XSS attack
     * 
     * 6. REFERENCES:
     *    - Delete semua referensi lama
     *    - Create referensi baru dari input
     * 
     * 7. STATUS AUTO-CHANGE:
     *    - Setelah update, status otomatis jadi 'pending' untuk review ulang
     * 
     * @param Request $request Request dengan data biografi update
     * @param int $id ID biografi yang akan diupdate
     * @return \Illuminate\Http\RedirectResponse Redirect ke dashboard
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
     * Hapus biografi dari database
     * 
     * Method ini:
     * 1. Verify ownership (user_id = Auth::id())
     * 2. Delete image file dari storage jika ada
     * 3. Delete biografi (cascade delete references)
     * 4. Redirect ke dashboard dengan pesan sukses
     * 
     * @param int $id ID biografi yang akan dihapus
     * @return \Illuminate\Http\RedirectResponse Redirect ke dashboard
     * @throws \Symfony\Component\HttpFoundation\Exception\HttpException 403 jika bukan pemilik
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
