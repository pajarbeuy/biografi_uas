<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Tokoh - BIOTOMA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('layouts.navbar')
    
    <div class="container mx-auto px-4 py-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Profil Tokoh Matematikawan</h1>
        <p class="text-gray-600 mb-8">Kumpulan biografi matematikawan terkenal di dunia</p>
        
        @if($biografis->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($biografis as $biografi)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <!-- Foto Tokoh -->
                        <div class="aspect-square bg-gray-200 flex items-center justify-center overflow-hidden relative group">
                            <a href="{{ route('profile-tokoh.show', $biografi->slug) }}" class="block w-full h-full relative">
                                @if($biografi->image_path)
                                    <img src="{{ asset('storage/' . $biografi->image_path) }}" 
                                         alt="{{ $biografi->name }}"
                                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                @endif
                                <!-- Overlay hint removed to avoid black box issue -->
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="bg-black bg-opacity-50 text-white px-3 py-1 rounded-full text-sm">Lihat Detail</span>
                                </div>
                            </a>
                        </div>
                        
                        <!-- Info Tokoh -->
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $biografi->name }}</h3>
                            
                            @if($biografi->category)
                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="font-semibold">{{ $biografi->category->name }}</span>
                                </div>
                            @endif
                            
                            @if($biografi->birth_place || $biografi->birth_date)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>
                                        @if($biografi->birth_place && $biografi->birth_date)
                                            {{ $biografi->birth_place }}, {{ $biografi->birth_date->format('Y') }}
                                        @elseif($biografi->birth_place)
                                            {{ $biografi->birth_place }}
                                        @else
                                            {{ $biografi->birth_date->format('d M Y') }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Biografi</h3>
                <p class="text-gray-500">Saat ini belum ada biografi matematikawan yang dipublikasikan.</p>
            </div>
        @endif
    </div>

    @include('layouts.footer')
</body>
</html>