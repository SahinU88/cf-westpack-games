<div class="flex items-start max-md:flex-col">
    <div class="mr-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            <flux:navlist.item :href="route('scores.open-wod-25.1')" wire:navigate>{{ __('Open WOD 25.1') }}</flux:navlist.item>
            {{-- <flux:navlist.item href="#">{{ __('Open WOD 25.2') }}</flux:navlist.item>
            <flux:navlist.item href="#">{{ __('Open WOD 25.3') }}</flux:navlist.item> --}}
            <flux:navlist.item :href="route('dashboard')" icon="arrow-uturn-left" wire:navigate>{{ __('Zurück zur Übersicht') }}</flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
