<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;

/**
 * Model User
 * 
 * Model ini merepresentasikan pengguna dalam sistem dengan integrasi Spatie Permission
 * untuk manajemen role dan permission. Sistem mendukung 3 role utama:
 * - superadmin: Akses penuh ke semua fitur termasuk manajemen user dan kategori
 * - admin: Akses ke panel admin untuk manajemen biografi dan approval
 * - user: Akses terbatas untuk membuat dan mengedit biografi sendiri
 * 
 * Sistem menggunakan dua mekanisme role checking:
 * 1. Spatie Permission (recommended): Menggunakan tabel roles & permissions
 * 2. Fallback ke kolom 'role': Untuk backward compatibility
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role Role pengguna (user/admin/superadmin) - untuk fallback
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Biografi[] $biografis
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 */
class User extends Authenticatable implements FilamentUser
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Cek apakah user adalah Super Admin
     * 
     * Method ini memeriksa role superadmin menggunakan dua cara:
     * 1. Menggunakan Spatie Permission (hasRole) - prioritas utama
     * 2. Fallback ke kolom 'role' di database - untuk backward compatibility
     * 
     * @return bool True jika user adalah superadmin
     */
    public function isSuperAdmin()
    {
        // Use Spatie's hasRole if roles are assigned, fallback to column
        return $this->hasRole('superadmin') || $this->role === 'superadmin';
    }

    /**
     * Cek apakah user adalah Admin
     * 
     * Method ini memeriksa role admin menggunakan dua cara:
     * 1. Menggunakan Spatie Permission (hasRole) - prioritas utama
     * 2. Fallback ke kolom 'role' di database - untuk backward compatibility
     * 
     * @return bool True jika user adalah admin
     */
    public function isAdmin()
    {
        // Use Spatie's hasRole if roles are assigned, fallback to column
        return $this->hasRole('admin') || $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah User biasa
     * 
     * Method ini memeriksa role user menggunakan dua cara:
     * 1. Menggunakan Spatie Permission (hasRole) - prioritas utama
     * 2. Fallback ke kolom 'role' di database - untuk backward compatibility
     * 
     * @return bool True jika user adalah user biasa (bukan admin/superadmin)
     */
    public function isUser()
    {
        // Use Spatie's hasRole if roles are assigned, fallback to column
        return $this->hasRole('user') || $this->role === 'user';
    }

    /**
     * Override method hasRole dari Spatie Permission dengan fallback ke kolom 'role'
     * 
     * Method ini meng-override hasRole dari trait HasRoles (Spatie Permission) untuk
     * menambahkan backward compatibility dengan sistem lama yang menggunakan kolom 'role'.
     * 
     * Alur pengecekan:
     * 1. Coba gunakan method hasRole dari Spatie (parent class)
     * 2. Jika berhasil dan return true, langsung return true
     * 3. Jika gagal atau return false, lanjut ke fallback
     * 4. Fallback: Cek kolom 'role' di database secara manual
     * 
     * @param string|array $roles Role atau array of roles yang ingin dicek
     * @param string|null $guard Guard yang digunakan (default: null)
     * @return bool True jika user memiliki salah satu role yang dicek
     */
    public function hasRole($roles, string $guard = null): bool
    {
        // First check using Spatie's method
        if (method_exists(get_parent_class($this), 'hasRole')) {
            try {
                if (parent::hasRole($roles, $guard)) {
                    return true;
                }
            } catch (\Exception $e) {
                // If Spatie check fails, continue to fallback
            }
        }
        
        // Fallback to manual column check for backward compatibility
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }
        return $this->role === $roles;
    }

    /**
     * Tentukan apakah user dapat mengakses Filament admin panel
     * 
     * Method ini digunakan oleh Filament untuk authorization.
     * Hanya user dengan role 'admin' atau 'superadmin' yang dapat mengakses panel.
     * User dengan role 'user' tidak dapat mengakses Filament admin panel.
     * 
     * @param Panel $panel Instance panel Filament yang ingin diakses
     * @return bool True jika user memiliki akses ke panel
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    /**
     * Relasi ke model Biografi
     * 
     * Satu user dapat memiliki banyak biografi yang mereka buat.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function biografis()
    {
        return $this->hasMany(Biografi::class);
    }
}