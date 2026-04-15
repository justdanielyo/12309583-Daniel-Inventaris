<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Lending | Inventaris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .signature-pad {
            border: 2px dashed #e2e8f0;
            border-radius: 0.75rem;
            background-color: #f9fafb;
            width: 100%;
            height: 150px;
            cursor: crosshair;
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
                <img src="https://i.pinimg.com/736x/c6/e3/26/c6e32690bfb3e0572b5c92cf6de223a5.jpg" class="w-10 h-10 rounded-full object-cover">
                <h2 class="text-lg font-semibold text-gray-700">Add New <span class="text-indigo-600 font-bold italic">Lending</span></h2>
            </div>
            <div class="flex items-center gap-6">
                <span class="text-sm text-gray-500 font-medium">{{ date('d F, Y') }}</span>
                <form action="/logout" method="POST"> @csrf <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm">Logout</button></form>
            </div>
        </header>

        <div class="p-10 flex flex-col items-center">
            <div class="w-full max-w-4xl bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 pt-8 pb-4 border-b border-gray-50">
                    <h1 class="text-2xl font-bold text-gray-800">Lending Form</h1>
                    <p class="text-sm text-gray-400">Please <span class="text-pink-500 font-medium">.fill-all</span> input form with right value.</p>
                </div>

                @if (session('error'))
                    <div class="mx-8 mt-4 bg-red-50 border border-red-100 text-red-600 px-6 py-3 rounded-xl text-sm font-bold">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('lendings.store') }}" method="POST" id="lendingForm" class="p-8 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                            <input type="text" name="name" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 outline-none focus:ring-2 focus:ring-indigo-500 transition shadow-sm" placeholder="Borrower Name">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-blue-600 mb-2">Meminjam Sampai Tanggal (Due Date)</label>
                            <input type="date" name="due_date" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 outline-none focus:ring-2 focus:ring-blue-500 transition shadow-sm">
                            <p class="text-[10px] text-gray-400 mt-1">*Tentukan kapan barang harus dikembalikan.</p>
                        </div>
                    </div>

                    <div id="item-container" class="space-y-4">
                        <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            <div class="md:col-span-7">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Item</label>
                                <select name="items[0][item_id]" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 outline-none focus:ring-2 focus:ring-indigo-500 transition shadow-sm">
                                    <option value="" disabled selected>Select Items</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} (Avail: {{ $item->total - ($item->repair + $item->lending) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Total</label>
                                <input type="number" name="items[0][total]" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 outline-none focus:ring-2 focus:ring-indigo-500 transition shadow-sm" placeholder="Total">
                            </div>
                            <div class="md:col-span-1"></div>
                        </div>
                    </div>

                    <button type="button" id="add-more" class="text-indigo-600 text-sm font-bold flex items-center gap-1 hover:text-indigo-800">
                        <span class="text-lg">∨</span> More
                    </button>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ket. (Optional)</label>
                        <textarea name="notes" rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 outline-none focus:ring-2 focus:ring-indigo-500 transition shadow-sm" placeholder="Add some notes..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Staff Signature</label>
                            <canvas id="staff-pad" class="signature-pad"></canvas>
                            <input type="hidden" name="staff_signature" id="staff-sig-input">
                            <button type="button" onclick="staffPad.clear()" class="text-red-500 text-xs mt-2 hover:underline">Clear Signature</button>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Borrower Signature</label>
                            <p class="text-[10px] text-gray-500 mb-2 leading-tight">Saya yang bertanda tangan di bawah ini telah siap menerima konsekuensi yang ada jika peminjaman melewati batas waktu dan/atau jumlah barang yang dikembalikan tidak sesuai.</p>
                            <canvas id="borrower-pad" class="signature-pad"></canvas>
                            <input type="hidden" name="borrower_signature" id="borrower-sig-input">
                            <button type="button" onclick="borrowerPad.clear()" class="text-red-500 text-xs mt-2 hover:underline">Clear Signature</button>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-6 border-t border-gray-50">
                        <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg transition duration-200">Submit</button>
                        <a href="{{ route('lendings.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-4 rounded-xl text-center transition duration-200">Cancel</a>
                    </div>
                </form>

                <script>
                    let rowCount = 1;
                    const container = document.getElementById('item-container');
                    const addButton = document.getElementById('add-more');

                    addButton.addEventListener('click', () => {
                        const newRow = document.createElement('div');
                        newRow.className = 'item-row grid grid-cols-1 md:grid-cols-12 gap-4 items-end mt-4';
                        newRow.innerHTML = `
                            <div class="md:col-span-7">
                                <select name="items[${rowCount}][item_id]" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 outline-none focus:ring-2 focus:ring-indigo-500 transition shadow-sm">
                                    <option value="" disabled selected>Select Items</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} (Avail: {{ $item->total - ($item->repair + $item->lending) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-4">
                                <input type="number" name="items[${rowCount}][total]" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 outline-none focus:ring-2 focus:ring-indigo-500 transition shadow-sm" placeholder="Total">
                            </div>
                            <div class="md:col-span-1 text-center">
                                <button type="button" class="remove-row text-red-500 hover:text-red-700 font-bold text-xl">✕</button>
                            </div>
                        `;
                        container.appendChild(newRow);
                        rowCount++;
                    });

                    container.addEventListener('click', (e) => {
                        if (e.target.classList.contains('remove-row')) {
                            e.target.closest('.item-row').remove();
                        }
                    });

                    const staffCanvas = document.getElementById('staff-pad');
                    const borrowerCanvas = document.getElementById('borrower-pad');

                    const staffPad = new SignaturePad(staffCanvas);
                    const borrowerPad = new SignaturePad(borrowerCanvas);

                    function resizeCanvas() {
                        const ratio = Math.max(window.devicePixelRatio || 1, 1);
                        [staffCanvas, borrowerCanvas].forEach(canvas => {
                            canvas.width = canvas.offsetWidth * ratio;
                            canvas.height = canvas.offsetHeight * ratio;
                            canvas.getContext("2d").scale(ratio, ratio);
                        });
                        staffPad.clear();
                        borrowerPad.clear();
                    }

                    window.addEventListener("resize", resizeCanvas);
                    resizeCanvas();

                    document.getElementById('lendingForm').onsubmit = function() {
                        if (staffPad.isEmpty() || borrowerPad.isEmpty()) {
                            alert("Please provide both signatures before submitting.");
                            return false;
                        }
                        document.getElementById('staff-sig-input').value = staffPad.toDataURL();
                        document.getElementById('borrower-sig-input').value = borrowerPad.toDataURL();
                    };
                </script>
            </div>
        </div>
    </main>
</body>
</html>