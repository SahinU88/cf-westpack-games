<div>
    <flux:heading>Leaderboard 25.2</flux:heading>
    <flux:subheading>{{ $division }}</flux:subheading>

    <div class="w-full mb-4"></div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Rank</flux:table.column>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Team</flux:table.column>
            <flux:table.column align="right">Score</flux:table.column>
            <flux:table.column align="right">Points</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($rankings as $rank)
                <flux:table.row>
                    <flux:table.cell variant="strong">
                        #{{ $rank['rank'] }}
                    </flux:table.cell>
                    <flux:table.cell>
                        <span>{{ $rank['user']->name }}</span>
                        @if (auth()->user()->id === $rank['user']->id)<span class="inline-flex items-center rounded-md bg-green-100 px-1.5 py-0.5 text-xs font-medium text-green-700">You</span>@endif
                    </flux:table.cell>
                    <flux:table.cell>
                        <span>{{ $rank['team']->name }}</span>
                    </flux:table.cell>
                    <flux:table.cell align="end">
                        @if ($rank['finishedWod'])
                            {{ $rank['time'] }} ({{ $rank['tiebreak'] }})
                        @else
                            {{ $rank['reps'] }} ({{ $rank['tiebreak'] }})
                        @endif
                    </flux:table.cell>
                    <flux:table.cell variant="strong" align="end">
                        {{ $rank['points'] }}
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
