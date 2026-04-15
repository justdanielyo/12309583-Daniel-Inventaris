<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Lending | Inventaris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
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
            <a href="/dashboard" class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition text-sm">Dashboard</a>
            <p class="text-xs text-blue-400 uppercase font-semibold px-2 mt-6 mb-2">Items Data</p>
            <a href="/items" class="flex items-center gap-3 hover:bg-blue-800 p-3 rounded-lg transition text-sm">Items</a>
            <a href="/lendings" class="flex items-center gap-3 bg-blue-700 p-3 rounded-lg transition font-semibold text-sm">Lending</a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center border-b">
            <h2 class="text-lg font-semibold text-gray-700">Add New Lending</h2>
            <div class="flex items-center gap-6">
                <span class="text-sm text-gray-500 font-medium">{{ date('d F, Y') }}</span>
            </div>
        </header>

        <div class="p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Lending Form</h1>
                <p class="text-gray-500 text-sm">Silahkan isi data peminjaman barang</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-8">
                <form action="{{ route('lendings.store') }}" method="POST" id="lendingForm">
                    @csrf

                    @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Borrower Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full border-gray-200 border px-4 py-2 rounded-lg focus:border-blue-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Borrower Role</label>
                            <select name="borrower_role" id="roleSelector" required
                                class="w-full border-gray-200 border px-4 py-2 rounded-lg focus:border-blue-500 outline-none transition">
                                <option value="Siswa">Siswa</option>
                                <option value="Guru/Staff">Guru/Staff</option>
                                <option value="Tamu">Tamu</option>
                            </select>
                        </div>

                        <div id="classField">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Class / Info</label>
                            <input type="text" name="class" value="{{ old('class') }}" placeholder="XII RPL 1"
                                class="w-full border-gray-200 border px-4 py-2 rounded-lg focus:border-blue-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Return Date (Deadline)</label>
                            <input type="date" name="due_date" value="{{ old('due_date') }}" required
                                class="w-full border-gray-200 border px-4 py-2 rounded-lg focus:border-blue-500 outline-none transition">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Select Item</label>
                        <div class="flex gap-4 items-center bg-gray-50 p-4 rounded-lg border">
                            <select name="items[0][item_id]" class="flex-1 border-gray-200 border px-4 py-2 rounded-lg outline-none">
                                @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} (Available: {{ $item->total - ($item->repair + $item->lending) }})</option>
                                @endforeach
                            </select>
                            <input type="number" name="items[0][total]" min="1" value="1" placeholder="Qty"
                                class="w-24 border-gray-200 border px-4 py-2 rounded-lg outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Staff Signature</label>
                        <div id="staffContainer" class="border-2 rounded-lg bg-gray-50 h-32 relative transition-all">
                            <canvas id="staffCanvas" class="w-full h-full touch-none cursor-crosshair"></canvas>
                        </div>
                        <p id="staffError" class="hidden text-[10px] text-red-500 mt-1 font-bold italic">Tanda tangan staff wajib diisi!</p>
                        <input type="hidden" name="staff_signature" id="staff_signature">
                        <button type="button" onclick="clearStaff()" class="text-[10px] text-red-500 mt-1 uppercase font-bold hover:underline">Clear</button>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Borrower Signature</label>
                        <div id="borrowerContainer" class="border-2 rounded-lg bg-gray-50 h-32 relative transition-all">
                            <canvas id="borrowerCanvas" class="w-full h-full touch-none cursor-crosshair"></canvas>
                        </div>
                        <p id="borrowerError" class="hidden text-[10px] text-red-500 mt-1 font-bold italic">Tanda tangan peminjam wajib diisi!</p>
                        <input type="hidden" name="borrower_signature" id="borrower_signature">
                        <button type="button" onclick="clearBorrower()" class="text-[10px] text-red-500 mt-1 uppercase font-bold hover:underline">Clear</button>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg font-bold transition shadow-md">Save Lending</button>
                        <a href="/lendings" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-8 py-2.5 rounded-lg font-bold transition">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        const staffCanvas = document.getElementById('staffCanvas');
        const borrowerCanvas = document.getElementById('borrowerCanvas');

        // Inisialisasi Signature Pad
        const staffPad = new SignaturePad(staffCanvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)'
        });
        const borrowerPad = new SignaturePad(borrowerCanvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)'
        });

        // Menyesuaikan ukuran canvas
        function resizeCanvas() {
            [{
                canvas: staffCanvas,
                pad: staffPad
            }, {
                canvas: borrowerCanvas,
                pad: borrowerPad
            }].forEach(obj => {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                obj.canvas.width = obj.canvas.offsetWidth * ratio;
                obj.canvas.height = obj.canvas.offsetHeight * ratio;
                obj.canvas.getContext("2d").scale(ratio, ratio);
                obj.pad.clear();
            });
        }

        window.addEventListener("load", resizeCanvas);
        window.addEventListener("resize", resizeCanvas);

        // Fungsi Clear Manual
        function clearStaff() {
            staffPad.clear();
            document.getElementById('staffContainer').classList.replace('border-red-500', 'border-gray-200');
            document.getElementById('staffError').classList.add('hidden');
        }

        function clearBorrower() {
            borrowerPad.clear();
            document.getElementById('borrowerContainer').classList.replace('border-red-500', 'border-gray-200');
            document.getElementById('borrowerError').classList.add('hidden');
        }

        // Handle Form Submit & Validasi
        document.getElementById('lendingForm').onsubmit = function(e) {
            let isValid = true;

            // Validasi Staff
            if (staffPad.isEmpty()) {
                document.getElementById('staffContainer').classList.add('border-red-500');
                document.getElementById('staffError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('staff_signature').value = staffPad.toDataURL();
            }

            // Validasi Borrower
            if (borrowerPad.isEmpty()) {
                document.getElementById('borrowerContainer').classList.add('border-red-500');
                document.getElementById('borrowerError').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('borrower_signature').value = borrowerPad.toDataURL();
            }

            if (!isValid) {
                e.preventDefault();
                // Scroll ke area signature jika error
                document.getElementById('staffContainer').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        };

        const roleSelector = document.getElementById('roleSelector');
        const classField = document.getElementById('classField');
        roleSelector.addEventListener('change', () => {
            classField.style.display = (roleSelector.value === 'Guru/Staff') ? 'none' : 'block';
        });
    </script>
</body>
</html>