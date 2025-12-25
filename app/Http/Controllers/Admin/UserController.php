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
    $this->authorize('updateRole', $user);

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
}

    
    public function destroy(User $user)
{
    $this->authorize('delete', $user);

    $user->delete();

    return response()->json([
        'message' => 'User berhasil dihapus'
    ]);
}

}