<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Biografi - BIOTOMA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom gradient background */
        .bio-gradient {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 50%, #fcd34d 100%);
        }
        
        /* Image preview container */
        .image-preview {
            display: none;
            margin-top: 1rem;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .image-preview.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 min-h-screen">
    @include('layouts.navbar')
    
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-5xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full mb-4 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <h1 class="text-5xl font-bold bg-gradient-to-r from-amber-700 via-orange-600 to-amber-700 bg-clip-text text-transparent mb-3">
                    Edit Biografi
                </h1>
                <p class="text-lg text-amber-800/80 max-w-2xl mx-auto">
                    Perbarui informasi biografi yang telah Anda submit
                </p>
                
                <!-- Status Badge -->
                <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium
                    @if($biografi->status === 'draft')
                        bg-gray-100 text-gray-800
                    @else
                        bg-red-100 text-red-800
                    @endif">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Biografi akan direview ulang oleh admin setelah diupdate
                </div>
            </div>
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 p-5 mb-8 rounded-xl shadow-md">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-800 p-5 mb-8 rounded-xl shadow-md">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 mr-3 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="font-semibold mb-2">Terdapat kesalahan pada form:</p>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Form Card -->
            <form action="{{ route('user.biografi.update', $biografi->id) }}" method="POST" enctype="multipart/form-data" 
                  class="bg-white/90 backdrop-blur-sm shadow-2xl rounded-3xl overflow-hidden border border-amber-100">
                @csrf
                @method('PUT')
                
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-amber-500 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informasi Tokoh
                    </h2>
                    <p class="text-amber-50 mt-1 text-sm">Perbarui data biografi dengan teliti dan akurat</p>
                </div>
                
                <div class="p-8 md:p-10">
                    <!-- Grid Layout for Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Nama Tokoh -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-bold text-amber-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Nama Tokoh <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $biografi->name) }}"
                                   class="w-full px-5 py-3.5 border-2 border-amber-200 rounded-xl focus:ring-4 focus:ring-amber-300 focus:border-amber-500 transition-all duration-200 bg-white/50 placeholder-amber-300 text-gray-800 font-medium @error('name') border-red-400 @enderror"
                                   placeholder="Contoh: Carl Friedrich Gauss"
                                   required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Tempat Lahir -->
                        <div>
                            <label for="birth_place" class="block text-sm font-bold text-blue-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Tempat Lahir
                            </label>
                            <input type="text" 
                                   id="birth_place" 
                                   name="birth_place" 
                                   value="{{ old('birth_place', $biografi->birth_place) }}"
                                   class="w-full px-5 py-3.5 border-2 border-amber-200 rounded-xl focus:ring-4 focus:ring-amber-300 focus:border-amber-500 transition-all duration-200 bg-white/50 placeholder-amber-300 text-gray-800 @error('birth_place') border-red-400 @enderror"
                                   placeholder="Contoh: Brunswick, Jerman">
                            @error('birth_place')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        {{-- Pendidikan --}}
                        <div class="md:col-span-2">
                            <label for="education" class="block text-sm font-bold text-blue-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                </svg>
                                Pendidikan
                            </label>
                            <textarea id="education" 
                                      name="education" 
                                      rows="4"
                                      class="w-full px-5 py-3.5 border-2 border-amber-200 rounded-xl focus:ring-4 focus:ring-amber-300 focus:border-amber-500 transition-all duration-200 bg-white/50 placeholder-amber-300 text-gray-800 resize-none @error('education') border-red-400 @enderror"
                                      placeholder="Contoh: S1 Matematika di Universitas Göttingen (1799)">{{ old('education', $biografi->education) }}</textarea>
                            @error('education')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Cabang Matematika -->
                        <div>
                            <label for="category_id" class="block text-sm font-bold text-blue-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                </svg>
                                Cabang Matematika
                            </label>
                            <select id="category_id" 
                                    name="category_id" 
                                    class="w-full px-5 py-3.5 border-2 border-amber-200 rounded-xl focus:ring-4 focus:ring-amber-300 focus:border-amber-500 transition-all duration-200 bg-white/50 text-gray-800 @error('category_id') border-red-400 @enderror">
                                <option value="">-- Pilih Cabang Matematika --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $biografi->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="birth_date" class="block text-sm font-bold text-blue-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tanggal Lahir
                            </label>
                            <input type="date" 
                                   id="birth_date" 
                                   name="birth_date" 
                                   value="{{ old('birth_date', $biografi->birth_date) }}"
                                   class="w-full px-5 py-3.5 border-2 border-amber-200 rounded-xl focus:ring-4 focus:ring-amber-300 focus:border-amber-500 transition-all duration-200 bg-white/50 text-gray-800 @error('birth_date') border-red-400 @enderror">
                            @error('birth_date')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Tanggal Meninggal -->
                        <div>
                            <label for="death_date" class="block text-sm font-bold text-blue-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tanggal Meninggal
                            </label>
                            <input type="date" 
                                   id="death_date" 
                                   name="death_date" 
                                   value="{{ old('death_date', $biografi->death_date) }}"
                                   class="w-full px-5 py-3.5 border-2 border-amber-200 rounded-xl focus:ring-4 focus:ring-amber-300 focus:border-amber-500 transition-all duration-200 bg-white/50 text-gray-800 @error('death_date') border-red-400 @enderror">
                            @error('death_date')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Prestasi -->
                        <div class="md:col-span-2">
                            <label for="achievements" class="block text-sm font-bold text-blue-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                Prestasi & Kontribusi
                            </label>
                            <textarea id="achievements" 
                                      name="achievements" 
                                      rows="5"
                                      class="w-full px-5 py-3.5 border-2 border-amber-200 rounded-xl focus:ring-4 focus:ring-amber-300 focus:border-amber-500 transition-all duration-200 bg-white/50 placeholder-amber-300 text-gray-800 resize-none @error('achievements') border-red-400 @enderror"
                                      placeholder="Contoh: Menemukan teorema dasar aljabar, mengembangkan distribusi normal dalam statistika...">{{ old('achievements', $biografi->achievements) }}</textarea>
                            @error('achievements')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Kisah Hidup -->
                        <div class="md:col-span-2">
                            <label for="life_story" class="block text-sm font-bold text-blue-900 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                Kisah Hidup <span class="text-red-500 ml-1">*</span>
                            </label>
                            <textarea id="life_story" 
                                      name="life_story" 
                                      rows="12"
                                      class="w-full px-5 py-3.5 border-2 border-amber-200 rounded-xl focus:ring-4 focus:ring-amber-300 focus:border-amber-500 transition-all duration-200 bg-white/50 placeholder-amber-300 text-gray-800 resize-none @error('life_story') border-red-400 @enderror"
                                      placeholder="Ceritakan perjalanan hidup tokoh dari masa kecil hingga karya terbesarnya. Tulis dengan detail dan inspiratif..."
                                      required>{{ old('life_story', $biografi->life_story) }}</textarea>
                            @error('life_story')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        {{-- Referensi / Sumber --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-blue-900 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                Referensi / Sumber (Opsional)
                            </label>
                            <p class="text-sm text-blue-700 mb-4">Tambahkan sumber referensi yang Anda gunakan untuk menulis biografi ini.</p>
                            
                            <div id="references-container" class="space-y-4">
                                {{-- Pre-populate existing references --}}
                                @if($biografi->references && $biografi->references->count() > 0)
                                    @foreach($biografi->references as $index => $reference)
                                        <div class="reference-item bg-gray-50 p-4 rounded-lg border-2 border-gray-200">
                                            <div class="flex justify-between items-center mb-3">
                                                <h4 class="font-semibold text-gray-700">Referensi {{ $index + 1 }}</h4>
                                                <button type="button" onclick="removeReference(this)" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                <div class="md:col-span-2">
                                                    <input type="text" name="references[{{ $index }}][title]" value="{{ $reference->title }}" placeholder="Judul Referensi *" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                                </div>
                                                <div>
                                                    <input type="text" name="references[{{ $index }}][author]" value="{{ $reference->author }}" placeholder="Penulis" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                </div>
                                                <div>
                                                    <input type="text" name="references[{{ $index }}][year]" value="{{ $reference->year }}" placeholder="Tahun" maxlength="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                </div>
                                                <div class="md:col-span-2">
                                                    <input type="url" name="references[{{ $index }}][url]" value="{{ $reference->url }}" placeholder="URL Sumber" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                </div>
                                                <div class="md:col-span-2">
                                                    <select name="references[{{ $index }}][type]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                        <option value="website" {{ $reference->type == 'website' ? 'selected' : '' }}>Website</option>
                                                        <option value="book" {{ $reference->type == 'book' ? 'selected' : '' }}>Buku</option>
                                                        <option value="paper" {{ $reference->type == 'paper' ? 'selected' : '' }}>Paper/Jurnal</option>
                                                        <option value="article" {{ $reference->type == 'article' ? 'selected' : '' }}>Artikel</option>
                                                        <option value="other" {{ $reference->type == 'other' ? 'selected' : '' }}>Lainnya</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <button type="button" 
                                    onclick="addReference()" 
                                    class="mt-3 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-lg hover:from-blue-600 hover:to-cyan-600 transition-all duration-200 font-medium shadow-md hover:shadow-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Tambah Referensi
                            </button>
                        </div>
                        
                        <!-- Foto Tokoh -->
                        <div class="md:col-span-2">
                            <label for="image" class="block text-sm font-bold text-blue-900 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Foto Tokoh
                            </label>
                            
                            <!-- Current Image -->
                            @if($biografi->image_path)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                                    <img src="{{ asset('storage/' . $biografi->image_path) }}" alt="{{ $biografi->name }}" class="w-48 h-48 object-cover rounded-xl border-4 border-amber-300 shadow-md">
                                    <p class="text-sm text-amber-600 mt-2">Upload foto baru untuk mengganti foto lama (opsional)</p>
                                </div>
                            @endif
                            
                            <div class="flex flex-col items-center justify-center w-full">
                                <label for="image" class="flex flex-col items-center justify-center w-full h-48 border-3 border-amber-300 border-dashed rounded-2xl cursor-pointer bg-gradient-to-br from-amber-50 to-orange-50 hover:from-amber-100 hover:to-orange-100 transition-all duration-300 group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-12 h-12 mb-3 text-amber-500 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                        <p class="mb-2 text-base font-semibold text-amber-700">
                                            <span class="font-bold">Klik untuk upload</span> atau drag & drop
                                        </p>
                                        <p class="text-sm text-amber-600">PNG, JPG atau JPEG (MAX. 2MB)</p>
                                        <p id="file-name" class="mt-3 text-sm font-medium text-amber-800"></p>
                                    </div>
                                </label>
                                <input type="file" 
                                       id="image" 
                                       name="image" 
                                       accept="image/*"
                                       class="hidden"
                                       onchange="previewImage(event)">
                                       
                                <!-- Image Preview -->
                                <div id="image-preview" class="image-preview w-full mt-4">
                                    <img id="preview-img" src="" alt="Preview" class="w-full max-w-md mx-auto h-auto rounded-2xl border-4 border-amber-300">
                                    <button type="button" onclick="removeImage()" class="mt-3 mx-auto block px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium transition-colors">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus Gambar Baru
                                    </button>
                                </div>
                            </div>
                            
                            @error('image')
                                <p class="mt-2 text-sm text-red-600 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-12 pt-8 border-t-2 border-amber-100">
                        <p class="text-sm text-amber-800 flex items-center order-2 sm:order-1">
                            <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-red-500 font-bold">*</span> = Field wajib diisi
                        </p>
                        
                        <div class="flex items-center gap-4 order-1 sm:order-2">
                            <a href="{{ route('user.dashboard') }}" 
                               class="px-8 py-3.5 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 rounded-xl hover:from-gray-200 hover:to-gray-300 transition-all duration-200 font-semibold shadow-md hover:shadow-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-8 py-3.5 bg-gradient-to-r from-amber-500 via-orange-500 to-amber-500 text-white rounded-xl hover:from-amber-600 hover:via-orange-600 hover:to-amber-600 transition-all duration-200 font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Biografi
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- Helper Tips Card -->
            <div class="mt-8 bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-400 rounded-xl p-6 shadow-md">
                <h3 class="font-bold text-amber-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informasi
                </h3>
                <ul class="text-sm text-amber-800 space-y-1.5 ml-7">
                    <li>• Setelah Anda update biografi, status akan berubah menjadi "Pending" untuk direview ulang oleh admin</li>
                    <li>• Pastikan data yang Anda masukkan akurat dan sesuai dengan fakta</li>
                    <li>• Foto akan tetap menggunakan foto lama jika Anda tidak mengupload foto baru</li>
                </ul>
            </div>
        </div>
    </div>

    @include('layouts.footer')
    
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            const fileName = document.getElementById('file-name');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.add('active');
                    fileName.textContent = '';
                }
                reader.readAsDataURL(file);
            }
        }
        
        function removeImage() {
            const preview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            const fileInput = document.getElementById('image');
            const fileName = document.getElementById('file-name');
            
            preview.classList.remove('active');
            previewImg.src = '';
            fileInput.value = '';
            fileName.textContent = '';
        }
        
        // References management
        let referenceCounter = {{ $biografi->references ? $biografi->references->count() : 0 }};
        
        function addReference() {
            const container = document.getElementById('references-container');
            const newReference = `
                <div class="reference-item bg-gray-50 p-4 rounded-lg border-2 border-gray-200">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-semibold text-gray-700">Referensi ${referenceCounter + 1}</h4>
                        <button type="button" onclick="removeReference(this)" class="text-red-600 hover:text-red-800 font-medium text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="md:col-span-2">
                            <input type="text" name="references[${referenceCounter}][title]" placeholder="Judul Referensi *" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <input type="text" name="references[${referenceCounter}][author]" placeholder="Penulis" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <input type="text" name="references[${referenceCounter}][year]" placeholder="Tahun" maxlength="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <input type="url" name="references[${referenceCounter}][url]" placeholder="URL Sumber" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <select name="references[${referenceCounter}][type]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="website">Website</option>
                                <option value="book">Buku</option>
                                <option value="paper">Paper/Jurnal</option>
                                <option value="article">Artikel</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newReference);
            referenceCounter++;
        }
        
        function removeReference(button) {
            button.closest('.reference-item').remove();
        }
    </script>
</body>
</html>
