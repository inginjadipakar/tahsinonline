<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .glass-input {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glass-input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #10B981; /* emerald-500 */
        }
    </style>
</head>
<body class="min-h-screen font-sans antialiased text-gray-900 dark:text-white bg-transparent">
    
    <!-- Main Content -->
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        {{ $slot }}
    </div>

</body>
</html>
