<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Category | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex h-screen overflow-hidden">
    <!-- SIDEBAR -->
    <aside class="w-64 bg-blue-900 text-white flex flex-col h-full shadow-lg">
        <div class="p-6 text-2xl font-bold border-b border-blue-800 flex items-center gap-3">
            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                <span class="text-blue-900 text-xs font-bold">INV</span>
            </div>
            <span>Inventaris</span>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mb-2">Menu</p>
            <a href="/dashboard"
                class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">Dashboard</a>
            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mt-6 mb-2">Items Data</p>
            <a href="/categories"
                class="flex items-center gap-3 bg-blue-700 p-3 rounded-lg transition font-semibold">Categories</a>
            <a href="/items"
                class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">Items</a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center border-b">
            <h2 class="text-lg font-semibold text-gray-700">Edit Category</h2>
            <span class="text-sm text-gray-500 font-medium">{{ date('d F, Y') }}</span>
        </header>

        <div class="p-8">
            <div class="max-w-4xl bg-white rounded-xl shadow-sm p-8 border">
                <h1 class="text-2xl font-bold mb-2 text-gray-800">Edit Category Forms</h1>
                <p class="text-gray-400 mb-8 text-sm">Please <span class="text-pink-500">.fill-all</span> input form
                    with right value.</p>

                <!-- Action ke update/{id} -->
                <form action="/categories/update/{{ $category->id }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label class="block font-semibold mb-2 text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ $category->name }}"
                            class="w-full p-3 border rounded-lg outline-none focus:border-blue-500 transition">
                    </div>

                    <div class="mb-8">
                        <label class="block font-semibold mb-2 text-gray-700">Division PJ</label>
                        <select name="division_pj"
                            class="w-full p-3 border rounded-lg outline-none focus:border-blue-500 transition">
                            <option value="Sarpras" {{ $category->division_pj == 'Sarpras' ? 'selected' : '' }}>Sarpras
                            </option>
                            <option value="Tata Usaha" {{ $category->division_pj == 'Tata Usaha' ? 'selected' : '' }}>
                                Tata Usaha</option>
                            <option value="Tefa" {{ $category->division_pj == 'Tefa' ? 'selected' : '' }}>Tefa
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="/categories"
                            class="bg-gray-400 hover:bg-gray-500 text-white px-8 py-2.5 rounded-lg font-semibold transition">Cancel</a>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-2.5 rounded-lg font-semibold shadow-md transition">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>