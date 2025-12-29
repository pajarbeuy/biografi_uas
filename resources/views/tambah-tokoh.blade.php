<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tokoh - BIOTOMA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('layouts.navbar')
    
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Tambah Tokoh Matematikawan</h1>
            <p class="text-gray-600 mb-8">Kontribusi Anda akan direview oleh admin sebelum dipublikasikan</p>
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <p class="font-medium mb-2">Terdapat kesalahan pada form:</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('tambah-tokoh.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-8">
                @csrf
                
                <!-- Grid Layout for Form Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Nama Tokoh -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Tokoh <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="Contoh: Carl Friedrich Gauss"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Tempat Lahir -->
                    <div>
                        <label for="birth_place" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tempat Lahir
                        </label>
                        <input type="text" 
                               id="birth_place" 
                               name="birth_place" 
                               value="{{ old('birth_place') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('birth_place') border-red-500 @enderror"
                               placeholder="Contoh: Jerman">
                        @error('birth_place')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Cabang Matematika -->
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Cabang Matematika
                        </label>
                        <select id="category_id" 
                                name="category_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                            <option value="">-- Pilih Cabang --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Lahir
                        </label>
                        <input type="date" 
                               id="birth_date" 
                               name="birth_date" 
                               value="{{ old('birth_date') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('birth_date') border-red-500 @enderror">
                        @error('birth_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Tanggal Meninggal -->
                    <div>
                        <label for="death_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Meninggal
                        </label>
                        <input type="date" 
                               id="death_date" 
                               name="death_date" 
                               value="{{ old('death_date') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('death_date') border-red-500 @enderror">
                        @error('death_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Prestasi -->
                    <div class="md:col-span-2">
                        <label for="achievements" class="block text-sm font-semibold text-gray-700 mb-2">
                            Prestasi
                        </label>
                        <textarea id="achievements" 
                                  name="achievements" 
                                  rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('achievements') border-red-500 @enderror"
                                  placeholder="Tuliskan prestasi-prestasi penting tokoh...">{{ old('achievements') }}</textarea>
                        @error('achievements')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Kisah Hidup -->
                    <div class="md:col-span-2">
                        <label for="life_story" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kisah Hidup <span class="text-red-500">*</span>
                        </label>
                        <textarea id="life_story" 
                                  name="life_story" 
                                  rows="10"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('life_story') border-red-500 @enderror"
                                  placeholder="Ceritakan kisah hidup tokoh secara detail..."
                                  required>{{ old('life_story') }}</textarea>
                        @error('life_story')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Foto Tokoh -->
                    <div class="md:col-span-2">
                        <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                            Foto Tokoh
                        </label>
                        <div class="flex items-center space-x-4">
                            <label for="image" class="cursor-pointer bg-white px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 inline mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Pilih Gambar
                            </label>
                            <span id="file-name" class="text-sm text-gray-500">Belum ada file dipilih</span>
                        </div>
                        <input type="file" 
                               id="image" 
                               name="image" 
                               accept="image/*"
                               class="hidden"
                               onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'Belum ada file dipilih'">
                        <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-8 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('profile-tokoh') }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 border border-gray-300 text-black rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                        Tambah Biografi
                    </button>
                </div>
                
                <p class="mt-4 text-sm text-black text-center">
                    <span class="text-red-500">*</span> = Field wajib diisi
                </p>
            </form>
        </div>
    </div>

    @include('layouts.footer')
</body>
</html>
