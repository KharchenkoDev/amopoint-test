<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика — вход</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-md p-8 w-full max-w-sm">
        <h1 class="text-xl font-semibold text-gray-800 mb-6 text-center">Статистика посещений</h1>

        @if ($errors->has('credentials'))
            <div class="mb-4 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg px-4 py-3">
                {{ $errors->first('credentials') }}
            </div>
        @endif

        <form method="POST" action="{{ route('stats.login.submit') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Логин</label>
                <input
                    type="text"
                    name="username"
                    autofocus
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Пароль</label>
                <input
                    type="password"
                    name="password"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg text-sm transition"
            >
                Войти
            </button>
        </form>
    </div>
</body>
</html>
