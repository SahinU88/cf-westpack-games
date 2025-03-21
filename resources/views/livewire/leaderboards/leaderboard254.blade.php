<section class="w-full">
    @include('partials.leaderboards-heading')

    <x-leaderboards.layout>
        <flux:tab.group>
            <flux:tabs>
                <flux:tab name="rx">Rx</flux:tab>
                <flux:tab name="scaled">Scaled</flux:tab>
                <flux:tab name="all">All</flux:tab>
            </flux:tabs>

            <flux:tab.panel name="rx">
                <x-leaderboards.leaderboard-254-individual :rankings="$rankingsRx" division="Rx" />
            </flux:tab.panel>
            <flux:tab.panel name="scaled">
                <x-leaderboards.leaderboard-254-individual :rankings="$rankingsScaled" division="Scaled" />
            </flux:tab.panel>
            <flux:tab.panel name="all">
                <x-leaderboards.leaderboard-254-individual :rankings="$rankings" division="Combined (zählt nicht zur Wertung)" />
            </flux:tab.panel>
        </flux:tab.group>
    </x-leaderboards.layout>
</section>
