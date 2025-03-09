<div class="flex items-start max-md:flex-col">
    <div class="mr-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            <flux:navlist.item :href="route('leaderboards.25.1')" wire:navigate>{{ __('25.1') }}</flux:navlist.item>
            <flux:navlist.item :href="route('leaderboards.25.2')" wire:navigate>{{ __('25.2') }}</flux:navlist.item>
            <flux:navlist.item :href="route('dashboard')" icon="arrow-uturn-left" wire:navigate></flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        @if (isset($heading))
            <flux:heading>{{ $heading ?? '' }}</flux:heading>
            <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>
        @endif

        <div class="w-full">
            {{ $slot }}
        </div>
    </div>
</div>
