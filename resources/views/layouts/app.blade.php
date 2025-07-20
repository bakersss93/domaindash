<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DomainDash') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false }">
<div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside :class="{'-translate-x-full': !sidebarOpen}" class="fixed inset-y-0 left-0 w-64 bg-white border-r transform transition-transform duration-200 lg:translate-x-0 lg:static lg:inset-0">
        <div class="h-full flex flex-col p-4">
            <div class="flex items-center justify-between mb-6 lg:hidden">
                <h1 class="text-lg font-bold">{{ config('app.name', 'DomainDash') }}</h1>
                <button @click="sidebarOpen=false" class="text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="flex-1 space-y-2">
                <a href="{{ route('domains.index') }}" class="block px-2 py-1 rounded hover:bg-gray-200">Domains</a>
                <a href="{{ route('hosting-services.index') }}" class="block px-2 py-1 rounded hover:bg-gray-200">Services</a>
                <a href="{{ route('ssl-services.index') }}" class="block px-2 py-1 rounded hover:bg-gray-200">SSLs</a>
                <a href="{{ route('users.index') }}" class="block px-2 py-1 rounded hover:bg-gray-200">Clients</a>
                <a href="{{ route('synergy-api.edit') }}" class="block px-2 py-1 rounded hover:bg-gray-200">Admin Settings</a>
            </nav>
        </div>
    </aside>

    <!-- Content -->
    <div class="flex-1 flex flex-col min-h-screen lg:ms-64">
        <!-- Header -->
        <header class="flex items-center justify-between bg-white border-b px-4 py-3">
            <div class="flex items-center">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 focus:outline-none lg:hidden me-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="relative" x-data="{ open:false }">
                    <button @click="open=!open" class="flex items-center text-gray-700 focus:outline-none">
                        <span class="mr-1">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open=false" class="absolute mt-2 w-48 bg-white border rounded shadow-lg z-50" style="display:none;">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Log Support Ticket</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main -->
        <main class="flex-1 p-4">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
