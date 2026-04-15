<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak | UKK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-800 h-screen flex flex-col items-center justify-center">

    <div class="text-center flex flex-col items-center max-w-lg px-6">
        <!-- Gambar Ilustrasi 404 (Ganti src dengan path gambarmu jika ada di lokal) -->
        <div class="relative mb-6">
            <!-- Saya gunakan ilustrasi gunung salju 404 yang mirip dari internet -->
            <img src="https://img.freepik.com/free-vector/404-error-with-landscape-concept-illustration_114360-7888.jpg" alt="404 Error" class="w-80 h-auto">
        </div>

        <!-- Teks Keterangan -->
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
            You can't access this page.
        </h1>

        <!-- Tombol Back -->
        <!-- url()->previous() otomatis mengembalikan user ke halaman mereka sebelumnya -->
        <a href="{{ url()->previous() }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg font-semibold transition shadow-md hover:shadow-lg">
            Back
        </a>
    </div>
</body>
</html>