<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-indigo-600">Admin Panel</h1>
            </div>

            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-600 border-r-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m-4 4L9 9"></path>
                        </svg>
                        Dashboard
                    </span>
                </a>

                <a href="{{ route('admin.biografis.index') }}" class="block px-6 py-3 {{ request()->routeIs('admin.biografis.*') ? 'bg-indigo-50 text-indigo-600 border-r-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                        Biografi
                    </span>
                </a>

                @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.categories.index') }}" class="block px-6 py-3 {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-50 text-indigo-600 border-r-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Kategori
                    </span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="block px-6 py-3 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-50 text-indigo-600 border-r-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Management User
                    </span>
                </a>
                @endif

                <a href="{{ route('home') }}" class="block px-6 py-3 text-gray-700 hover:bg-gray-50">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Kembali ke Home
                    </span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="px-6 py-3">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-600 hover:bg-red-50 rounded px-2 py-2 flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Top Bar -->
            <div class="bg-white shadow">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">@yield('page-title')</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">{{ Auth::user()->name }}</span>
                        <span class="bg-indigo-100 text-indigo-800 text-xs px-3 py-1 rounded-full">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-6">
                @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
