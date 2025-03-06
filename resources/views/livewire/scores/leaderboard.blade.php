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
        @foreach ($rankingOpenWod251 as $rank)
            <flux:table.row>
                <flux:table.cell variant="strong">
                    #{{ $loop->iteration }}
                </flux:table.cell>
                <flux:table.cell>
                    <span>{{ $rank['team']->name }}</span>
                </flux:table.cell>
                <flux:table.cell align="end">
                    <div>{{ $rank['total_points'] }}</div>
                    <div class="mt-1 text-black/50 dark:text-white/50">({{ $rank['scores_rx']['points'] }} + {{ $rank['scores_scaled']['points'] }})</div>
                </flux:table.cell>
                <flux:table.cell align="end">
                    <flux:icon.ellipsis-horizontal variant="solid" class="inline-block text-black/50 dark:text-white/50" />
                </flux:table.cell>
                <flux:table.cell align="end">
                    <flux:icon.ellipsis-horizontal variant="solid" class="inline-block text-black/50 dark:text-white/50" />
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
