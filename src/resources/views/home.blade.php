<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестовый проект</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <div class="max-w-3xl mx-auto px-6 py-12 space-y-10">

        <div class="flex items-start justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-900">Тестовый проект по ТЗ AmoPoint</h1>
            <div class="flex items-center gap-4 shrink-0 pt-1">
                <a href="https://docs.google.com/document/d/10LwR5k3guN9Z45-6lnQXcdN53R17Q4keoT01mMkW4hA/edit?tab=t.0"
                   target="_blank"
                   class="text-sm text-gray-500 hover:text-gray-800 transition">
                    Тестовое задание
                </a>
                <a href="https://github.com/KharchenkoDev/amopoint-test"
                   target="_blank"
                   class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.009-.868-.013-1.703-2.782.605-3.369-1.342-3.369-1.342-.454-1.155-1.11-1.463-1.11-1.463-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0112 6.836a9.59 9.59 0 012.504.337c1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.202 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.741 0 .267.18.578.688.48C19.138 20.163 22 16.418 22 12c0-5.523-4.477-10-10-10z"/>
                    </svg>
                    GitHub
                </a>
            </div>
        </div>

        {{-- Задание 1 --}}
        <section class="bg-white rounded-2xl shadow-sm p-8 space-y-4">
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Задание 1</span>
                <h2 class="text-lg font-semibold text-gray-800">Сбор цен криптовалют</h2>
            </div>
            <p class="text-sm text-gray-600 leading-relaxed">
                Laravel-приложение, которое каждые 5 минут забирает курсы bitcoin, ethereum и tether
                из CoinGecko API и сохраняет их в базу данных. История цен доступна через REST API
                с фильтрацией по монете и постраничной навигацией.
            </p>
            <a
                href="{{ url('/api/prices') }}"
                target="_blank"
                class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 font-medium transition"
            >
                Открыть JSON-ленту
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </section>

        {{-- Задание 2 --}}
        <section class="bg-white rounded-2xl shadow-sm p-8 space-y-4">
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Задание 2</span>
                <h2 class="text-lg font-semibold text-gray-800">Фильтрация полей по типу</h2>
            </div>
            <p class="text-sm text-gray-600 leading-relaxed">
                JS-скрипт, который скрывает и показывает поля формы в зависимости от выбранного
                значения в поле «Тип». Показываются только те элементы, в атрибуте <code class="bg-gray-100 px-1 rounded">name</code>
                которых содержится выбранное значение.
            </p>
            <a
                href="https://test.amopoint-dev.ru/testzz/testlist.html"
                target="_blank"
                class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 font-medium transition"
            >
                Открыть страницу задания
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
            <div>
                <p class="text-xs font-medium text-gray-500 mb-2 uppercase tracking-wide">Подключить на страницу</p>
                <div class="relative">
                    <pre id="snippet-filter" class="bg-gray-900 text-green-300 rounded-lg px-4 py-3 text-sm font-mono overflow-x-auto whitespace-pre-wrap break-all">&lt;script src="{{ asset('js/filter.js') }}"&gt;&lt;/script&gt;</pre>
                    <button
                        onclick="copyById('snippet-filter', this)"
                        class="absolute top-2 right-2 bg-gray-700 hover:bg-gray-500 text-white text-xs px-3 py-1 rounded transition"
                    >Копировать</button>
                </div>
            </div>
        </section>

        {{-- Задание 3 --}}
        <section class="bg-white rounded-2xl shadow-sm p-8 space-y-4">
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Задание 3</span>
                <h2 class="text-lg font-semibold text-gray-800">Трекер посещений</h2>
            </div>
            <p class="text-sm text-gray-600 leading-relaxed">
                JS-скрипт для подключения к любому сайту. Отправляет данные о визите на сервер,
                который определяет город по IP и тип устройства по User-Agent. Статистика доступна
                на странице аналитики с авторизацией.
            </p>
            <div>
                <p class="text-xs font-medium text-gray-500 mb-2 uppercase tracking-wide">Подключить на страницу</p>
                <div class="relative">
                    <pre id="snippet-tracker" class="bg-gray-900 text-green-300 rounded-lg px-4 py-3 text-sm font-mono overflow-x-auto whitespace-pre-wrap break-all">&lt;script&gt;window.TRACKING_URL = '{{ url('/api/track') }}';&lt;/script&gt;
&lt;script src="{{ asset('js/tracker.js') }}"&gt;&lt;/script&gt;</pre>
                    <button
                        onclick="copyById('snippet-tracker', this)"
                        class="absolute top-2 right-2 bg-gray-700 hover:bg-gray-500 text-white text-xs px-3 py-1 rounded transition"
                    >Копировать</button>
                </div>
            </div>
            <a
                href="{{ route('stats.login') }}"
                class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 font-medium transition"
            >
                Открыть статистику
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </section>

    </div>

    <script>
        function copyById(id, btn) {
            const text = document.getElementById(id).textContent.trim();
            navigator.clipboard.writeText(text).then(function () {
                const original = btn.textContent;
                btn.textContent = 'Скопировано!';
                btn.classList.add('bg-green-600');
                setTimeout(function () {
                    btn.textContent = original;
                    btn.classList.remove('bg-green-600');
                }, 2000);
            });
        }
    </script>

</body>
</html>
