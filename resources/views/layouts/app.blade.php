<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BIOMED - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <nav class="bg-white shadow-sm p-4 flex justify-between items-center">
        <h1 class="text-2xl font-black">BIOMED</h1>
        <div class="text-sm">Logged in as: <span class="font-bold">aldi sofyan</span></div>
    </nav>
    
    <main class="p-6">
        @yield('content')
    </main>
</body>
</html>