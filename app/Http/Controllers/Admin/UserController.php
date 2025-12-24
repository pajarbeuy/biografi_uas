<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Untuk menampilkan halaman (View)
    public function indexView()
    {
        return view('admin.users.index');
    }
    
    // Untuk API (JSON Response)
    public function index()
    {
        try {
            $users = User::select('id', 'name', 'email', 'role', 'created_at')
                ->orderBy('created_at', 'desc')
                ->get();
                
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal memuat data user',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function updateRole(Request $request, User $user)
    {
        try {
            abort_if($user->role === 'superadmin', 403, "Superadmin tidak bisa diubah");
            
            $request->validate([
                'role' => 'required|in:user,admin'
            ]);
            
            $user->update([
                'role' => $request->role
            ]);
            
            return response()->json([
                'message' => 'Role berhasil diupdate',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengupdate role',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function destroy(User $user)
    {
        try {
            abort_if($user->role === 'superadmin', 403, "Superadmin tidak bisa dihapus");
            abort_if($user->id === auth()->id(), 403, "Tidak bisa menghapus akun sendiri");
            
            $user->delete();
            
            return response()->json([
                'message' => 'User berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal menghapus user',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}