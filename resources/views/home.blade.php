@extends('layouts.app')

@section('content')
<div class="max-w-[1400px] mx-auto px-4">
    <div class="flex justify-end mb-6 items-center gap-3">
        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Demo Mode (Pilih Role):</label>
        <select id="roleSelector" onchange="switchRole(this.value)" class="bg-white border-2 border-blue-100 rounded-xl px-4 py-2 text-xs font-black text-blue-600 outline-none shadow-sm focus:border-blue-400 transition-all">
            <option value="guest">🌍 Guest (Belum Login)</option>
            <option value="user">👤 User Biasa</option>
            <option value="admin">🛠️ Admin</option>
            <option value="adminsuper">👑 Super Admin</option>
        </select>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="flex-1">
            <div class="flex flex-wrap gap-3 mb-8 bg-white p-4 rounded-3xl shadow-sm border border-gray-100">
                <input type="text" placeholder="Cari Tokoh..." class="flex-1 min-w-[200px] bg-gray-50 border-none rounded-2xl px-5 py-3 outline-none focus:ring-2 focus:ring-blue-100">
                <div class="flex gap-2">
                    <button class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200">Semua</button>
                    <button class="px-6 py-2 bg-white border border-gray-100 rounded-xl text-sm font-semibold hover:bg-gray-50">Aljabar</button>
                    <button class="px-6 py-2 bg-white border border-gray-100 rounded-xl text-sm font-semibold hover:bg-gray-50">Kalkulus</button>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @php
                    $tokohs = [
                        ['nama' => 'Alvin', 'bidang' => 'Aljabar', 'bio' => 'Tokoh penting dalam pengembangan teori Aljabar modern.'],
                        ['nama' => 'Aldy', 'bidang' => 'Kalkulus', 'bio' => 'Kontributor besar dalam penemuan rumus Kalkulus dasar.'],
                        ['nama' => 'Pajar', 'bidang' => 'Geometri', 'bio' => 'Ahli geometri yang memetakan struktur ruang kompleks.'],
                        ['nama' => 'Sofyan', 'bidang' => 'Statistik', 'bio' => 'Pakar statistik yang menemukan metode analisis data baru.'],
                        ['nama' => 'Budi', 'bidang' => 'Logika', 'bio' => 'Pelopor logika matematika dalam sistem komputasi.'],
                    ];
                @endphp

                @foreach(array_merge($tokohs, $tokohs) as $index => $t)
                <div onclick="updateDetail('{{ $t['nama'] }}', '{{ $t['bidang'] }}', '{{ $t['bio'] }}')" 
                     class="bg-white p-5 rounded-[2rem] shadow-sm border border-gray-50 text-center hover:scale-105 transition-all cursor-pointer group">
                    <div class="w-20 h-20 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center text-xl font-black text-gray-400 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        {{ substr($t['nama'], 0, 2) }}
                    </div>
                    <h4 class="font-bold text-gray-800 text-sm">{{ $t['nama'] }} {{ $index + 1 }}</h4>
                    <p class="text-[10px] text-blue-400 uppercase font-bold tracking-tighter">{{ $t['bidang'] }}</p>
                </div>
                @endforeach
            </div>
            
            <div class="flex gap-3 mt-10">
                <button class="px-10 py-4 bg-white border border-gray-200 rounded-2xl text-sm font-bold hover:bg-gray-50">Prev</button>
                <button class="px-10 py-4 bg-blue-600 text-white rounded-2xl text-sm font-bold shadow-xl shadow-blue-100">Next</button>
            </div>
        </div>

        <div class="w-full lg:w-[380px] flex flex-col gap-6">
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
                <h3 class="font-black text-xs uppercase tracking-[0.2em] text-gray-300 mb-6">Detail Tokoh</h3>
                <div class="flex items-center gap-5 mb-8">
                    <div id="detail-circle" class="w-24 h-24 bg-blue-50 rounded-3xl flex items-center justify-center text-3xl font-black text-blue-600">DT</div>
                    <div>
                        <h4 id="detail-nama" class="font-black text-2xl text-gray-800 leading-none">Pilih Tokoh</h4>
                        <p id="detail-bidang" class="text-xs font-bold text-blue-400 mt-2">KLIK KARTU DI KIRI</p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-3xl p-6">
                    <h5 class="text-xs font-black text-gray-400 uppercase mb-2">Biografi Singkat</h5>
                    <p id="detail-bio" class="text-sm text-gray-500 leading-relaxed italic">Silakan pilih salah satu tokoh untuk melihat sejarah singkatnya di sini.</p>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
                <h3 class="font-black text-xs uppercase tracking-[0.2em] text-gray-300 mb-6">Menu & Hak Akses</h3>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-sm font-bold text-gray-600 hover:text-blue-600 cursor-pointer transition-colors">🏠 Beranda</li>
                    <li onclick="alert('FAQ: Siapa pencipta Aljabar?\nJawab: Muhammad bin Musa al-Khawarizmi')" class="flex items-center gap-3 text-sm font-bold text-gray-600 hover:text-blue-600 cursor-pointer transition-colors">❓ FAQ</li>
                    
                    <div id="dynamicButtons" class="pt-4 space-y-3"></div>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
// FUNGSI GANTI ROLE TANPA DATABASE
function switchRole(role) {
    const container = document.getElementById('dynamicButtons');
    container.innerHTML = '<hr class="border-dashed border-gray-100 my-4">';

    if (role === 'user') {
        container.innerHTML += '<li class="p-4 bg-blue-50 text-blue-600 rounded-2xl text-xs font-black flex items-center justify-between">📝 INPUT BIOGRAFI <span class="bg-blue-200 px-2 py-1 rounded-lg text-[8px]">USER</span></li>';
    } 
    else if (role === 'admin') {
        container.innerHTML += '<li class="p-4 bg-green-50 text-green-600 rounded-2xl text-xs font-black mb-2 flex items-center justify-between">✅ PUBLISH USER <span class="bg-green-200 px-2 py-1 rounded-lg text-[8px]">ADMIN</span></li>';
        container.innerHTML += '<li class="p-4 bg-blue-50 text-blue-600 rounded-2xl text-xs font-black flex items-center justify-between">📝 BUAT BIOGRAFI <span class="bg-blue-200 px-2 py-1 rounded-lg text-[8px]">ADMIN</span></li>';
    } 
    else if (role === 'adminsuper') {
        container.innerHTML += '<li class="p-4 bg-red-50 text-red-600 rounded-2xl text-xs font-black mb-2 flex items-center justify-between">⚠️ HAPUS AKUN <span class="bg-red-200 px-2 py-1 rounded-lg text-[8px]">S.ADMIN</span></li>';
        container.innerHTML += '<li class="p-4 bg-orange-50 text-orange-600 rounded-2xl text-xs font-black mb-2 flex items-center justify-between">➕ TAMBAH KATEGORI <span class="bg-orange-200 px-2 py-1 rounded-lg text-[8px]">S.ADMIN</span></li>';
        container.innerHTML += '<li class="p-4 bg-blue-50 text-blue-600 rounded-2xl text-xs font-black flex items-center justify-between">📝 MASUKKAN BIOGRAFI <span class="bg-blue-200 px-2 py-1 rounded-lg text-[8px]">S.ADMIN</span></li>';
    } else {
        container.innerHTML = ''; // Guest kosong
    }
}

// FUNGSI UPDATE DETAIL TOKOH
function updateDetail(nama, bidang, bio) {
    document.getElementById('detail-nama').innerText = nama;
    document.getElementById('detail-bidang').innerText = bidang;
    document.getElementById('detail-bio').innerText = bio;
    document.getElementById('detail-circle').innerText = nama.substring(0, 2).toUpperCase();
}
</script>
@endsection
