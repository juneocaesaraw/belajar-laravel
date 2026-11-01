<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perpustakaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        <!-- Header -->
        <div class="text-center mb-8">

            <h1 class="text-2xl font-bold text-slate-900">
                Library System
            </h1>
            <p class="text-sm text-slate-500 mt-2">
                Silakan login untuk mengakses sistem perpustakaan.
            </p>
        </div>

        <!-- Login Form -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 sm:p-8">

            <div class="mb-6">
                <h2 class="text-xl font-bold text-slate-900">
                    Login Akun
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Masukkan email dan password akun kamu.
                </p>
            </div>

            <!-- Error Message -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <label for="email"
                           class="block text-sm font-medium text-slate-700 mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password"
                           class="block text-sm font-medium text-slate-700 mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Masukkan password"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full inline-flex items-center justify-center rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Login
                </button>
            </form>

        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-400 mt-6">
            Library System &copy; {{ date('Y') }}
        </p>

    </div>

</body>
</html>
