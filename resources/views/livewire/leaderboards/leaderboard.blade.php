<flux:table>
    <flux:table.columns>
        <flux:table.column>Rank</flux:table.column>
        <flux:table.column>Team</flux:table.column>
        <flux:table.column align="right">25.1</flux:table.column>
        <flux:table.column align="right">25.2</flux:table.column>
        <flux:table.column align="right">25.3</flux:table.column>
        <flux:table.column align="right">Bonus WOD</flux:table.column>
        <flux:table.column align="right">Total</flux:table.column>
    </flux:table.columns>

    <flux:table.rows>
        @foreach ($rankings as $rank)
            <flux:table.row>
                <flux:table.cell variant="strong">
                    #{{ $loop->iteration }}
                </flux:table.cell>
                <flux:table.cell>
                    <span>{{ $rank['team']->name }}</span>@if (auth()->user()->team_id === $rank['team']->id)<span class="inline-flex items-center rounded-md bg-green-100 ml-2 px-1.5 py-0.5 text-xs font-medium text-green-700">Your Team</span>@endif
                </flux:table.cell>
                <flux:table.cell align="end">
                    <div>{{ $rank['points_251']['total'] }}</div>
                    <div class="mt-1 text-black/50 dark:text-white/50">({{ $rank['points_251']['rx'] }} + {{ $rank['points_251']['scaled'] }})</div>
                </flux:table.cell>
                <flux:table.cell align="end">
                    <div>{{ $rank['points_252']['total'] }}</div>
                    <div class="mt-1 text-black/50 dark:text-white/50">({{ $rank['points_252']['rx'] }} + {{ $rank['points_252']['scaled'] }})</div>
                </flux:table.cell>
                <flux:table.cell align="end">
                    <div>{{ $rank['points_253']['total'] }}</div>
                    <div class="mt-1 text-black/50 dark:text-white/50">({{ $rank['points_253']['rx'] }} + {{ $rank['points_253']['scaled'] }})</div>
                </flux:table.cell>
                <flux:table.cell align="end">
                    <flux:icon.ellipsis-horizontal variant="solid" class="inline-block text-black/50 dark:text-white/50" />
                </flux:table.cell>
                <flux:table.cell align="end" variant="strong">
                    {{ $rank['total_points'] }}
                </flux:table.cell>
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>
