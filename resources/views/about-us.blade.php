<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - BIOTOMA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 min-h-screen">
    @include('layouts.navbar')
    
    <!-- HERO SECTION (PUTIH) -->
    <div class="relative bg-white text-gray-800 py-20 border-b">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-center mb-4">
                Tentang Kami
            </h1>
            <p class="text-lg md:text-xl text-center text-gray-600 max-w-3xl mx-auto">
                Tim Pengembang BIOTOMA - Sistem Informasi Biografi Matematikawan
            </p>
        </div>
    </div>

    <!-- TEAM SECTION -->
    <section class="container mx-auto px-4 py-20">


        <!-- GRID -->
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 max-w-7xl mx-auto">

            <!-- MEMBER 1 -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="p-6 flex flex-col items-center">
                    <div class="relative mb-4">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full blur opacity-20"></div>
                        <div class="relative w-32 h-32 rounded-full overflow-hidden ring-4 ring-blue-100">
                            <img src="{{ asset('images/team/member1.jpeg') }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-center">Difa Nisa Lutfiah</h3>
                    <p class="text-sm text-grey-600 font-semibold">NPM: 20241320013</p>
                </div>
            </div>

            <!-- MEMBER 2 -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="p-6 flex flex-col items-center">
                    <div class="relative mb-4">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full blur opacity-20"></div>
                        <div class="relative w-32 h-32 rounded-full overflow-hidden ring-4 ring-blue-100">
                            <img src="{{ asset('images/team/member2.jpg') }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-center">Pajar</h3>
                    <p class="text-sm text-grey-600 font-semibold">NPM: 20241320026</p>
                </div>
            </div>

            <!-- MEMBER 3 -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="p-6 flex flex-col items-center">
                    <div class="relative mb-4">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full blur opacity-20"></div>
                        <div class="relative w-32 h-32 rounded-full overflow-hidden ring-4 ring-blue-100">
                            <img src="{{ asset('images/team/member3.jpg') }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-center">Aldi Sofyan</h3>
                    <p class="text-sm text-grey-600 font-semibold">NPM: 20241320037</p>
                </div>
            </div>

            <!-- MEMBER 4 -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="p-6 flex flex-col items-center">
                    <div class="relative mb-4">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full blur opacity-20"></div>
                        <div class="relative w-32 h-32 rounded-full overflow-hidden ring-4 ring-blue-100">
                            <img src="{{ asset('images/team/member4.jpg') }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-center">Sobur</h3>
                    <p class="text-sm text-grey-600 font-semibold">NPM: 20241320046</p>
                </div>
            </div>

            <!-- MEMBER 5 -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="p-6 flex flex-col items-center">
                    <div class="relative mb-4">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full blur opacity-20"></div>
                        <div class="relative w-32 h-32 rounded-full overflow-hidden ring-4 ring-blue-100">
                            <img src="{{ asset('images/team/member5.jpg') }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-center">Anggraeni Ghea Saputri</h3>
                    <p class="text-sm text-grey-600 font-semibold">NPM: 20241320002</p>
                </div>
            </div>

            <!-- MEMBER 6 -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="p-6 flex flex-col items-center">
                    <div class="relative mb-4">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full blur opacity-20"></div>
                        <div class="relative w-32 h-32 rounded-full overflow-hidden ring-4 ring-blue-100">
                            <img src="{{ asset('images/team/member6.jpg') }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-center">Paiton Wenda</h3>
                    <p class="text-sm text-grey-600 font-semibold">NPM: 2024132000</p>
                </div>
            </div>

            <!-- MEMBER 7 -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div class="p-6 flex flex-col items-center">
                    <div class="relative mb-4">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full blur opacity-20"></div>
                        <div class="relative w-32 h-32 rounded-full overflow-hidden ring-4 ring-blue-100">
                            <img src="{{ asset('images/team/member7.jpg') }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 text-center">Muhamad Alvin Ramadhan</h3>
                    <p class="text-sm text-grey-600 font-semibold">NPM: 20241320035</p>
                </div>
            </div>

        </div>
    </section>

    @include('layouts.footer')
</body>
</html>
