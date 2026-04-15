<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Account | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
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
            
            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mt-6 mb-2">Accounts</p>
            <a href="{{ route('users.admin') }}" class="flex items-center gap-3 bg-blue-700 p-3 rounded-lg transition font-semibold">
                <span>Users</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center border-b">
            <h2 class="text-lg font-semibold text-gray-700">Edit Account</h2>
            <div class="flex items-center gap-6">
                <span class="text-sm text-gray-500 font-medium">{{ date('d F, Y') }}</span>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm">Logout</button>
                </form>
            </div>
        </header>

        <div class="p-8">
            <div class="max-w-4xl bg-white rounded-xl shadow-sm p-8 border">
                <h1 class="text-2xl font-bold mb-2 text-gray-800">Edit Account Forms</h1>
                <p class="text-gray-400 mb-8 text-sm">Please <span class="text-pink-500">.fill-all</span> input form with right value.</p>

                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-6">
                        <label class="block font-semibold mb-2 text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                            class="w-full p-3 border rounded-lg outline-none focus:border-blue-500 transition @error('name') border-red-500 @enderror"
                            placeholder="Full Name">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block font-semibold mb-2 text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                            class="w-full p-3 border rounded-lg outline-none focus:border-blue-500 transition @error('email') border-red-500 @enderror"
                            placeholder="Email Address">
                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block font-semibold mb-2 text-gray-700">New Password <span class="text-yellow-500 font-normal">optional</span></label>
                        <input type="password" name="password" 
                            class="w-full p-3 border rounded-lg outline-none focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                            placeholder="Leave blank if you don't want to change">
                        @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('users.admin') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-8 py-2.5 rounded-lg font-semibold transition">Cancel</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-2.5 rounded-lg font-semibold shadow-md transition">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>