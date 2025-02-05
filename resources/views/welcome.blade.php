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
                                Schön, dass du bei unserer Challenge mitmachen möchtest!
                            </div>
                        </div>
                        <h1 class="text-5xl font-semibold tracking-tight text-balance sm:text-7xl">
                            Westpack Festspiele
                        </h1>
                        <p class="mt-12 text-lg font-medium text-pretty sm:text-xl/8 text-white/75">
                            Wir sammeln hier alle Anmeldungen und benötigen ein paar grobe Fitness-Daten von dir.
                            Nach dem die Anmeldung geschlossen ist, werden alle Teilnehmenden in Teams aufgeteilt,
                            welche dann gegeneinander
                            antreten.
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="{{ route('register') }}"
                                class="flex gap-2 items-center text-sm/6 font-semibold bg-fuchsia-950 px-4 py-2 rounded-md hover:bg-fuchsia-900 hover:text-white">
                                Jetzt anmelden
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                    class="size-4">
                                    <path fill-rule="evenodd"
                                        d="M2 8c0 .414.336.75.75.75h8.69l-1.22 1.22a.75.75 0 1 0 1.06 1.06l2.5-2.5a.75.75 0 0 0 0-1.06l-2.5-2.5a.75.75 0 1 0-1.06 1.06l1.22 1.22H2.75A.75.75 0 0 0 2 8Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
