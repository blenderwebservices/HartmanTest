<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Hartman Test' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="absolute top-4 right-4 z-10 flex items-center space-x-4">
        <!-- Language Switcher -->
        <div>
            <a href="{{ route('locale.switch', 'es') }}" class="px-2 py-1 {{ app()->getLocale() === 'es' ? 'font-bold underline' : 'text-gray-500 hover:text-gray-700' }}">ES</a>
            <span class="text-gray-300">|</span>
            <a href="{{ route('locale.switch', 'en') }}" class="px-2 py-1 {{ app()->getLocale() === 'en' ? 'font-bold underline' : 'text-gray-500 hover:text-gray-700' }}">EN</a>
        </div>

        <!-- User Menu -->
        <div class="flex items-center space-x-2 text-sm">
            @auth
                <span class="text-gray-700">{{ auth()->user()->name }}</span>
                <span class="text-gray-300">|</span>
                <a href="/admin" class="text-indigo-600 hover:text-indigo-800">Admin Panel</a>
            @else
                <a href="/admin/login" class="text-gray-600 hover:text-gray-800">Login</a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800">Register</a>
            @endauth
        </div>
    </div>
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </div>
</body>
</html>
