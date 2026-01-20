<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pekerjaan</title>
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
            <h1 class="text-center">
                Detail Pekerjaan
            </h1>
        </div>

        <!-- Detail Card -->
        <div class="">
            <div>
                <h3 class="">Nama Pekerjaan:</h3>
                <p class="">{{ $item->nama_pekerjaan }}</p>
            </div>

            <div class="">
                <h3 class="">Deskripsi</h3>
                <p class="">{{ $item->deskripsi_pekerjaan }}</p>
            </div>

            <div class="">
                <h3 class="">Nama Perusahaan</h3>
                <p class="">{{ $item->nama_perusahaan }}</p>
            </div>

            <!-- Actions -->
            <div class="">
                <a href="{{ route('pekerjaan.edit', $item->id) }}" 
                   class="">
                    Edit
                </a>
                <form action="{{ route('pekerjaan.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="">
                        Hapus
                    </button>
                </form>
                <a href="{{ route('pekerjaan.index') }}" 
                   class="">
                    Daftar
                </a>
            </div>
        </div>
    </div>

    @include('layouts.footer')
</body>
</html>