<!DOCTYPE html>
<html lang="en" class="{{ auth()->check() && auth()->user()->dark_mode ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'DomainDash') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
@php
    $appSettings = \App\Models\Setting::first();
    $primary = $appSettings->primary_color ?? '#2563eb';
    $secondary = $appSettings->secondary_color ?? '#1e40af';
@endphp

<body class="bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col">
        <header class="text-white py-4" style="background-color: {{ $primary }}">
            <div class="container mx-auto flex justify-between items-center">
                @if($appSettings && $appSettings->logo_path)
                    <img src="{{ asset('storage/'.$appSettings->logo_path) }}" alt="Logo" class="h-8">
                @else
                    <h1 class="text-xl font-bold">{{ config('app.name', 'DomainDash') }}</h1>
                @endif
                <nav>
                    @auth
                        <a href="{{ route('home') }}" class="px-4">Home</a>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('users.index') }}" class="px-4">Users</a>
                            <a href="{{ route('email-templates.index') }}" class="px-4">Email Templates</a>
                            <a href="{{ route('api-keys.index') }}" class="px-4">API Keys</a>
                            <a href="{{ route('settings.edit') }}" class="px-4">Theme</a>
                        @endif
                        <form action="{{ route('dark-mode.toggle') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4">
                                {{ auth()->user()->dark_mode ? 'Light' : 'Dark' }} Mode
                            </button>
                        </form>
                        <a href="{{ route('logout') }}" class="px-4">Logout</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="flex-grow container mx-auto py-8">
            @yield('content')
        </main>

        <footer class="text-white py-4 text-center" style="background-color: {{ $secondary }}">
            &copy; {{ date('Y') }} DomainDash. All rights reserved.
        </footer>
    </div>
</body>
</html>
