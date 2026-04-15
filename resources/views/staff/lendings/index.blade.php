<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lending | Inventaris</title>
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
            <a href="/dashboard" class="flex items-center gap-3 hover:bg-indigo-800 p-3 rounded-lg transition text-sm">Dashboard</a>
            <p class="text-xs text-indigo-400 uppercase font-semibold px-2 mt-6 mb-2">Items Data</p>
            <a href="/items" class="flex items-center gap-3 hover:bg-indigo-800 p-3 rounded-lg transition text-sm">Items</a>
            <a href="/lendings" class="flex items-center gap-3 bg-indigo-700 p-3 rounded-lg transition font-semibold text-sm">Lending</a>
            <p class="text-xs text-indigo-400 uppercase font-semibold px-2 mt-6 mb-2">Accounts</p>
            <a href="/users" class="flex items-center gap-3 hover:bg-indigo-800 p-3 rounded-lg transition text-sm">Users</a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center border-b">
            <div class="flex items-center gap-4">
                <img src="https://i.pinimg.com/736x/c6/e3/26/c6e32690bfb3e0572b5c92cf6de223a5.jpg" class="w-10 h-10 rounded-full object-cover border">
                <h2 class="text-lg font-semibold text-gray-700">Welcome Back, <span class="text-indigo-600 font-bold uppercase">{{ auth()->user()->name }}</span></h2>
            </div>
            <div class="flex items-center gap-6">
                <span class="text-sm text-gray-500 font-medium">{{ date('d F, Y') }}</span>
                <form action="/logout" method="POST">@csrf<button type="submit" class="text-red-500 font-bold text-sm hover:underline">Logout</button></form>
            </div>
        </header>

        <div class="p-8">
            @if (session('success'))
            <div class="mb-6 bg-emerald-100 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl text-sm font-bold shadow-sm flex items-center gap-3">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                {{ session('success') }}
            </div>
            @endif

            <div class="flex justify-between items-end mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Lending Table</h1>
                    <p class="text-gray-400 text-sm">Tracking <span class="text-pink-500 font-medium">.school-inventory</span> lending data</p>
                </div>
                <div class="flex items-center gap-3">
                    <form action="{{ route('lendings.index') }}" method="GET" class="flex items-center gap-2">
                        <select name="filter" onchange="this.form.submit()"
                            class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 shadow-sm outline-none">
                            <option value="">All Time</option>
                            <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="last_week" {{ request('filter') == 'last_week' ? 'selected' : '' }}>Last 7 Days</option>
                        </select>

                        @if(request('filter'))
                        <a href="{{ route('lendings.index') }}" class="text-xs text-red-500 hover:underline font-bold">Reset</a>
                        @endif
                    </form>

                    <a href="/lendings/export" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition shadow-md">Export Excel</a>
                    <a href="/lendings/create" class="bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition shadow-md">+ Add New</a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase">#</th>
                            <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase">Item</th>
                            <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase">Qty</th>
                            <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase">Borrower</th>
                            <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase">Lending Date</th>
                            <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase">Due Date</th>
                            <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase">Status</th>
                            <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($lendings as $index => $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-4 text-sm text-gray-400">{{ $index + 1 }}</td>
                            <td class="px-4 py-4">
                                <span class="text-sm font-bold text-gray-800 block">{{ $item->item->name }}</span>
                                <span class="text-[10px] text-gray-400 italic">{{ $item->notes ?? 'No notes' }}</span>
                            </td>
                            <td class="px-4 py-4 text-sm font-semibold text-gray-600">{{ $item->total }}</td>
                            <td class="px-4 py-4">
                                <div class="text-sm font-bold text-gray-800">{{ $item->name }}</div>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded text-[9px] font-bold uppercase border border-indigo-100">
                                        {{ $item->borrower_role }}
                                    </span>
                                    @if($item->class)
                                    <span class="text-[10px] text-gray-500 font-medium italic">({{ $item->class }})</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-4 text-sm">
                                @php
                                $isLate = !$item->returned_at && \Carbon\Carbon::parse($item->due_date)->isPast();
                                @endphp
                                <span class="{{ $isLate ? 'text-red-500 font-bold' : 'text-gray-500' }}">
                                    {{ \Carbon\Carbon::parse($item->due_date)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                @if ($item->returned_at)
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-500 px-2 py-1 rounded-md w-fit uppercase tracking-tighter">Returned</span>
                                    <span class="text-[9px] text-gray-400 mt-1">{{ \Carbon\Carbon::parse($item->returned_at)->format('d M, H:i') }}</span>
                                </div>
                                @else
                                @if($isLate)
                                <span class="text-[10px] font-bold text-red-600 bg-red-50 border border-red-500 px-2 py-1 rounded-md animate-pulse uppercase tracking-tighter">Late</span>
                                @else
                                <span class="text-[10px] font-bold text-amber-500 bg-amber-50 border border-amber-400 px-2 py-1 rounded-md uppercase tracking-tighter">Not Returned</span>
                                @endif
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex justify-center gap-2">
                                    @if (!$item->returned_at)
                                    <button type="button"
                                        onclick="openReturnModal('{{ $item->id }}', '{{ $item->item->name }}', '{{ $item->total }}')"
                                        class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-[10px] font-bold transition shadow-sm">
                                        Return Item
                                    </button>
                                    @endif
                                    <form action="{{ route('lendings.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data peminjaman ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-gray-100 hover:bg-red-500 hover:text-white text-gray-400 px-3 py-1.5 rounded-lg text-[10px] font-bold transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($lendings->isEmpty())
                <div class="p-12 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" class="w-16 h-16 mx-auto opacity-20 mb-4">
                    <p class="text-gray-400 text-sm italic">No active lendings found.</p>
                </div>
                @endif
            </div>
        </div>
    </main>

    <div id="returnModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity backdrop-blur-sm"></div>

        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full overflow-hidden transform transition-all">

                <div class="bg-emerald-500 p-6 text-white text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold">Return Item</h3>
                    <p class="text-emerald-50 text-xs opacity-90 mt-1">Konfirmasi pengembalian & cek kondisi barang</p>
                </div>

                <form id="returnForm" method="POST" class="p-6 space-y-5">
                    @csrf
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Item Name</label>
                        <div id="modalItemNameDisplay" class="text-lg font-bold text-gray-800"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Total Borrowed</label>
                            <input type="text" id="modalTotalQty" readonly
                                class="w-full bg-gray-100 border-none font-bold p-3 rounded-lg text-gray-500 outline-none cursor-not-allowed text-center">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-red-400 uppercase mb-2">Broken (Repair)</label>
                            <input type="number" name="repair_count" id="repairCount" min="0" value="0" required
                                class="w-full border-2 border-red-50 bg-red-50/30 font-bold p-3 rounded-lg focus:border-red-500 outline-none transition-all text-red-600 text-center">
                        </div>
                    </div>

                    <div class="flex gap-3 items-start bg-amber-50 p-3 rounded-lg border border-amber-100">
                        <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-[11px] text-amber-700 leading-tight">
                            Barang yang tidak dilaporkan rusak dianggap kembali dalam kondisi baik.
                        </p>
                    </div>

                    <div class="flex justify-center gap-3 pt-2">
                        <button type="button" onclick="closeReturnModal()"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-600 py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-[1.5] bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg shadow-emerald-200 transition">
                            Confirm Return
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openReturnModal(id, itemName, total) {
            const modal = document.getElementById('returnModal');
            const form = document.getElementById('returnForm');
            const repairInput = document.getElementById('repairCount');

            // Isi data ke dalam modal
            document.getElementById('modalItemNameDisplay').innerText = itemName;
            document.getElementById('modalTotalQty').value = total;

            // Atur batas maksimal input rusak sesuai jumlah yang dipinjam
            repairInput.max = total;
            repairInput.value = 0;

            form.action = "/lendings/return/" + id;

            modal.classList.remove('hidden');
            modal.classList.add('block'); 
            document.body.style.overflow = 'hidden'; 
        }

        function closeReturnModal() {
            const modal = document.getElementById('returnModal');
            modal.classList.add('hidden');
            modal.classList.remove('block');
            document.body.style.overflow = 'auto'; 
        }

        window.onclick = function(event) {
            const modal = document.getElementById('returnModal');
            if (event.target == modal) {
                closeReturnModal();
            }
        }
    </script>
</body>

</html>