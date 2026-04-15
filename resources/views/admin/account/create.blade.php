<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Account | Admin Inventaris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="bg-gray-100 flex h-screen overflow-hidden">
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
            <a href="/categories" class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">Categories</a>
            <a href="/items" class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">Items</a>

            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mt-6 mb-2">Accounts</p>
            <div class="space-y-1">
                <a href="{{ route('users.admin') }}" class="flex items-center gap-3 bg-blue-700 p-3 rounded-lg transition font-semibold">
                    Users
                </a>
                <div class="pl-8 flex flex-col gap-2 mt-2">
                    <a href="{{ route('users.admin') }}" class="text-sm text-blue-200 hover:text-white flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span> Admin
                    </a>
                    <a href="{{ route('users.staff') }}" class="text-sm text-blue-200 hover:text-white flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span> Staff
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between border-b">
            <h2 class="text-lg font-semibold text-gray-700">Add Account Forms</h2>
        </header>

        <div class="p-8">
            <div class="max-w-4xl bg-white rounded-xl shadow-sm p-8 border">
                <h1 class="text-2xl font-bold mb-2 text-gray-800">Add Account Forms</h1>
                <p class="text-gray-400 mb-8 text-sm">Please <span class="text-pink-500">.fill-all</span> input form with right value.</p>

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label class="block font-semibold mb-2 text-gray-700">Name</label>
                        <div class="relative">
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full p-3 border rounded-lg outline-none transition @error('name') border-red-500 @else border-gray-300 focus:border-blue-500 @enderror"
                                placeholder="Hiura">
                            @error('name')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @enderror
                        </div>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block font-semibold mb-2 text-gray-700">Email</label>
                        <div class="relative">
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full p-3 border rounded-lg outline-none transition @error('email') border-red-500 @else border-gray-300 focus:border-blue-500 @enderror"
                                placeholder="yukisorimachireal@gmail.com">
                            @error('email')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @enderror
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block font-semibold mb-2 text-gray-700">Role</label>
                        <div class="relative">
                            <select name="role" 
                                class="w-full p-3 border rounded-lg outline-none transition bg-white appearance-none @error('role') border-red-500 @else border-gray-300 focus:border-blue-500 @enderror">
                                <option value="" selected disabled>Select Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>admin</option>
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>staff</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                @error('role')
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                @enderror
                            </div>
                        </div>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('users.admin') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-8 py-2.5 rounded-lg font-bold transition">Cancel</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-2.5 rounded-lg font-bold shadow-md transition">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>