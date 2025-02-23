<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head')

<body class="font-sans antialiased text-white/80">
    <div
        class="min-h-screen flex items-center justify-center bg-radial-[at_25%_25%] from-fuchsia-800 from-60% to-fuchsia-950">
        <div class="relative isolate">
            <div class="py-24 sm:py-32 lg:pb-40">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">

                        <div class="mb-8 flex justify-center">
                            <div class="relative rounded-full px-3 py-1 text-sm/6 text-white/50">
                                Anmeldung geschlossen!
                            </div>
                        </div>
                        <h1 class="text-5xl font-semibold tracking-tight text-balance sm:text-7xl">
                            Westpack Festspiele
                        </h1>
                        <p class="mt-12 text-lg font-medium text-pretty sm:text-xl/8 text-white/75">
                            Danke für eure zahlreichen Anmeldungen. Wir schauen uns eure Profile an und teilen euch in Teams auf.
                        </p>
                        <p class="mt-12 text-lg font-medium text-pretty sm:text-xl/8 text-white/75">
                            Nähere Details folgen in Kürze!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
