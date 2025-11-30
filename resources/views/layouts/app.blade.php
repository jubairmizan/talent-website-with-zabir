<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="api-token" content="{{ auth()->user()->createToken('api-token')->plainTextToken }}">
       
        <meta name="member-id" content="{{ auth()->user()->id }}">

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

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

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
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        
        <!-- Include Chat Interface for authenticated users -->
        @auth
            @if(auth()->user()->isMember())
                @include('components.chat-interface')
            @endif
        @endauth
        
        <!-- Laravel User Data for JavaScript -->
        @auth
        <script>
            window.Laravel = {
                user: {
                    id: {{ auth()->id() }},
                    name: "{{ auth()->user()->name }}",
                    role: "{{ auth()->user()->role }}"
                }
            };
        </script>
        @endauth
    </body>
</html>
