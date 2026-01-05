<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;

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

    // Helper methods untuk check role (using Spatie Permission)
    public function isSuperAdmin()
    {
        // Use Spatie's hasRole if roles are assigned, fallback to column
        return $this->hasRole('superadmin') || $this->role === 'superadmin';
    }

    public function isAdmin()
    {
        // Use Spatie's hasRole if roles are assigned, fallback to column
        return $this->hasRole('admin') || $this->role === 'admin';
    }

    public function isUser()
    {
        // Use Spatie's hasRole if roles are assigned, fallback to column
        return $this->hasRole('user') || $this->role === 'user';
    }

    /**
     * Override Spatie's hasRole to include column fallback
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
     * Determine if user can access Filament panel
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    // Relationships
    public function biografis()
    {
        return $this->hasMany(Biografi::class);
    }
}