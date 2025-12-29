<nav class="bg-white shadow-md border-b-2 border-gray-200 mb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="/home" class="text-2xl font-bold text-black hover:text-blue-600 transition-colors">
                    BIOTOMA
                </a>
            </div>

            <!-- Main Navigation Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/home" class="text-md font-medium text-gray-700 hover:text-blue-600 transition-colors">
                    Home
                </a>
                <a href="/profile-tokoh" class="text-md font-medium text-gray-700 hover:text-blue-600 transition-colors">
                    Profile Tokoh
                </a>
                <a href="/reference" class="text-md font-medium text-gray-700 hover:text-blue-600 transition-colors">
                    Reference
                </a>
                <a href="/about-us" class="text-md font-medium text-gray-700 hover:text-blue-600 transition-colors">
                    About Us
                </a>
                <a href="/tambah-tokoh" class="text-md font-medium text-gray-700 hover:text-blue-600 transition-colors">
                    Tambah Tokoh
                </a>
                </div>

            <!-- Auth Buttons -->
            <div class="flex items-center space-x-8">
                @auth
                    <!-- User is logged in -->
                    <span class="text-sm text-black">
                        Halo, <span class="font-semibold">{{ auth()->user()->name }}</span>
                    </span>
                    
                    <!-- Dashboard Admin Link - Only for Admin & SuperAdmin -->
                    @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                        <a href="/admin" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Dashboard Admin
                        </a>
                    @endif
                    
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                @else
                    <!-- User is guest -->
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white text-sm font-semibold rounded-lg transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Login
                    </a>
                    
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border-2 border-blue-600 hover:bg-blue-700 hover:border-blue-700 text-black text-sm font-semibold rounded-lg transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
