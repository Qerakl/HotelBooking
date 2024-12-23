<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/Qerakl/HotelBooking/actions"><img src="https://github.com/Qerakl/HotelBooking/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License"></a>
</p>

# Hotel Booking API

## Описание проекта

**Hotel Booking API** — это RESTful сервис для управления бронированием номеров в отеле, построенный с использованием фреймворка Laravel 10 и MySQL.

### Основной функционал:
- **Создание брони.**
- **Просмотр списка всех броней.**
- **Удаление брони.**
- **Редактирование брони.**
- **Получение информации о конкретной брони.**
- **Получение списка броней конкретного пользователя.**
- **Фильтрация списка броней по статусу.**

---

## Установка

### Шаг 1: Клонирование репозитория

```bash
git clone https://github.com/Qerakl/HotelBooking.git
cd HotelBooking
```

### Шаг 2: Установка зависимостей

```bash
composer install
```

### Шаг 3: Настройте .env файл

```bash
cp .env.example .env
```
### Шаг 4: Сгенерируйте ключи приложения

```bash
php artisan key:generate
php artisan jwt:secret
```

### Шаг 5: Выполните миграции базы данных

```bash
php artisan migrate
```

### Шаг 6: Запустите локальный сервер

```bash
php artisan serve
```
### Тестирование

```bash
php artisan test
```

### Тесты покрывают:

- CRUD операции для бронирования.
- Авторизацию и аутентификацию через JWT.
- Фильтрацию данных и обработку ошибок.
