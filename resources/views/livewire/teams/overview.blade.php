<section class="w-full">
    @include('partials.teams-heading')

    <x-teams.layout :heading="__('Teams')" :subheading="__('All the amazing teams.')" :teams="$teams">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            @foreach ($teams as $team)
                <a href="{{ route('teams.detail', $team->slug) }}" class="">
                    <img
                        class="w-full rounded-2xl overflow-hidden shadow-lg object-contain transition-all duration-300 hover:scale-105"
                        src="{{ $team->image_url }}"
                        alt="{{ $team->name }}"
                    />
                </a>
            @endforeach
        </div>
    </x-teams.layout>
</section>
