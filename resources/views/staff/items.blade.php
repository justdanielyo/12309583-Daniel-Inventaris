<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items | Inventaris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex h-screen overflow-hidden">
    <aside class="w-64 bg-indigo-900 text-white flex flex-col h-full shadow-lg">
        <div class="p-6 text-2xl font-bold border-b border-indigo-800 flex items-center gap-3">
            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                <span class="text-indigo-900 text-xs font-bold">STF</span>
            </div>
            <span>Inventaris</span>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <p class="text-xs text-indigo-400 uppercase font-semibold px-2 mb-2">Menu</p>
            <a href="/dashboard"
                class="flex items-center gap-3 hover:bg-indigo-800 p-3 rounded-lg transition">Dashboard</a>
            <p class="text-xs text-indigo-400 uppercase font-semibold px-2 mt-6 mb-2">Items Data</p>
            <a href="/items" class="flex items-center gap-3 bg-indigo-700 p-3 rounded-lg transition font-semibold">Items</a>
            <a href="/lendings"
                class="flex items-center gap-3 hover:bg-indigo-800 p-3 rounded-lg transition">Lending</a>
            <p class="text-xs text-indigo-400 uppercase font-semibold px-2 mt-6 mb-2">Accounts</p>
            <a href="/users" class="flex items-center gap-3 hover:bg-indigo-800 p-3 rounded-lg transition">Users</a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center border-b">
            <div class="flex items-center gap-4">
                <img src="https://i.pinimg.com/736x/c6/e3/26/c6e32690bfb3e0572b5c92cf6de223a5.jpg"
                    class="w-10 h-10 rounded-full object-cover">
                <h2 class="text-lg font-semibold text-gray-700">Welcome Back, <span
                        class="text-indigo-600 font-bold uppercase">{{ auth()->user()->name }}</span></h2>
            </div>
            <div class="flex items-center gap-6">
                <span class="text-sm text-gray-500 font-medium">{{ date('d F, Y') }}</span>
                <form action="/logout" method="POST">@csrf<button type="submit"
                        class="text-red-500 font-bold text-sm">Logout</button></form>
            </div>
        </header>

        <div class="p-8">
            @if (session('success'))
                <div
                    class="mb-6 bg-emerald-100 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl text-sm font-bold">
                    {{ session('success') }}</div>
            @endif

            <div class="flex justify-between items-end mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Items Table</h1>
                    <p class="text-gray-400 text-sm">Data of <span class="text-pink-500 font-medium">.items</span>
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="/items/export"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition">Export
                        Excel</a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">#</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Category</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Available</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Lending Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($items as $index => $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $item->category->name }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $item->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $item->total }}</td>
                                <td class="px-6 py-4 text-sm">
                                    {{-- Rumus: total - (repair + lending) --}}
                                    <span class="font-bold text-indigo-600">
                                        {{ $item->total - ($item->repair + $item->lending) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 text-center">
                                    {{ $item->lending }}
                                </td>
                            </tr>
                        @endforeach
                        @if($items->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">No data items available.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>