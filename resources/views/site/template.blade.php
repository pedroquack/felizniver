<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>felizNiver</title>
</head>
<body class="bg-cyan-400">
    <img src="{{ asset('static/flags.png') }}" alt="" class="fixed -z-10 w-full opacity-60 md:opacity-20 transition">
    <nav class="flex justify-center">
        <a href="{{ route('site.create') }}" class="flex items-center gap-1 text-xl h-16 text-white font-bold">
            <img src="{{ asset('static/logo.png') }}" alt="Emoji de aniversário" class="w-8">
            felizNiver
        </a>
    </nav>
    <main class="p-4">
        <div class="w-full md:w-1/2 m-auto">
            @yield('content')
        </div>
    </main>
</body>
</html>
