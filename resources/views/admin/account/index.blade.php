<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Accounts | Admin Inventaris</title>
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
                class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">Dashboard</a>

            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mt-6 mb-2">Items Data</p>
            <a href="/categories"
                class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">Categories</a>
            <a href="/items" class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">Items</a>

            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mt-6 mb-2">Accounts</p>
            <div class="space-y-1">
                <a href="{{ route('users.admin') }}"
                    class="flex items-center gap-3 bg-blue-700 p-3 rounded-lg transition font-semibold text-white">
                    <span>Users</span>
                </a>
                <div class="pl-8 flex flex-col gap-2 mt-2">
                    <a href="{{ route('users.admin') }}"
                        class="text-sm text-white font-bold underline flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-white rounded-full"></span> Admin
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
                <h2 class="text-lg font-semibold text-gray-700">Admin Accounts Management</h2>
            </div>
            <div class="flex items-center gap-6">
                <span class="text-sm text-gray-500 font-medium">{{ date('d F, Y') }}</span>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm">Logout</button>
                </form>
            </div>
        </header>

        <div class="p-8">

            @if (session('created_password'))
                <div class="mb-6 flex items-center p-4 text-emerald-800 border-l-4 border-emerald-500 bg-emerald-50 shadow-md rounded-r-lg transition-all"
                    role="alert">
                    <svg class="flex-shrink-0 w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm font-bold">Akun Berhasil Dibuat!</p>
                        <p class="text-sm">Password otomatis untuk akun ini adalah:
                            <span
                                class="bg-white px-2 py-0.5 rounded border border-emerald-300 font-mono font-bold text-emerald-600">
                                {{ session('created_password') }}
                            </span>
                        </p>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div id="successAlert"
                    class="mb-6 flex items-center p-4 text-emerald-800 border-l-4 border-emerald-500 bg-emerald-50 shadow-md rounded-r-lg transition-all"
                    role="alert">
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-bold">{{ session('success') }}</p>
                    </div>
                    <button onclick="document.getElementById('successAlert').remove()"
                        class="ml-auto text-emerald-500 hover:text-emerald-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif

            <div class="mb-6 flex justify-between items-end">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Admin Accounts Table</h1>
                    <p class="text-gray-500 text-sm">Add, delete, update <span
                            class="text-pink-500">.admin-accounts</span></p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('users.admin.export') }}"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 shadow-md transition">
                        Export Excel
                    </a>
                    <a href="{{ route('users.create') }}"
                        class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 shadow-md transition">
                        <span>+</span> Add
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-6 py-4 text-gray-600 font-semibold text-sm">#</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-sm">Name</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-sm">Email</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-sm text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($users as $index => $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="bg-indigo-500 text-white px-4 py-1.5 rounded-md text-sm hover:bg-indigo-600 transition inline-block">Edit</a>
                                    <button type="button"
                                        onclick="openDeleteModal('{{ route('users.destroy', $user->id) }}')"
                                        class="bg-red-500 text-white px-4 py-1.5 rounded-md text-sm ml-2 hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-xl shadow-lg max-w-md w-full p-6 text-center">
                <div
                    class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 14c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Hapus</h3>
                <p class="text-gray-500 mb-6">Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat
                    dibatalkan.</p>

                <div class="flex justify-center gap-4">
                    <button onclick="closeDeleteModal()"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold transition">
                        Batal
                    </button>
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(actionUrl) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = actionUrl;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
        }
    </script>
</body>
</html>