<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head')

<body class="font-sans antialiased bg-radial-[at_25%_25%] from-fuchsia-800 from-60% to-fuchsia-950">
    <div class="flex flex-col items-center px-6 py-12 sm:pt-0 ">
        <div class="mt-12">
            <a href="/" wire:navigate class="text-2xl font-bold text-white/80">
                Westpack Festspiele
            </a>
        </div>

        <div class="w-full sm:max-w-7xl lg:max-w-5xl mt-6 px-6 py-4 text-white/50 bg-slate-950 shadow-md overflow-hidden rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
