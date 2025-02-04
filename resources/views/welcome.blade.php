<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Westpack Festspiele</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="bg-gray-50 text-black/50 dark:bg-purple-950 dark:text-white/80">
            <div class="relative min-h-screen flex flex-col items-center justify-center">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-5xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            Welcome to the Westpack Festspiele!
                        </div>
                    </header>

                    <main class="mt-6">
                        <div class="grid gap-6 lg:grid-cols-1 lg:gap-8 text-center">
                            <h2 class="text-4xl">Schön, dass du bei unserer Challenge mitmachen möchtest!</h2>

                            <p>
                                Wir sammeln hier alle Anmeldungen und benötigen ein paar grobe Fitness-Daten von dir.
                                Nach dem die Anmeldung geschlossen ist, werden alle Teilnehmenden in Teams aufgeteilt, welche dann gegeneinander antreten.
                            </p>

                            <a href="{{ route('register') }}" class="px-6 py-3 mt-6 hover:underline">
                                Jetzt anmelden
                            </a>
                        </div>
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        🤩
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
