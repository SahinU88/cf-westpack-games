<div class="flex items-start max-md:flex-col">
    <div class="mr-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            <flux:navlist.item :href="route('teams.overview')" :current="request()->routeIs('teams.overview')" wire:navigate>Teamübersicht</flux:navlist.item>
            <flux:separator class="mb-2" />
            @foreach ($teams as $team)
                <flux:navlist.item
                    :href="route('teams.detail', $team->slug)"
                    :current="request()->routeIs('teams.detail') && request()->route('team')->slug == $team->slug"
                    wire:navigate
                >
                        {{ $team->name }}
                </flux:navlist.item>
            @endforeach
            <flux:separator class="my-2" />
            <flux:navlist.item :href="route('dashboard')" icon="arrow-uturn-left" wire:navigate>Dashboard</flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full">
            {{ $slot }}
        </div>
    </div>
</div>
