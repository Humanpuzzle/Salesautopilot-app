<!DOCTYPE html>
<html>
<head>
    <title>Sapi API kapcsolat Beállítás</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-md mx-auto mt-10 bg-white p-6 shadow rounded">

    <h1 class="text-xl font-bold mb-3">
        Sapi API kapcsolat Beállítás<br>
    </h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 mb-3">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/settings/login">
        @csrf

        <input
            name="username"
            value="{{ old('username') }}"
            placeholder="Username"
            class="border p-2 w-full mb-2"
        >

        @error('username')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <input
            name="password"
            type="password"
            placeholder="Password"
            class="border p-2 w-full mb-2"
        >

        @error('password')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <button class="bg-blue-500 text-white px-4 py-2 w-full">
            Mentés
        </button>

        <i class="text-sm mt-4 block">Nincsenek az .env fájlban megadva API hitelesítő adatok</i>
    </form>

</div>

</body>
</html>
