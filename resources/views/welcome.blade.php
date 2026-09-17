<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FitNova Gym') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-indigo-950">
        <nav class="max-w-6xl mx-auto px-4 sm:px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-2 text-white">
                <svg class="h-8 w-8 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 3c.6 3.5-1.3 6.6-4.5 6.6-.6 0-1.2-.1-1.7-.3C7.8 13 10.9 16 14.5 16c4.6 0 7.5-3 7.5-8.2V3h-9z"/>
                    <path d="M4 8.5C4 14.8 9.5 19 16 19.5c1.2 0 2.4-.1 3.5-.4-1 2.8-3.6 4.9-6.8 4.9C7.4 24 3 19.6 3 14.2c0-3.2 2.1-5.8 4.9-6.8-.1.7-.1 1.4-.1 1.1 0 2 1.3 3.7 3.2 4.5a6.5 6.5 0 0 1-2.4-4.3c0-.3 0-.7 0-1V8.5z" opacity=".55"/>
                </svg>
                <span class="text-xl font-extrabold tracking-tight">{{ config('app.name', 'FitNova Gym') }}</span>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-400 text-white rounded-md font-semibold text-sm transition">Ir al panel</a>
                @else
                    <a href="{{ route('login') }}" class="text-white/80 hover:text-white text-sm font-medium transition">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-white text-indigo-950 rounded-md font-semibold text-sm hover:bg-indigo-100 transition">Registrarse</a>
                @endauth
            </div>
        </nav>

        <main class="max-w-6xl mx-auto px-4 sm:px-6">
            <section class="py-16 sm:py-24 text-center">
                <p class="text-indigo-400 text-sm font-semibold uppercase tracking-widest">Sistema de gestión integral</p>
                <h1 class="mt-4 text-4xl sm:text-6xl font-extrabold text-white leading-tight">
                    Tu gimnasio,<br>al siguiente nivel
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-lg text-indigo-200">
                    Gestioná socios, membresías, pagos, rutinas de entrenamiento y clases grupales
                    con una plataforma moderna, segura y 100% responsiva.
                </p>

                @auth
                    <a href="{{ route('dashboard') }}" class="mt-8 inline-flex items-center px-6 py-3 bg-indigo-500 hover:bg-indigo-400 text-white rounded-lg font-semibold transition">Entrar al panel →</a>
                @else
                    <a href="{{ route('register') }}" class="mt-8 inline-flex items-center px-6 py-3 bg-indigo-500 hover:bg-indigo-400 text-white rounded-lg font-semibold transition">Comenzar ahora →</a>
                @endauth
            </section>

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pb-20">
                @php
                    $modulos = [
                        ['Socios', 'Alta, edición y búsqueda de miembros con su historial completo.', 'M20 6h-1v-6a2 2 0 00-2-2H7a2 2 0 00-2 2v6H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2zM7 4h10v2H7V4z'],
                        ['Membresías y pagos', 'Planes, vencimientos y registro de cobros con alertas de morosos.', 'M4 2a2 2 0 00-2 2v3h4V4h4v3h4V4h4v3h4V4a2 2 0 00-2-2H4zm-2 7v11a2 2 0 002 2h16a2 2 0 002-2V9H2z'],
                        ['Rutinas', 'Asignación de planes de entrenamiento y ejercicios por entrenador.', 'M6 2a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H6zm3 4h6v2H9V6zm0 4h6v2H9v-2zm0 4h6v2H9v-2z'],
                        ['Clases', 'Agenda de clases grupales, cupos e inscripciones de socios.', 'M8 3v2h8V3h-2v2h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h2V3h2zm2 6v3h3V9h-3z'],
                    ];
                @endphp

                @foreach ($modulos as [$titulo, $descripcion, $path])
                    <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                        <div class="h-10 w-10 rounded-lg bg-indigo-500/20 flex items-center justify-center mb-4">
                            <svg class="h-6 w-6 text-indigo-400" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $path }}"/></svg>
                        </div>
                        <h3 class="text-white font-semibold">{{ $titulo }}</h3>
                        <p class="mt-2 text-sm text-indigo-200/80 leading-relaxed">{{ $descripcion }}</p>
                    </div>
                @endforeach
            </section>

            <footer class="border-t border-white/10 py-8 text-center text-sm text-indigo-300/70">
                {{ config('app.name', 'FitNova Gym') }} — Proyecto Integrador · Programación Web III
            </footer>
        </main>
    </body>
</html>