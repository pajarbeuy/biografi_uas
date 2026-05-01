<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - BIOTOMA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-2xl shadow-xl p-8 space-y-6">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">BIOTOMA</h1>
                    <h2 class="text-xl font-semibold text-gray-700">Verifikasi Email</h2>
                    <p class="mt-3 text-sm text-gray-600">
                        Kami sudah mengirim link verifikasi ke email Anda.
                        Silakan cek inbox (atau spam) lalu klik link tersebut untuk mengaktifkan akun.
                    </p>
                </div>

                @if (session('status'))
                    <div class="rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" class="space-y-3">
                    @csrf
                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
                    >
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full py-2 px-4 rounded-lg border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors"
                    >
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
