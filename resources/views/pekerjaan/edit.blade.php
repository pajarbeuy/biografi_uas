<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pekerjaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="">
    @include('layouts.navbar')

    <div class="">
        <!-- Header -->
        <div class="">
            <a href="{{ route('pekerjaan.index') }}" class="">
                ← Kembali ke Daftar
            </a>
            <h1 class="">
                Edit Pekerjaan
            </h1>
        </div>

        <!-- Form -->
        <div class="">
            <form action="{{ route('pekerjaan.update', $item->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="nama_pekerjaan" class="">
                        Nama Pekerjaan
                    </label>
                    <input type="text" name="nama_pekerjaan" id="nama_pekerjaan" required
                           value="{{ $item->nama_pekerjaan }}"
                           class="">
                </div>

                <div>
                    <label for="deskripsi_pekerjaan" class="">
                        Deskripsi Pekerjaan
                    </label>
                    <textarea name="deskripsi_pekerjaan" id="deskripsi_pekerjaan" rows="4" required
                              class="">{{ $item->deskripsi_pekerjaan }}</textarea>
                </div>

                <div>
                    <label for="nama_perusahaan" class="">
                        Nama Perusahaan
                    </label>
                    <input type="text" name="nama_perusahaan" id="nama_perusahaan" required
                           value="{{ $item->nama_perusahaan }}"
                           class="">
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" 
                            class="">
                        Update
                    </button>
                    <a href="{{ route('pekerjaan.index') }}" 
                       class="">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    @include('layouts.footer')
</body>
</html>