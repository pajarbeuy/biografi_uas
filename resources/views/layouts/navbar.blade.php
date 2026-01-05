<nav x-data="{ open: false }" class="bg-white shadow-md border-b-2 border-gray-200 mb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="/home" class="text-2xl font-bold text-black hover:text-blue-600 transition-colors">
                    BIOTOMA
                </a>
            </div>

            <!-- Main Navigation Menu (Desktop) -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/home" class="text-md font-medium text-gray-700 hover:text-blue-600 transition-colors">Home</a>
                <a href="/profile-tokoh" class="text-md font-medium text-gray-700 hover:text-blue-600 transition-colors">Profile Tokoh</a>
                <a href="/reference" class="text-md font-medium text-gray-700 hover:text-blue-600 transition-colors">Reference</a>
                <a href="/about-us" class="text-md font-medium text-gray-700 hover:text-blue-600 transition-colors">About Us</a>
                @auth
                    @if(!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin())
                        <a href="/tambah-tokoh" class="text-md font-medium text-gray-700 hover:text-blue-600 transition-colors">Tambah Tokoh</a>
                    @endif
                @endauth
            </div>

            <!-- Auth Buttons (Desktop) -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <span class="text-sm text-black">
                        Halo, <span class="font-semibold">{{ auth()->user()->name }}</span>
                    </span>
                    
                    @if(!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin())
                        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Dashboard
                        </a>
                    @endif
                    
                    @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                        <a href="/admin" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Admin
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white text-sm font-semibold rounded-lg transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border-2 border-blue-600 hover:bg-blue-700 hover:border-blue-700 text-white text-sm font-semibold rounded-lg transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Daftar
                    </a>
                @endauth
            </div>

            <!-- Hamburger Button (Mobile) -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="md:hidden bg-white border-t border-gray-100 px-4 py-4 space-y-2 pb-6">
        <a href="/home" class="block text-base font-medium text-gray-700 hover:text-blue-600 py-2">Home</a>
        <a href="/profile-tokoh" class="block text-base font-medium text-gray-700 hover:text-blue-600 py-2">Profile Tokoh</a>
        <a href="/reference" class="block text-base font-medium text-gray-700 hover:text-blue-600 py-2">Reference</a>
        <a href="/about-us" class="block text-base font-medium text-gray-700 hover:text-blue-600 py-2">About Us</a>
        <a href="/tambah-tokoh" class="block text-base font-medium text-gray-700 hover:text-blue-600 py-2">Tambah Tokoh</a>
        
        <div class="pt-4 border-t border-gray-100 space-y-3">
            @auth
                <div class="text-sm font-semibold text-gray-900 mb-2 px-1">Halo, {{ auth()->user()->name }}</div>
                @if(!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin())
                    <a href="{{ route('user.dashboard') }}" class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded-lg font-semibold">Dashboard</a>
                @endif
                @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                    <a href="/admin" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold">Admin Panel</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg font-semibold">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg font-semibold">Login</a>
                <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold">Daftar</a>
            @endauth
        </div>
    </div>
</nav>
