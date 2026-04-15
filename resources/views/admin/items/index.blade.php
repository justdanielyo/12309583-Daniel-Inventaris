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

        .modal-active {
            display: flex !important;
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
            <a href="/dashboard" class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition">Dashboard</a>
            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mt-6 mb-2">Items Data</p>
            <a href="/categories" class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition text-white">Categories</a>
            <a href="/items" class="flex items-center gap-3 bg-blue-700 p-3 rounded-lg transition font-semibold text-white">Items</a>
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
                    <h1 class="text-2xl font-bold text-gray-800">Items Table</h1>
                    <p class="text-gray-500 text-sm">Add, delete, update <span class="text-pink-500">.items</span></p>
                </div>
                <div class="flex gap-3">
                    <a href="/items/export" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition text-sm flex items-center">Export Excel</a>
                    <a href="/items/create" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 shadow-md transition text-sm"><span>+</span> Add</a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">#</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">Category</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">Name</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">Total</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">Repair</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase">Lending</th>
                            <th class="px-6 py-4 text-gray-600 font-semibold text-xs uppercase text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($items as $index => $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $item->category->name }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $item->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->total }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->repair }}</td>
                            <td class="px-6 py-4 text-sm font-bold">
                                @if ($item->lending > 0)
                                <a href="/items/lending/{{ $item->id }}" class="text-blue-600 underline hover:text-blue-800 transition">{{ $item->lending }}</a>
                                @else
                                <span class="text-gray-400">{{ $item->lending }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="/items/edit/{{ $item->id }}" class="bg-indigo-500 text-white px-4 py-1.5 rounded-md text-sm hover:bg-indigo-600 transition inline-block">Edit</a>
                                    <button type="button" onclick="openDeleteModal('{{ $item->id }}', '{{ $item->name }}')" class="bg-red-500 text-white px-4 py-1.5 rounded-md text-sm hover:bg-red-600 transition inline-block">Delete</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 overflow-y-auto px-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6 transform transition-all scale-95 opacity-0 duration-300" id="modalContent">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Item?</h3>
                <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus <span id="itemNameDisplay" class="font-bold text-gray-800"></span>? Data ini akan hilang permanen.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">Batal</button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold shadow-md">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('modalContent');
        const deleteForm = document.getElementById('deleteForm');
        const nameDisplay = document.getElementById('itemNameDisplay');

        function openDeleteModal(id, name) {
            nameDisplay.innerText = name;
            deleteForm.action = `/items/delete/${id}`;
            modal.classList.remove('hidden');
            modal.classList.add('modal-active');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeDeleteModal() {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('modal-active');
            }, 300);
        }

        window.onclick = function(event) {
            if (event.target == modal) closeDeleteModal();
        }
    </script>
</body>

</html>