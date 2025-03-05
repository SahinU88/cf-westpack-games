<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="relative content-center text-center overflow-hidden">
                <flux:button
                    href="{{ route('scores.open-wod-25.1') }}"
                    icon-training="arrow-up-right"
                    variant="ghost"
                >
                    Trage deinen Score für 25.1 ein
                </flux:button>
            </div>
            <div class="relative content-center text-center overflow-hidden">
                <flux:button
                    icon-training="arrow-up-right"
                    variant="subtle"
                    disabled
                >
                    Trage deinen Score für 25.2 ein
                </flux:button>
            </div>
            <div class="relative content-center text-center overflow-hidden">
                <flux:button
                    icon-training="arrow-up-right"
                    variant="subtle"
                    disabled
                >
                    Trage deinen Score für 25.3 ein
                </flux:button>
            </div>
        </div>
        <div class="relative h-full overflow-hidden p-4 rounded-xl">
            <flux:heading class="mb-4">
                Leaderboard
            </flux:heading>
            <x-scores.leaderboard />
        </div>
    </div>
</x-layouts.app>
