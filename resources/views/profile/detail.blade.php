<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tokoh->name }} - Detail Tokoh - BIOTOMA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    @include('layouts.navbar')
    
    <div class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto">
            
            <!-- Breadcrumb / Back Button -->
            <div class="mb-6">
                <a href="{{ route('profile-tokoh') }}" class="inline-flex items-center text-gray-600 hover:text-blue-600 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar Tokoh
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Hero Section with Image & Basic Info -->
                <div class="md:flex">
                    <!-- Image Section -->
                    <div class="md:w-1/3 h-64 md:h-auto relative bg-gray-200">
                        @if($tokoh->image_path)
                            <img src="{{ asset('storage/' . $tokoh->image_path) }}" 
                                 alt="{{ $tokoh->name }}" 
                                 class="w-full h-full object-cover absolute inset-0">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Header Info Section -->
                    <div class="md:w-2/3 p-8 bg-blue-900 text-white flex flex-col justify-center">
                        <div class="mb-2">
                             <span class="inline-block bg-blue-700 bg-opacity-50 text-blue-100 text-xs px-3 py-1 rounded-full uppercase tracking-wide font-semibold">
                                {{ $tokoh->category->name ?? 'Matematikawan' }}
                            </span>
                        </div>
                        <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $tokoh->name }}</h1>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-blue-100 text-sm">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $tokoh->birth_place ?? '-' }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>
                                    {{ $tokoh->birth_date ? \Carbon\Carbon::parse($tokoh->birth_date)->translatedFormat('d F Y') : '?' }} 
                                    - 
                                    {{ $tokoh->death_date ? \Carbon\Carbon::parse($tokoh->death_date)->translatedFormat('d F Y') : 'Sekarang' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-8 md:p-12">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        
                        <!-- Main Content: Life Story -->
                        <div class="lg:col-span-2 space-y-8">
                            <section>
                                <h2 class="flex items-center text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">
                                    <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    Kisah Hidup
                                </h2>
                                <div class="prose prose-lg text-gray-600 leading-relaxed text-justify">
                                    {{-- Render HTML content from rich text editor --}}
                                    {!! $tokoh->life_story !!}
                                </div>
                            </section>
                        </div>

                        <!-- Sidebar: Achievements & Details -->
                        <div class="space-y-8">
                            
                            <!-- Achievements Card -->
                            <div class="bg-blue-50 bg-opacity-50 rounded-xl p-6 border border-blue-100">
                                <h3 class="flex items-center text-lg font-bold text-blue-900 mb-4">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                    Prestasi Utama
                                </h3>
                                @if($tokoh->achievements)
                                    <div class="prose prose-sm text-gray-700">
                                        <ul class="list-disc list-inside space-y-2">
                                            {{-- Assuming achievements might be newline separated or just text --}}
                                            @foreach(explode("\n", $tokoh->achievements) as $achievement)
                                                @if(trim($achievement))
                                                    <li>{{ $achievement }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <p class="text-gray-500 italic text-sm">Data prestasi belum ditambahkan.</p>
                                @endif
                            </div>

                            <!-- Additional Info Card -->
                            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Tambahan</h3>
                                <div class="space-y-4 text-sm">
                                    <div>
                                        <p class="text-gray-500 mb-1">Diperbarui pada</p>
                                        <p class="font-medium text-gray-900">{{ $tokoh->updated_at->diffForHumans() }}</p>
                                    </div>
                                    @if($tokoh->created_at)
                                        <div>
                                            <p class="text-gray-500 mb-1">Ditambahkan pada</p>
                                            <p class="font-medium text-gray-900">{{ $tokoh->created_at->format('d M Y') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Footer -->
            <div class="mt-8 flex justify-between items-center text-sm text-gray-500">
                <a href="{{ route('profile-tokoh') }}" class="hover:text-blue-600 transition-colors">&larr; Lihat Tokoh Lainnya</a>
            </div>

        </div>
    </div>

    @include('layouts.footer')
</body>
</html>