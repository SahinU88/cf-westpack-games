<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-linear-to-b dark:from-fuchsia-950 dark:to-fuchsia-900">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-slate-900">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <a href="{{ route('dashboard') }}" class="ml-2 mr-5 flex items-center space-x-2 lg:ml-0" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Leaderboard') }}
                </flux:navbar.item>

                <flux:navlist.item :href="route('scores.overview')" :current="request()->routeIs('scores.*')" wire:navigate>
                    {{ __('Your Scores') }}
                </flux:navlist.item>

                <flux:navbar.item :href="route('leaderboards.25.1')" :current="request()->routeIs('leaderboards.25.1')" wire:navigate>
                    {{ __('25.1') }}
                </flux:navbar.item>

                <flux:navbar.item :href="route('leaderboards.25.2')" :current="request()->routeIs('leaderboards.25.2')" wire:navigate>
                    {{ __('25.2') }}
                </flux:navbar.item>

                <flux:navbar.item :href="route('leaderboards.25.3')" :current="request()->routeIs('leaderboards.25.3')" wire:navigate>
                    {{ __('25.3') }}
                </flux:navbar.item>

                <flux:navbar.item :href="route('leaderboards.25.4')" :current="request()->routeIs('leaderboards.25.4')" wire:navigate>
                    {{ __('Bonus WOD 25.4') }}
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <flux:navbar class="mr-1.5 space-x-0.5 py-0!">
                <flux:navbar.item class="max-lg:hidden" :href="route('teams.overview')" :current="request()->routeIs('teams.overview')" wire:navigate>
                    {{ __('Teams') }}
                </flux:navbar.item>
                <flux:tooltip content="Info zu den Westpack Festspiele" position="bottom">
                    <flux:navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        icon="book-open-text"
                        href="https://www.crossfitwestpack.at/festspiele"
                        target="_blank"
                        label="Info zu den Westpack Festspiele"
                    />
                </flux:tooltip>
            </flux:navbar>

            <!-- Desktop User Menu -->
            <flux:dropdown position="top" align="end">
                <flux:profile
                    class="cursor-pointer"
                    :initials="auth()->user()->initials()"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar stashable sticky class="lg:hidden border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="ml-1 flex items-center space-x-2" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group heading="Platform">
                    <flux:navlist.item icon="trophy" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Leaderboard') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="numbered-list" :href="route('scores.overview')" :current="request()->routeIs('scores.*')" wire:navigate>
                        {{ __('Your Scores') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="bolt" :href="route('leaderboards.25.1')" :current="request()->routeIs('leaderboards.25.1')" wire:navigate>
                        {{ __('25.1') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="bolt" :href="route('leaderboards.25.2')" :current="request()->routeIs('leaderboards.25.2')" wire:navigate>
                        {{ __('25.2') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="bolt" :href="route('leaderboards.25.3')" :current="request()->routeIs('leaderboards.25.3')" wire:navigate>
                        {{ __('25.3') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="bolt" :href="route('leaderboards.25.4')" :current="request()->routeIs('leaderboards.25.4')" wire:navigate>
                        {{ __('Bonus WOD 25.4') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="user-group" :href="route('teams.overview')" :current="request()->routeIs('teams.overview')" wire:navigate>
                    {{ __('Teams') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://www.crossfitwestpack.at/festspiele" target="_blank">
                    {{ __('Info zu Westpack Festspiele') }}
                </flux:navlist.item>
            </flux:navlist>
        </flux:sidebar>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
