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
        <div class="relative h-full content-center text-center overflow-hidden p-4 rounded-xl border-2 border-dashed border-neutral-200">
            <svg class="mx-auto size-16 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.242 5.992h12m-12 6.003H20.24m-12 5.999h12M4.117 7.495v-3.75H2.99m1.125 3.75H2.99m1.125 0H5.24m-1.92 2.577a1.125 1.125 0 1 1 1.591 1.59l-1.83 1.83h2.16M2.99 15.745h1.125a1.125 1.125 0 0 1 0 2.25H3.74m0-.002h.375a1.125 1.125 0 0 1 0 2.25H2.99" />
            </svg>
            In Kürze seht ihr alle Teams sowie die Scores aller Teilnehmenden 👀
        </div>
    </div>
</x-layouts.app>
