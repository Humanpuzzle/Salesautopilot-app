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
            Feliratkozó Lista
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

    @if(isset($error))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ $error }}
        </div>
    @endif

    @if(isset($message))
        <div class="bg-blue-100 text-blue-700 p-2 mb-3">
            {{ $message }}
        </div>
    @endif

    @if(!empty($lists))
        <table class="w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Név</th>
                    <th class="p-2 text-left">Méret</th>
                    <th class="p-2 text-left">Létrehozva</th>
                    <th class="p-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($lists as $list)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-2">{{ $list['name'] ?? 'N/A' }}</td>
                        <td class="p-2">{{ $list['size'] ?? 'N/A' }}</td>
                        <td class="p-2">{{ $list['created_at'] ?? '-' }}</td>
                        <td class="p-2">
                            <a href="{{ route('lists.show', $list['id']) }}"
                               class="text-blue-600 hover:underline">
                                Megtekintés
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

</body>
</html>
