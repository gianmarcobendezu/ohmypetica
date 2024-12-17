<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen flex flex-col md:flex-row">
            <!-- Sidebar -->
            <div class="w-full md:w-64 bg-gray-100 text-white flex flex-col bg-white md:static" x-data="{ open: false }">
                <!-- Mobile Hamburger Button -->
                <button 
                    class="p-4 bg-gray-100 text-gray-700 md:hidden focus:outline-none"
                    @click="open = !open">
                    <!-- Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5M3.75 12h16.5m-16.5 6.75h16.5" />
                    </svg>
                </button>

                <!-- Menu -->
                <div 
                    :class="{ 'hidden': !open }" 
                    class="md:block md:flex-grow">
                    <div class="flex items-center justify-center p-6 bg-white">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-16 h-16">
                    </div>
                    <nav class="flex-grow">
                        <ul>
                            <!-- Dashboard -->
                            <li>
                                <a href="{{ route('dashboard') }}" 
                                   class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-700 hover:text-white">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3M21 16h-5m0 0l-5-5m5 5l5-5" />
                                </svg>  
                                   Dashboard
                                </a>
                            </li>
                            <!-- Profile -->
                            <li>
                                <a href="{{ route('profile.show') }}" 
                                   class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-700 hover:text-white">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 19.364A9 9 0 1116.243 8.243m-2.12 9.9a3 3 0 11-4.243-4.243" />
                                </svg> 
                                   Perfil
                                    
                                </a>
                            </li>
                            <!-- Other links -->
                            <li>
                                <a href="{{ route('clinical-history') }}" 
                                   class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-700 hover:text-white">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3a6.75 6.75 0 016.75 6.75c0 3.83-3.076 6.753-6.826 7.11-.217.016-.434.024-.651.024C5.076 17.883 2 14.96 2 11.25a6.75 6.75 0 016.75-6.75zm5.252 2.9a.75.75 0 01.608-.842A4.243 4.243 0 0117.167 11H20.75a.75.75 0 010 1.5H16.25a4.25 4.25 0 01-4.25-4.25V7.5z" />
                                </svg>
                                    Historia Clínica
                                </a>
                            </li>
                            <li>
                                <a href="#" 
                                   class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-700 hover:text-white">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3a6.75 6.75 0 016.75 6.75c0 3.83-3.076 6.753-6.826 7.11-.217.016-.434.024-.651.024C5.076 17.883 2 14.96 2 11.25a6.75 6.75 0 016.75-6.75zm5.252 2.9a.75.75 0 01.608-.842A4.243 4.243 0 0117.167 11H20.75a.75.75 0 010 1.5H16.25a4.25 4.25 0 01-4.25-4.25V7.5z" />
                                </svg> 
                                   Ayuda
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-red-600 text-red-500 hover:text-white">
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 bg-gray-100">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('modals')
<!---
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
-->

        @livewireScripts
        
        <!-- AlpineJS para manejar la interacción -->
        
    </body>
</html>