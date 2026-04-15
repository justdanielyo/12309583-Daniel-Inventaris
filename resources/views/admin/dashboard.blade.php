<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Inventaris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex h-screen overflow-hidden">
    <aside class="w-64 bg-blue-900 text-white flex flex-col h-full shadow-lg">
        <div class="p-6 text-2xl font-bold border-b border-blue-800 flex items-center gap-3">
            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                <span class="text-blue-900 text-xs font-bold">ADM</span>
            </div>
            <span>Inventaris</span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mb-2">Menu</p>
            
            <a href="/dashboard" 
               class="flex items-center gap-3 bg-blue-700 p-3 rounded-lg transition font-semibold text-white">
                Dashboard
            </a>

            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mt-6 mb-2">Items Data</p>
            <a href="/categories"
                class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">Categories</a>
            <a href="/items" class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">Items</a>

            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mt-6 mb-2">Accounts</p>
            <div class="space-y-1">
                <a href="{{ route('users.admin') }}"
                    class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">
                    Users
                </a>
                <div class="pl-8 flex flex-col gap-2 mt-2">
                    <a href="{{ route('users.admin') }}"
                        class="text-sm text-blue-200 hover:text-white flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span> Admin
                    </a>
                    <a href="{{ route('users.staff') }}"
                        class="text-sm text-blue-200 hover:text-white flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span> Staff
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">

        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center border-b">
            <div class="flex items-center gap-4">
                <img src="https://i.pinimg.com/736x/c6/e3/26/c6e32690bfb3e0572b5c92cf6de223a5.jpg"
                    class="w-10 h-10 rounded-full object-cover">
                <h2 class="text-lg font-semibold text-gray-700">Welcome Back, <span
                        class="text-blue-600">{{ Auth::user()->name }}</span></h2>
            </div>

            <div class="flex items-center gap-6">
                <span class="text-sm text-gray-500 font-medium">{{ date('d F, Y') }}</span>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit"
                        class="text-red-500 hover:text-red-700 font-bold text-sm flex items-center gap-1">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <div class="p-8">
            <div
                class="w-full h-48 bg-blue-600 rounded-2xl mb-8 shadow-md flex flex-col justify-center px-10 text-white">
                <h1 class="text-3xl font-bold">
                    Welcome Back, <span class="text-white">{{ auth()->user()->name ?? 'User' }}</span>
                </h1>
                <p class="opacity-80">Monitoring and management system for General Things.</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <h3 class="text-gray-400 font-semibold mb-2">Notice</h3>
                <p class="text-gray-700 text-lg">Check menu in sidebar to manage data.</p>
            </div>
        </div>
    </main>
</body>
</html>