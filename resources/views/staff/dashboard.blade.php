<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard | Inventaris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-indigo-900 text-white flex flex-col h-full shadow-lg">
        <div class="p-6 text-2xl font-bold border-b border-indigo-800 flex items-center gap-3">
            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                <span class="text-indigo-900 text-xs font-bold">STF</span>
            </div>
            <span>Inventaris</span>
        </div>
    
        <nav class="flex-1 px-4 py-6 space-y-2">
            <p class="text-xs text-indigo-400 uppercase font-semibold px-2 mb-2">Menu</p>
            <a href="#" class="flex items-center gap-3 bg-indigo-700 p-3 rounded-lg transition font-semibold">
                Dashboard
            </a>
            <p class="text-xs text-indigo-400 uppercase font-semibold px-2 mt-6 mb-2">Items Data</p>
            <a href="/items" class="flex items-center gap-3 hover:bg-indigo-800 p-3 rounded-lg transition">Items</a>
            <a href="/lendings" class="flex items-center gap-3 hover:bg-indigo-800 p-3 rounded-lg transition">Lending</a>
            <p class="text-xs text-indigo-400 uppercase font-semibold px-2 mt-6 mb-2">Accounts</p>
            <a href="/users" class="flex items-center gap-3 hover:bg-indigo-800 p-3 rounded-lg transition">Users</a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col overflow-y-auto">

        <!-- TOPBAR -->
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center border-b">
            <div class="flex items-center gap-4">
                <img src="https://i.pinimg.com/736x/c6/e3/26/c6e32690bfb3e0572b5c92cf6de223a5.jpg"
                    class="w-10 h-10 rounded-full object-cover">
                <h2 class="text-lg font-semibold text-gray-700">Welcome Back, <span
                        class="text-indigo-600">{{ Auth::user()->name }}</span></h2>
            </div>

            <div class="flex items-center gap-6">
                <span class="text-sm text-gray-500 font-medium">{{ date('d F, Y') }}</span>
                <!-- Logout Link -->
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit"
                        class="text-red-500 hover:text-red-700 font-bold text-sm flex items-center gap-1">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- CONTENT AREA -->
        <div class="p-8">
            <div class="w-full h-48 bg-indigo-600 rounded-2xl mb-8 shadow-md flex flex-col justify-center px-10 text-white">
                <h1 class="text-3xl font-bold">
                    Welcome Back, <span class="text-white">{{ auth()->user()->name ?? 'Staff' }}</span>
                </h1>
                <p class="opacity-80">Staff monitoring system for incoming and outgoing items.</p>
            </div>

            <!-- Content Card -->
            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <h3 class="text-gray-400 font-semibold mb-2">Notice</h3>
                <p class="text-gray-700 text-lg">Check menu in sidebar to manage data.</p>
            </div>
        </div>
    </main>
</body>
</html>