<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category | Admin Inventaris</title>
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
    <aside class="w-64 bg-blue-900 text-white flex flex-col h-full shadow-lg">
        <div class="p-6 text-2xl font-bold border-b border-blue-800 flex items-center gap-3">
            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                <span class="text-blue-900 text-xs font-bold">INV</span>
            </div>
            <span>Inventaris</span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mb-2">Menu</p>
            <a href="/dashboard" class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">Dashboard</a>
            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mt-6 mb-2">Items Data</p>
            <a href="/categories" class="flex items-center gap-3 bg-blue-700 p-3 rounded-lg transition font-semibold">Categories</a>
            <a href="#" class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">Items</a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col overflow-y-auto">

        <!-- TOPBAR -->
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center border-b">
            <div class="flex items-center gap-4">
                <img src="https://i.pinimg.com/736x/c6/e3/26/c6e32690bfb3e0572b5c92cf6de223a5.jpg"
                    class="w-10 h-10 rounded-full object-cover">
                <h2 class="text-lg font-semibold text-gray-700">Add New Category</h2>
            </div>
            <div class="flex items-center gap-6">
                <span class="text-sm text-gray-500 font-medium">{{ date('d F, Y') }}</span>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="text-red-500 font-bold text-sm">Logout</button>
                </form>
            </div>
        </header>

        <!-- CONTENT AREA -->
        <div class="p-8">
            <div class="max-w-4xl bg-white rounded-xl shadow-sm p-8 border">
                <h1 class="text-2xl font-bold mb-2 text-gray-800">Add Category Forms</h1>
                <p class="text-gray-400 mb-8 text-sm">Please <span class="text-pink-500">.fill-all</span> input form with right value.</p>

                <form action="/categories/store" method="POST">
                    @csrf
                    <!-- Input Name -->
                    <div class="mb-6">
                        <label class="block font-semibold mb-2 text-gray-700">Name</label>
                        <input type="text" name="name" placeholder="Contoh: Alat Dapur"
                            class="w-full p-3 border rounded-lg outline-none focus:border-blue-500 transition @error('name') border-red-500 @enderror"
                            value="{{ old('name') }}">

                        {{-- Pesan error ini akan otomatis muncul jika validasi unique gagal --}}
                        @error('name')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Select Division PJ -->
                    <div class="mb-8">
                        <label class="block font-semibold mb-2 text-gray-700">Division PJ</label>
                        <select name="division_pj"
                            class="w-full p-3 border rounded-lg outline-none focus:border-blue-500 transition @error('division_pj') border-red-500 @enderror">
                            <option value="">Select Division PJ</option>
                            <option value="Sarpras" {{ old('division_pj') == 'Sarpras' ? 'selected' : '' }}>Sarpras</option>
                            <option value="Tata Usaha" {{ old('division_pj') == 'Tata Usaha' ? 'selected' : '' }}>Tata Usaha</option>
                            <option value="Tefa" {{ old('division_pj') == 'Tefa' ? 'selected' : '' }}>Tefa</option>
                        </select>
                        @error('division_pj') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-4">
                        <a href="/categories" class="bg-gray-100 hover:bg-gray-200 px-8 py-3 rounded-lg font-bold text-gray-600 transition text-center">Back</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-bold shadow-md transition">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>