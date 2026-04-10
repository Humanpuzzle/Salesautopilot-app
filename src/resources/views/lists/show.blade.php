<!DOCTYPE html>
<html>
<head>
    <title>SAPI Listák</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="max-w-5xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">
            Sapi Listák
        </h1>

        @if(\App\Services\SapiCredentials::isConfigured())
            <form method="POST" action="{{ route('sapi.logout') }}">
                @csrf

                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Kijelentkezés
                </button>
            </form>
        @endif
    </div>

    <form method="GET" class="mb-4 flex gap-2">

        <input
            type="text"
            name="search"
            value="{{ $search ?? '' }}"
            placeholder="Email keresés..."
            class="border p-2"
        >

        <select name="sort" class="border p-2">
            <option value="subdate" {{ ($sort ?? '') == 'subdate' ? 'selected' : '' }}>
                Dátum
            </option>
            <option value="email" {{ ($sort ?? '') == 'email' ? 'selected' : '' }}>
                Email
            </option>
        </select>

        <select name="order" class="border p-2">
            <option value="asc" {{ ($order ?? '') == 'asc' ? 'selected' : '' }}>
                Növekvő
            </option>
            <option value="desc" {{ ($order ?? '') == 'desc' ? 'selected' : '' }}>
                Csökkenő
            </option>
        </select>

        <button class="bg-blue-500 text-white px-4">
            Szűrés
        </button>

    </form>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($error))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ $error }}
        </div>
    @endif

    @if(count($subscribers))
        <table class="w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr class="bg-gray-100">
                    <th class="p-2">Email</th>
                    <th class="p-2">Név</th>
                    <th class="p-2">Státusz</th>
                    <th class="p-2">Feliratkozás dátuma</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscribers as $sub)
                    <tr class="border-t">
                        <td class="p-2">{{ $sub['email'] ?? '-' }}</td>
                        <td class="p-2">{{ $sub['name'] ?? '-' }}</td>
                        <td class="p-2">{{ $sub['status'] ?? '-' }}</td>
                        <td class="p-2">{{ $sub['subdate'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(empty($subscribers))
        <div class="p-4 bg-yellow-100">
            Nincs találat
        </div>
    @endif
</div>

</body>
</html>
