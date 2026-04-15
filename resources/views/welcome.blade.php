<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris | UKK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <nav class="flex justify-between items-center px-10 py-5 bg-white shadow-sm">
        <div class="flex items-center gap-2">
            <img src="https://i.pinimg.com/736x/c6/e3/26/c6e32690bfb3e0572b5c92cf6de223a5.jpg" alt="Logo" class="w-12 h-12 rounded-full object-cover border shadow-sm">
        </div>
        <button onclick="toggleModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold transition">Login</button>
    </nav>

    <section class="text-center py-16 px-4">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">Inventaris <br> BETA </h1>
        <p class="text-gray-500 text-lg mb-10">Management of incoming and outgoing items with Your Self.</p>
        <div class="flex justify-center">
            <img src="https://i.pinimg.com/736x/2b/d3/ae/2bd3ae6ce9da21b864cf8bc6bb23166c.jpg" alt="Illustration" class="max-w-2xl w-full">
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold">Our system flow</h2>
            <p class="text-gray-400">Our inventory system workflow</p>
        </div>
        <div class="container mx-auto px-10 grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="bg-slate-900 rounded-lg h-64 flex items-center justify-center mb-4">
                    <img src="https://cdn-icons-png.flaticon.com/512/2897/2897785.png" class="w-32 invert">
                </div>
                <h3 class="font-bold text-lg">Items Data</h3>
            </div>
            <div class="text-center">
                <div class="bg-orange-400 rounded-lg h-64 flex items-center justify-center mb-4">
                    <img src="https://cdn-icons-png.flaticon.com/512/942/942799.png" class="w-32">
                </div>
                <h3 class="font-bold text-lg">Management Technician</h3>
            </div>
            <div class="text-center">
                <div class="bg-indigo-200 rounded-lg h-64 flex items-center justify-center mb-4">
                    <img src="https://cdn-icons-png.flaticon.com/512/1055/1055644.png" class="w-32">
                </div>
                <h3 class="font-bold text-lg">Managed Lending</h3>
            </div>
            <div class="text-center">
                <div class="bg-emerald-400 rounded-lg h-64 flex items-center justify-center mb-4">
                    <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" class="w-32">
                </div>
                <h3 class="font-bold text-lg">All Can Borrow</h3>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t py-16 px-10 mt-10">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">
            <div>
                <img src="https://i.pinimg.com/736x/c6/e3/26/c6e32690bfb3e0572b5c92cf6de223a5.jpg" alt="Logo" class="w-16 h-16 rounded-full object-cover border mb-4 shadow-sm">
                <p class="text-gray-500">yukisorimachireal@gmail.com</p>
                <p class="text-gray-500">082112833807</p>
            </div>
        </div>
    </footer>

    <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-center mb-8">Login</h2>

                <form action="/login" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" name="email" placeholder="Email" class="w-full px-4 py-3 rounded-lg bg-gray-50 border focus:border-blue-500 outline-none" value="{{ old('email') }}">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block text-gray-700 font-semibold mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="Password"
                                class="w-full px-4 py-3 rounded-lg bg-gray-50 border focus:border-blue-500 outline-none">

                            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-500">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.399 8.049 7.21 5 12 5c4.789 0 8.601 3.049 9.964 6.678.045.133.045.268 0 .402-1.364 3.629-5.175 6.678-9.964 6.678-4.789 0-8.601-3.049-9.964-6.678z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg id="eyeSlashIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="toggleModal()" class="flex-1 bg-orange-500 text-white font-bold py-3 rounded-lg hover:bg-orange-600 transition">Close</button>
                        <button type="submit" class="flex-1 bg-emerald-400 text-white font-bold py-3 rounded-lg hover:bg-emerald-500 transition">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('loginModal');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');

        function toggleModal() {
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function togglePasswordVisibility() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }

        @if($errors->any())
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        @endif
    </script>
</body>
</html>