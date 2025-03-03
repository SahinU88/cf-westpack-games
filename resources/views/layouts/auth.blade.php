<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head')

<body class="h-full font-sans antialiased bg-radial-[at_25%_25%] from-fuchsia-800 from-60% to-fuchsia-950">
    {{ $slot }}
</body>

</html>
