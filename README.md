# Todo List на Laravel

Полноценное CRUD-приложение для управления задачами, написанное на Laravel.

## 🚀 Стек технологий
*   Backend: PHP 8.3, Laravel 13.x
*   Frontend: HTML, Blade, Tailwind CSS v4
*   База данных: MySQL 8 (utf8mb4)
*   Сборщик: Vite

## ✨ Функционал
*   Создание, редактирование и удаление задач.
*   Отметка задачи как «выполненной».
*   Валидация вводимых данных (название не пустое, до 255 символов).
*   Защита от CSRF-атак (встроенная в Laravel).
*   Красивый и адаптивный дизайн благодаря Tailwind CSS.

## 🛠 Установка и запуск

1. Клонируйте репозиторий:
   ```bash
   git clone https://github.com/snegowik3/todo-laravel.git
   cd todo-laravel
2. Установите зависимости PHP:
    ```bash
    composer install
3. Настройке окружение:
    ```bash
    cp .env.example .env 
    php artisan key:generate
4. Выполните миграции:
    ```bash
    php artisan migrate
5. Установите зависимости и соберите стили:
    ```bash
    npm install
    npm run build
6. Запустите сервер:
    ```bash
    php artisan serve
7. Откройте приложение:
    ```bash
     http://127.0.0.1:8000 
## 📝 Примечание
*   Проект создан в учебных целях. Был произведен перенос с чистого php на laravel.

