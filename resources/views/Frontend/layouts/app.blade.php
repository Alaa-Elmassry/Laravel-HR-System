<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Hirebridge')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div class="app-shell">
        @include('partials.sidebar-candidate')

        <div class="app-main">
            @include('partials.topbar')

            <main class="app-content">
                @yield('content')
            </main>
        </div>
    </div>

    <div class="sidebar-overlay" data-sidebar-overlay></div>

    @stack('modals')
    @stack('scripts')
</body>
</html>
