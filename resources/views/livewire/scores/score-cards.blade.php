<div>
    <flux:heading level="3">
        Your Scores
    </flux:heading>

    <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Start: score open wod 25.1 --}}
        <div class="relative overflow-hidden rounded-lg bg-zinc-50 dark:bg-white/90 px-4 pt-5 pb-12 shadow-lg sm:px-6 sm:pt-6">
            <dt>
                <p class="text-sm font-medium text-gray-500">25.1</p>
            </dt>
            <dd class="flex items-baseline pb-6 sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">{{ $score251->data['score'] }} reps</p>
                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                    <flux:icon.hashtag /> {{ $rankingOpenWod251['rank'] }} ({{ $rankingOpenWod251['division'] }})
                </p>
                <div class="absolute inset-x-0 bottom-0 px-4 py-4 sm:px-6">
                    <div class="text-xs">
                        <a href="{{ route('leaderboards.25.1') }}" class="font-medium text-black hover:text-black/50">View leaderboard</a>
                    </div>
                </div>
            </dd>
        </div>
        {{-- End: score open wod 25.1 --}}

        {{-- Start: score open wod 25.2 --}}
        <div class="relative overflow-hidden rounded-lg bg-zinc-50 dark:bg-white/90 px-4 pt-5 pb-12 shadow-lg sm:px-6 sm:pt-6">
            <dt>
                <p class="text-sm font-medium text-gray-500">25.2</p>
            </dt>
            <dd class="flex flex-wrap items-baseline pb-6 sm:pb-7">
                <div class="text-2xl font-semibold">
                    <p class="text-gray-900">
                        @if ($score252->data['finishedWod'])
                            {{ $score252->data['time'] }}
                        @else
                            {{ $score252->data['reps'] }} reps
                        @endif
                    </p>
                </div>
                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                    <flux:icon.hashtag /> {{ $rankingOpenWod252['rank'] }} ({{ $rankingOpenWod252['division'] }})
                </p>
                <p class="basis-full text-sm text-gray-500">
                    Tiebreak: {{ $score252->data['tiebreak'] }} <flux:icon.clock class="inline-block size-5 pb-1" />
                </p>
                <div class="absolute inset-x-0 bottom-0 flex justify-between px-4 py-4 sm:px-6">
                    <div class="text-xs">
                        <a href="{{ route('leaderboards.25.2') }}" class="font-medium text-black hover:text-black/50">View leaderboard</a>
                    </div>
                </div>
            </dd>
        </div>
        {{-- End: score open wod 25.2 --}}

        {{-- Start: score open wod 25.3 --}}
        <div class="relative overflow-hidden rounded-lg bg-zinc-50 dark:bg-white/90 px-4 pt-5 pb-12 shadow-lg sm:px-6 sm:pt-6">
            <dt>
                <p class="text-sm font-medium text-gray-500">25.3</p>
            </dt>
            <dd class="flex flex-wrap items-baseline pb-6 sm:pb-7">
                <div class="text-2xl font-semibold">
                    <p class="text-gray-900">
                        @if ($score253->data['finishedWod'])
                            {{ $score253->data['time'] }}
                        @else
                            {{ $score253->data['reps'] }} reps
                        @endif
                    </p>
                </div>
                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                    <flux:icon.hashtag /> {{ $rankingOpenWod253['rank'] }} ({{ $rankingOpenWod253['division'] }})
                </p>
                <p class="basis-full text-sm text-gray-500">
                    Tiebreak: {{ $score253->data['tiebreak'] }} <flux:icon.clock class="inline-block size-5 pb-1" />
                </p>
                <div class="absolute inset-x-0 bottom-0 flex justify-between px-4 py-4 sm:px-6">
                    <div class="text-xs">
                        <a href="{{ route('leaderboards.25.3') }}" class="font-medium text-black hover:text-black/50">View leaderboard</a>
                    </div>
                </div>
            </dd>
        </div>
        {{-- End: score open wod 25.3 --}}

        {{-- Start: score bonus wod --}}
        <div class="relative overflow-hidden rounded-lg bg-white dark:bg-white px-4 pt-5 pb-12 shadow-lg sm:px-6 sm:pt-6">
            <dt>
                <p class="text-sm font-medium text-gray-500">Bonus WOD 25.4</p>
            </dt>
            <dd class="flex flex-wrap items-baseline pb-6 sm:pb-7">
                <div class="text-2xl font-semibold">
                    <p class="text-gray-900">
                        {{ $score254->data['reps'] }} reps
                    </p>
                </div>
                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                    <flux:icon.hashtag />  {{ $rankingOpenWod254['rank'] }} ({{ $rankingOpenWod254['division'] }})
                </p>
                <p class="basis-full text-sm text-gray-500">
                    Tiebreak: {{ $score254->data['tiebreak'] }} <flux:icon.clock class="inline-block size-5 pb-1" />
                </p>
                <div class="absolute inset-x-0 bottom-0 px-4 py-4 sm:px-6">
                    <div class="absolute inset-x-0 bottom-0 flex justify-between px-4 py-4 sm:px-6">
                        <div class="text-xs">
                            <a href="{{ route('scores.bonus-wod-25.4') }}" class="font-medium text-black hover:text-black/50">Submit</a>
                        </div>
                        <div class="text-xs">
                            <a href="{{ route('leaderboards.25.4') }}" class="font-medium text-black hover:text-black/50">View leaderboard</a>
                        </div>
                    </div>
                </div>
            </dd>
        </div>
        {{-- End: score bonus wod --}}
    </dl>
</div>
