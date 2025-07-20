<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'DomainDash') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <header class="bg-blue-600 text-white py-4">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-xl font-bold">{{ config('app.name', 'DomainDash') }}</h1>
                <nav>
                    @auth
                        <a href="{{ route('home') }}" class="px-4">Home</a>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('users.index') }}" class="px-4">Users</a>
                            <a href="{{ route('email-templates.index') }}" class="px-4">Email Templates</a>
                            <a href="{{ route('api-keys.index') }}" class="px-4">API Keys</a>
                            <a href="{{ route('admin.dashboard') }}" class="px-4">Dashboard</a>
                        @endif
                        <a href="{{ route('logout') }}" class="px-4">Logout</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="flex-grow container mx-auto py-8">
            @yield('content')
        </main>

        <footer class="bg-gray-800 text-white py-4 text-center">
            &copy; {{ date('Y') }} DomainDash. All rights reserved.
        </footer>
    </div>
</body>
</html>
