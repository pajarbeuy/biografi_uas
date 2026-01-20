<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pekerjaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 min-h-screen">
    @include('layouts.navbar')

    <div class="max-w-2xl mx-auto px-4 pt-24 pb-12">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('pekerjaan.index') }}" class="text-purple-400 hover:text-purple-300 transition-colors mb-4 inline-block">
                ← Kembali ke Daftar
            </a>
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                Tambah Pekerjaan
            </h1>
        </div>

        <!-- Form -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 shadow-2xl">
            <form action="{{ route('pekerjaan.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="nama_pekerjaan" class="block text-sm font-medium text-gray-300 mb-2">
                        Nama Pekerjaan
                    </label>
                    <input type="text" name="nama_pekerjaan" id="nama_pekerjaan" required
                           class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                           placeholder="Masukkan nama pekerjaan...">
                </div>

                <div>
                    <label for="deskripsi_pekerjaan" class="block text-sm font-medium text-gray-300 mb-2">
                        Deskripsi Pekerjaan
                    </label>
                    <textarea name="deskripsi_pekerjaan" id="deskripsi_pekerjaan" rows="4" required
                              class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 resize-none"
                              placeholder="Masukkan deskripsi pekerjaan..."></textarea>
                </div>

                <div>
                    <label for="nama_perusahaan" class="block text-sm font-medium text-gray-300 mb-2">
                        Nama Perusahaan
                    </label>
                    <input type="text" name="nama_perusahaan" id="nama_perusahaan" required
                           class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                           placeholder="Masukkan nama perusahaan...">
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-purple-500/50 hover:-translate-y-1 transition-all duration-300">
                        💾 Simpan
                    </button>
                    <a href="{{ route('pekerjaan.index') }}" 
                       class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-xl hover:bg-gray-500 transition-all duration-200 text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    @include('layouts.footer')
</body>
</html>