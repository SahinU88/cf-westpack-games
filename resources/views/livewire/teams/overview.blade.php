<section class="w-full">
    @include('partials.scores-heading')

    <x-teams.layout :heading="__('Teams')" :subheading="__('Die Teams der Westpack Festspiele')" :teams="$teams">

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
            @foreach ($teams as $team)

            <div class="rounded-2xl overflow-hidden shadow-lg">
                <flux:link href="#" wire:navigate>
                    <img class="w-full object-contain transition-all duration-300 hover:scale-110" src="{{ $team->image_url }}" alt="{{ $team->name }}" />
                </flux:link>
            </div>
            @endforeach
        </div>
    </x-teams.layout>
</section>
