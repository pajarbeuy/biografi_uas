<!doctype html>
<html lang="id" class="antialiased">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Login - BIOMED</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded shadow p-6">
        <h1 class="text-xl font-bold mb-4">Login (Demo)</h1>
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <label class="block text-sm mb-1">Name</label>
            <input name="name" class="w-full border rounded px-3 py-2 mb-3" placeholder="Your name" required />

            <label class="block text-sm mb-1">Role</label>
            <select name="role" class="w-full border rounded px-3 py-2 mb-4">
                <option value="user">User</option>
                <option value="admin">Admin</option>
                <option value="super">Super Admin</option>
            </select>

            <div class="flex items-center justify-between">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded">Login</button>
                <a href="/home" class="text-sm text-gray-600">Back</a>
            </div>
        </form>
    </div>
</body>
</html>