<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pekerjaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="">
    @include('layouts.navbar')

    <div class="">
        <!-- Header -->
        <div class="">
            <h1 class="">
                Daftar Pekerjaan
            </h1>
            <a href="{{ route('pekerjaan.create') }}" 
               class="">
                 Tambah Pekerjaan
            </a>
        </div>

        <!-- Table -->
        @if($items->count() > 0)
        <div class="">
            <table class="">
                <thead class="">
                    <tr>
                        <th class="">No</th>
                        <th class="">Nama Pekerjaan</th>
                        <th class="">Deskripsi</th>
                        <th class="">Perusahaan</th>
                        <th class="">Aksi</th>
                    </tr>
                </thead>
                <tbody class="gap-2">
                    @foreach ($items as $index => $i)
                    <tr class="">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $i->nama_pekerjaan }}</td>
                        <td class="px-4 py-2">{{ Str::limit($i->deskripsi_pekerjaan, 50) }}</td>
                        <td class="px-4 py-2">{{ $i->nama_perusahaan }}</td>
                        <td class="px-4 py-2">
                            <div class="">
                                <a href="{{ route('pekerjaan.show', $i->id) }}" 
                                   class="">
                                    | Lihat
                                </a>
                                <a href="{{ route('pekerjaan.edit', $i->id) }}" 
                                   class="">
                                    | Ubah
                                </a>
                                <form action="{{ route('pekerjaan.destroy', $i->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="">
                                        | Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center">
            <div class=""></div>
            <h3 class="">Belum ada data pekerjaan</h3>
            <p class="">Klik tombol "Tambah Pekerjaan" untuk menambahkan data baru.</p>
        </div>
        @endif
    </div>

    @include('layouts.footer')
</body>
</html>