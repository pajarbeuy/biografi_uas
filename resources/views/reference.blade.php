<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referensi Tokoh Matematika - BIOTOMA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

@include('layouts.navbar')

<!-- HEADER -->
<section class="bg-gradient-to-r from-white-600 to-indigo-700 text-black py-14">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-3">Referensi Tokoh Matematika</h1>
        <p class="text-black-100 max-w-3xl mx-auto">
            Halaman ini memuat daftar tokoh matematika berdasarkan bidang keilmuan
            yang menjadi referensi utama dalam penyusunan biografi pada sistem BIOTOMA.
        </p>
    </div>
</section>

<!-- CONTENT -->
<section class="container mx-auto px-4 py-16 space-y-14">

    <!-- ALGEBRA -->
    <div>
        <h2 class="text-2xl font-bold mb-6">1. Aljabar</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white rounded-xl shadow p-5">Al-Khwarizmi</div>
            <div class="bg-white rounded-xl shadow p-5">Évariste Galois</div>
            <div class="bg-white rounded-xl shadow p-5">Emmy Noether</div>
        </div>
    </div>

    <!-- GEOMETRI -->
    <div>
        <h2 class="text-2xl font-bold mb-6">2. Geometri</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white rounded-xl shadow p-5">
                Euclid 
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                René Descartes 
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                Bernhard Riemann 
            </div>
        </div>
    </div>

    <!-- KALKULUS -->
    <div>
        <h2 class="text-2xl font-bold mb-6">3. Kalkulus</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white rounded-xl shadow p-5">Isaac Newton</div>
            <div class="bg-white rounded-xl shadow p-5">Gottfried Wilhelm Leibniz</div>
            <div class="bg-white rounded-xl shadow p-5">Leonhard Euler</div>
        </div>
    </div>

    <!-- STATISTIKA -->
    <div>
        <h2 class="text-2xl font-bold mb-6">4. Statistika</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white rounded-xl shadow p-5">Karl Pearson</div>
            <div class="bg-white rounded-xl shadow p-5">Ronald A. Fisher</div>
            <div class="bg-white rounded-xl shadow p-5">Florence Nightingale</div>
        </div>
    </div>

    <!-- TEORI BILANGAN -->
    <div>
        <h2 class="text-2xl font-bold mb-6">5. Teori Bilangan</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white rounded-xl shadow p-5">Pierre de Fermat</div>
            <div class="bg-white rounded-xl shadow p-5">Carl Friedrich Gauss</div>
            <div class="bg-white rounded-xl shadow p-5">Srinivasa Ramanujan</div>
        </div>
    </div>

    <!-- LOGIKA MATEMATIKA -->
    <div>
        <h2 class="text-2xl font-bold mb-6">6. Logika Matematika</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white rounded-xl shadow p-5">George Boole</div>
            <div class="bg-white rounded-xl shadow p-5">Kurt Gödel</div>
            <div class="bg-white rounded-xl shadow p-5">Gottlob Frege</div>
        </div>
    </div>

    <!-- MATEMATIKA TERAPAN -->
    <div>
        <h2 class="text-2xl font-bold mb-6">7. Matematika Terapan</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white rounded-xl shadow p-5">John von Neumann</div>
            <div class="bg-white rounded-xl shadow p-5">Alan Turing</div>
            <div class="bg-white rounded-xl shadow p-5">Joseph Fourier</div>
        </div>
    </div>

</section>

@include('layouts.footer')

</body>
</html>
