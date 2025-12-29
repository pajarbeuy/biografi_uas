<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - BIOTOMA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===============================
           TITLE CINEMATIC REVEAL
        =============================== */
        @keyframes titleReveal {
            0% {
                opacity: 0;
                transform: scale(1.1);
                filter: blur(16px);
                letter-spacing: 0.25em;
            }
            100% {
                opacity: 1;
                transform: scale(1);
                filter: blur(0);
                letter-spacing: normal;
            }
        }

        /* ===============================
           CINEMATIC CARD ANIMATION
        =============================== */
        @keyframes cinematicCard {
            0% {
                opacity: 0;
                transform:
                    perspective(1000px)
                    translateY(60px)
                    scale(0.85)
                    rotateX(8deg);
                filter: blur(14px);
            }
            60% {
                opacity: 1;
                transform:
                    perspective(1000px)
                    translateY(-6px)
                    scale(1.03);
                filter: blur(2px);
            }
            100% {
                opacity: 1;
                transform:
                    perspective(1000px)
                    translateY(0)
                    scale(1);
                filter: blur(0);
            }
        }

        .card-anim {
            opacity: 0;
            animation: cinematicCard 1.25s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            will-change: transform, opacity, filter;
        }

        /* ===============================
           MODAL CINEMATIC
        =============================== */
        @keyframes modalCinematic {
            0% {
                opacity: 0;
                transform: scale(0.9) translateY(40px);
                filter: blur(10px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
                filter: blur(0);
            }
        }

        /* Infinite Gradient Loop */
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .gradient-border-loop {
            position: relative;
            background: #fff;
            z-index: 1;
        }
        .gradient-border-loop::before {
            content: '';
            position: absolute;
            inset: -2px;
            z-index: -1;
            background: linear-gradient(45deg, #94a3b8, #cbd5e1, #64748b, #94a3b8);
            background-size: 400%;
            border-radius: 1rem;
            animation: gradientMove 3s linear infinite;
            filter: blur(4px);
            opacity: 0.6;
        }
        .gradient-border-loop::after {
            content: '';
            position: absolute;
            inset: 0;
            z-index: -1;
            background: #fff;
            border-radius: 0.9rem;
        }

        /* Elegant Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col font-sans">
@include('layouts.navbar')

<main class="flex-grow container mx-auto px-4 py-12">

    <!-- TITLE -->
    <div class="text-center mb-20">
       
        <p class="text-slate-700 text-xl max-w-2xl mx-auto mb-6 font-bold">
            Menjelajahi kehidupan dan karya para jenius yang membentuk pemahaman kita.
        </p>
    </div>

@php
$tokohs = [
    // Aljabar
    ['nama'=>'Al-Khwarizmi', 'penjelasan'=>'Bapak Aljabar dan sistem angka modern.'],
    ['nama'=>'Évariste Galois', 'penjelasan'=>'Teori Galois dan aljabar abstrak.'],
    ['nama'=>'Emmy Noether', 'penjelasan'=>'Aljabar abstrak dan fisika modern.'],
    
    // Geometri
    ['nama'=>'Euclid', 'penjelasan'=>'Bapak Geometri klasik.'],
    ['nama'=>'René Descartes', 'penjelasan'=>'Geometri analitik.'],
    ['nama'=>'Bernhard Riemann', 'penjelasan'=>'Geometri non-Euclid.'],

    // Kalkulus
    ['nama'=>'Isaac Newton', 'penjelasan'=>'Kalkulus dan gravitasi.'],
    ['nama'=>'Gottfried Wilhelm Leibniz', 'penjelasan'=>'Notasi kalkulus modern.'],
    ['nama'=>'Leonhard Euler', 'penjelasan'=>'Identitas Euler dan analisis.'],

    // Statistika
    ['nama'=>'Karl Pearson', 'penjelasan'=>'Bapak statistika modern.'],
    ['nama'=>'Ronald A. Fisher', 'penjelasan'=>'Genetika populasi dan statistika.'],
    ['nama'=>'Florence Nightingale', 'penjelasan'=>'Visualisasi data dan statistik.'],

    // Teori Bilangan
    ['nama'=>'Pierre de Fermat', 'penjelasan'=>'Teorema Terakhir Fermat.'],
    ['nama'=>'Carl Friedrich Gauss', 'penjelasan'=>'Pangeran Matematika.'],
    ['nama'=>'Srinivasa Ramanujan', 'penjelasan'=>'Jenius deret tak hingga.'],

    // Logika
    ['nama'=>'George Boole', 'penjelasan'=>'Aljabar Boolean.'],
    ['nama'=>'Kurt Gödel', 'penjelasan'=>'Teorema Ketidaklengkapan.'],
    ['nama'=>'Gottlob Frege', 'penjelasan'=>'Logika matematika modern.'],

    // Terapan
    ['nama'=>'John von Neumann', 'penjelasan'=>'Teori permainan dan komputer.'],
    ['nama'=>'Alan Turing', 'penjelasan'=>'Kecerdasan buatan dan komputasi.'],
    ['nama'=>'Joseph Fourier', 'penjelasan'=>'Deret Fourier dan analisis panas.'],
];
@endphp

    <!-- GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($tokohs as $i => $tokoh)
        <div class="card-anim group relative rounded-2xl cursor-pointer
            hover:-translate-y-3 hover:scale-[1.03] transition-all duration-500
            gradient-border-loop"
            style="animation-delay: {{ 0.7 + ($i * 0.18) }}s;"
            onclick="openModal('{{ $tokoh['nama'] }}','{{ $tokoh['penjelasan'] }}')">

            <!-- Content Container -->
            <div class="p-5 flex items-center justify-center min-h-[120px] relative z-10 bg-white rounded-xl h-full w-full">
                <h3 class="text-lg font-bold text-slate-800
                    group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-indigo-600 group-hover:to-pink-600 transition-all duration-300">
                    {{ $tokoh['nama'] }}
                </h3>
            </div>
        </div>
        @endforeach
    </div>
</main>

<!-- MODAL -->
<div id="bioModal"
    class="fixed inset-0 z-50 hidden items-center justify-center
    bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition">

    <div id="modalContent"
        class="bg-white rounded-3xl shadow-2xl w-full max-w-lg mx-4 p-8
        animate-[modalCinematic_0.6s_cubic-bezier(0.22,1,0.36,1)_forwards]">

        <div class="flex justify-between items-center mb-6">
            <h2 id="modalName" class="text-3xl font-bold"></h2>
            <button onclick="closeModal()" class="text-slate-400 hover:text-red-500 text-2xl">✕</button>
        </div>

        <p id="modalDesc" class="text-lg text-slate-600"></p>

        <div class="mt-8 text-right">
            <button onclick="closeModal()"
                class="px-6 py-2 bg-slate-100 hover:bg-slate-200 rounded-xl">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
const modal = document.getElementById('bioModal');
const modalName = document.getElementById('modalName');
const modalDesc = document.getElementById('modalDesc');

function openModal(name, desc) {
    modalName.textContent = name;
    modalDesc.textContent = desc;
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0','pointer-events-none');
    }, 10);
}

function closeModal() {
    modal.classList.add('opacity-0','pointer-events-none');
    setTimeout(() => modal.classList.add('hidden'), 300);
}

modal.addEventListener('click', e => {
    if (e.target === modal) closeModal();
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeModal();
});
</script>

@include('layouts.footer')
</body>
</html>
