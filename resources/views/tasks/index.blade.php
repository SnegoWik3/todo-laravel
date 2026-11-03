<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список задач</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen py-10 px-4 font-sans text-gray-800">

    <!-- Карточка -->
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Мои задачи</h1>

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
                   class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                Добавить
            </button>
        </form>

        <!-- Список задач -->
        <ul class="space-y-4">
            @foreach ($tasks as $task)
                <li class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-sm transition">

                    <!-- 1. Чекбокс (смена статуса) -->
                    <form action="/tasks/{{ $task->id }}" method="POST" class="flex items-center">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="is_done" value="0">
                        <input type="checkbox" name="is_done" value="1" onchange="this.form.submit()" {{ $task->is_done ? 'checked' : '' }}
                               class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                    </form>

                    <!-- 2. Форма редактирования названия -->
                    <form action="/tasks/{{ $task->id }}" method="POST" class="flex-1 flex gap-2" autocomplete="off">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="title" value="{{ $task->title }}"
                               class="flex-1 bg-transparent border-b border-transparent focus:border-blue-500 focus:outline-none px-1 py-1 {{ $task->is_done ? 'line-through text-gray-400' : '' }}">
                        <button type="submit" class="text-sm text-gray-500 hover:text-blue-600 font-medium" title="Сохранить изменение">
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
