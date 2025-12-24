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
<body class="h-full font-sans antialiased text-white bg-[#0F172A] relative overflow-hidden">
    
    <!-- Background Patterns -->
    <div class="absolute inset-0 z-0">
        <!-- Floating shapes/dots -->
        <div class="absolute top-20 left-20 w-2 h-2 bg-blue-500 rounded-full opacity-50 animate-pulse"></div>
        <div class="absolute top-40 right-40 w-3 h-3 bg-emerald-500 rounded-full opacity-30 animate-bounce" style="animation-duration: 3s"></div>
        <div class="absolute bottom-1/3 left-1/4 w-1 h-1 bg-white rounded-full opacity-20"></div>
        <div class="absolute top-1/2 right-1/3 w-2 h-2 bg-purple-500 rounded-full opacity-20"></div>
        <div class="absolute top-10 right-10 w-20 h-20 bg-blue-600/10 rounded-full blur-xl"></div>
        <div class="absolute bottom-20 left-10 w-32 h-32 bg-emerald-600/10 rounded-full blur-2xl"></div>
    </div>

    <!-- Wave Background -->
    <div class="absolute bottom-0 left-0 right-0 z-0">
        <svg class="w-full" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
            <path fill="rgba(255, 255, 255, 0.05)" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,261.3C960,256,1056,224,1152,213.3C1248,203,1344,213,1392,218.7L1440,224V320H1392C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320H0V224Z"></path>
            <path fill="#ffffff" fill-opacity="1" d="M0,288L48,272C96,256,192,224,288,218.7C384,213,480,235,576,250.7C672,267,768,277,864,266.7C960,256,1056,224,1152,218.7C1248,213,1344,235,1392,245.3L1440,256V320H1392C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320H0V288Z"></path>
        </svg>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        {{ $slot }}
    </div>

</body>
</html>
