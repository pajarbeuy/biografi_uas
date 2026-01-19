<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * Provider untuk konfigurasi Filament Admin Panel
 * 
 * Provider ini mengkonfigurasi panel admin Filament dengan pengaturan:
 * - Path: /admin
 * - Autentikasi menggunakan web guard
 * - Auto-discovery untuk Resources, Pages, dan Widgets
 * - Custom navigation items (link ke homepage)
 * - Sidebar collapsible di desktop
 * 
 * Panel ini hanya dapat diakses oleh user dengan role 'admin' atau 'superadmin'
 * sesuai dengan method canAccessPanel() di model User.
 */
class AdminPanelProvider extends PanelProvider
{
    /**
     * Konfigurasi panel Filament
     * 
     * Method ini mengembalikan konfigurasi lengkap untuk admin panel meliputi:
     * - ID dan path panel (/admin)
     * - Halaman login default Filament
     * - Brand name yang ditampilkan di panel
     * - Authentication guard (web)
     * - Warna tema (primary = blue)
     * - Auto-discovery resources, pages, dan widgets dari direktori app/Filament
     * - Custom navigation items (Home link)
     * - Middleware stack untuk security dan session management
     * 
     * @param Panel $panel Instance panel yang akan dikonfigurasi
     * @return Panel Panel yang sudah dikonfigurasi
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin') // Main admin panel
            ->login()
            ->brandName('Admin BIOTOMA')
            ->authGuard('web')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->navigationItems([
                NavigationItem::make('Home')
                    ->url(fn (): string => route('home'))
                    ->icon('heroicon-o-home')
                    ->sort(2),
            ])
            ->sidebarCollapsibleOnDesktop()
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
