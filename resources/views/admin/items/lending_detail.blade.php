<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items Management | Admin</title>
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
            <a href="/dashboard" class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">
                Dashboard
            </a>

            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mt-6 mb-2">Items Data</p>
            <a href="/categories" class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">
                Categories
            </a>
            <a href="/items"
                class="flex items-center gap-3 bg-blue-700 p-3 rounded-lg transition font-semibold text-white">
                Items
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center border-b">
            <h2 class="text-lg font-semibold text-gray-700">Items Management</h2>
            <div class="flex items-center gap-6">
                <span class="text-sm text-gray-500 font-medium">{{ date('d F, Y') }}</span>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="text-red-500 font-bold text-sm">Logout</button>
                </form>
            </div>
        </header>

        <div class="p-8">
            <div class="mb-6 flex justify-between items-end">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Lending Table</h1>
                    <p class="text-gray-500 text-sm">Data of <span class="text-pink-500">.lendings</span> ({{ $item->name }})</p>
                </div>
                <div class="flex gap-3">
                    <a href="/items"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition text-sm">
                        Back
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">#</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">Item</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">Total</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">Name</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">Ket.</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">Date</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">Returned</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">Edited By</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($item->lendings as $index => $lending)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $item->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $lending->total }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $lending->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $lending->notes ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($lending->date)->format('d F, Y') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if($lending->returned_at)
                                        <span class="text-emerald-500 border border-emerald-500 px-2 py-1 rounded text-xs">
                                            {{ \Carbon\Carbon::parse($lending->returned_at)->format('d F, Y') }}
                                        </span>
                                    @else
                                        <span class="text-yellow-600 border border-yellow-500 px-2 py-1 rounded text-xs">
                                            not returned
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-blue-900 italic uppercase">
                                    {{ $lending->user->name ?? 'operator wikrama' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-center text-gray-400 italic">No history found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>