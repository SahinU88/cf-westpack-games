<x-layouts.app>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="relative overflow-hidden p-4 rounded-xl">

            <flux:heading level="2" class="mb-4 text-xl">
                Leaderboard
            </flux:heading>

            <div class="w-full border-t border-white/50 mb-4"></div>

            <livewire:leaderboards.leaderboard />

        </div>

        <div class="w-full my-8"></div>

        <livewire:scores.score-cards />

    </div>

</x-layouts.app>
