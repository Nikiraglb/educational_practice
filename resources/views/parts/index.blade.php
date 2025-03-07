<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запчасти</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100 p-5">
    <div class="container mx-auto">

        <h1 class="text-3xl font-bold mb-5">Запчасти</h1>
        @if (session('success'))
            <div id="success-message" class="bg-green-500 text-white p-4 rounded mb-4 fade-out">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('success-message').style.display = 'none';
                }, 3000); // Скрыть сообщение через 3 секунды
            </script>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4 fade-out">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Контейнер для поиска и формы добавления -->
        <div class="mb-4 flex flex-wrap justify-between items-center">
            <!-- Форма поиска -->
            <form action="{{ route('parts.index') }}" method="GET" class="w-full sm:w-auto mb-4 sm:mb-0">
                <input type="text" name="search" value="{{ request('search') }}" placeholder='Поиск...' class="w-full sm:w-80 p-2 border rounded" placeholder="Поиск по названию или артикулу">
            </form>

            <!-- Форма добавления -->
            <div class="flex sm:justify-start justify-start sm:justify-end  w-full mt-5 sm:mt-0 w-[100%] sm:sm:w-auto">
                <button class="bg-blue-500 text-white px-4 py-2 rounded" id="addPartButton">Добавить запчасть</button>
            </div>
        </div>

        <div class="overflow-y-hidden my-5">
            <table class="w-full overflow-y-scroll table-auto bg-white shadow-lg rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Название</th>
                        <th class="px-4 py-2 text-left">Артикул</th>
                        <th class="px-4 py-2 text-left">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($parts as $part)
    <tr class="border-t">
        <td class="px-4 py-2">{{ $part->id }}</td>
        <td class="px-4 py-2">{{ $part->name }}</td>
        <td class="px-4 py-2">{{ $part->article }}</td>
        <td class="px-4 py-2">
            <a href="{{ route('parts.edit', $part->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">Редактировать</a>
            <form action="{{ route('parts.destroy', $part->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">Удалить</button>
            </form>
        </td>
    </tr>
@endforeach
                </tbody>
            </table>
        </div>

        @if($parts->isEmpty())
            <p class="mt-4 text-red-500">Запчасти не найдены.</p>
        @endif

        <!-- Пагинация -->
        {{ $parts->appends(request()->input())->links() }}        

    </div>

    <!-- Модальное окно для добавления запчасти -->
    <div id="modal-add-part" class="fixed flex items-center justify-center inset-0 bg-gray-800 bg-opacity-50 hidden z-50 px-5">
        <div class="bg-white p-6 rounded-lg w-full sm:w-[100%] md:w-2/3 lg:w-5/12">
            <h2 class="text-2xl font-bold mb-4">Добавить запчасть</h2>
            <form action="{{ route('parts.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block mb-2">Название</label>
                    <input type="text" id="name" name="name" class="w-full p-2 border rounded @error('name') border-red-500 @enderror" required>
                </div>

                <div class="mb-4">
                    <label for="article" class="block mb-2">Артикул</label>
                    <input type="text" id="article" name="article" class="w-full p-2 border rounded @error('article') border-red-500 @enderror" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Добавить</button>
                    <button type="button" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded" id="closeModalButton">Отмена</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addPartButton = document.getElementById('addPartButton');
            const modal = document.getElementById('modal-add-part');
            const closeModalButton = document.getElementById('closeModalButton');

            addPartButton.addEventListener('click', () => {
                modal.classList.remove('hidden');
            });

            closeModalButton.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
    </script>
</body>
</html>