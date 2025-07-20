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
                            <a href="{{ route('disk-settings.edit') }}" class="px-4">Disk Settings</a>
                        @endif
                        <a href="{{ route('logout') }}" class="px-4">Logout</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="flex-grow container mx-auto py-8 flex">
            <div class="w-3/4">
                @yield('content')
            </div>
            @auth
            <aside class="w-1/4 ml-4">
                <h2 class="text-xl font-bold mb-2">Notifications</h2>
                @php
                    $unread = auth()->user()->notifications()->where('is_read', false)->latest()->get();
                @endphp
                <ul>
                    @forelse($unread as $note)
                        <li class="mb-2 border-b pb-1">
                            <div class="flex justify-between">
                                <span>{{ ucfirst($note->notification_type) }}</span>
                                <form method="POST" action="{{ route('notifications.read', $note->id) }}">
                                    @csrf
                                    <button class="text-sm text-blue-500">Mark Read</button>
                                </form>
                            </div>
                            <div class="text-sm">{{ json_encode($note->details) }}</div>
                        </li>
                    @empty
                        <li>No unread notifications</li>
                    @endforelse
                </ul>
            </aside>
            @endauth
        </main>

        <footer class="bg-gray-800 text-white py-4 text-center">
            &copy; {{ date('Y') }} DomainDash. All rights reserved.
        </footer>
    </div>
</body>
</html>
