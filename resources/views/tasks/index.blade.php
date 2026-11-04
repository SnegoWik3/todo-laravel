<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список задач</title>
    <script>
    // Проверяем тему при загрузке страницы
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    // Функция для кнопки
    function toggleTheme() {
        console.log('КНОПКА НАЖАТА!');
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.theme = 'light';
        } else {
            document.documentElement.classList.add('dark');
            localStorage.theme = 'dark';
        }
    }
</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans antialiased transition-colors duration-200">

    <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Логотип -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800 dark:text-gray-200">
                            Todo App
                        </a>
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <div class="ms-3 relative flex items-center gap-4">
                        <button type="button" onclick="toggleTheme()"
                            class="p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <!-- Иконка солнца -->
                            <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>

                            <!-- Иконка луны -->
                            <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </button>
                        <a href="{{ route('profile.edit') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                            {{ Auth::user()->name }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                Выйти
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Карточка -->
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden p-6 mt-10 transition-colors duration-200 mt-10">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6 dark:text-white">Мои задачи</h1>

        <!-- ошибки-->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Форма добавления -->
        <form action="/tasks" method="POST" class="flex gap-2 mb-8">
            @csrf
            <input type="text" name="title" placeholder="Что нужно сделать?" value="{{ old('title') }}"
                   class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                Добавить
            </button>
        </form>

        <!-- Список задач -->
        <ul class="space-y-4">
            @foreach ($tasks as $task)
                <li class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-sm transition">

                    <!-- 1. Чекбокс (смена статуса) -->
                    <form action="/tasks/{{ $task->id }}" method="POST" class="flex items-center ">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="is_done" value="0">
                        <input type="checkbox" name="is_done" value="1" onchange="this.form.submit()" {{ $task->is_done ? 'checked' : '' }}
                               class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 cursor-pointer ">
                    </form>

                    <!-- 2. Форма редактирования названия -->
                    <form action="/tasks/{{ $task->id }}" method="POST" class="flex-1 flex gap-2 dark:text-gray-200" autocomplete="off">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="title" value="{{ $task->title }}"
                               class="flex-1 bg-transparent border-b border-transparent focus:border-blue-500 focus:outline-none px-1 py-1 dark:text-white {{ $task->is_done ? 'line-through text-gray-400' : '' }}">
                        <button type="submit" class="text-sm text-gray-500 hover:text-blue-600 font-medium dark:text-gray-400 dark:hover:text-blue-400" title="Сохранить изменение">
                            💾
                        </button>
                    </form>

                    <!-- 3. Кнопка удаления -->
                    <form action="/tasks/{{ $task->id }}" method="POST" onsubmit="return confirm('Удалить задачу?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 font-bold text-xl px-2" title="Удалить задачу">
                            ×
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>

</body>
</html>
