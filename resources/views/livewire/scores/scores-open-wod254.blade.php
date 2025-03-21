<section class="w-full">
    @include('partials.scores-heading')

    <x-scores.layout :heading="__('Bonus WOD 25.4')" :subheading="__('Submit your score until 25.03.2025 23:59')">

        <x-action-message class="w-full me-3" on="score-deadline-passed">
            <div class="w-full rounded-md bg-red-50 p-4 mb-4">
                <div class="flex">
                    <div class="shrink-0">
                        ⚠️
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">{{ __('Submission closed') }}</h3>
                    </div>
                </div>
            </div>
        </x-action-message>

        <flux:card class="space-y-6">
            <form wire:submit="updateScore" class="flex flex-col gap-6">

                <flux:field>
                    <flux:label>Total repetitions of Wall Balls</flux:label>
                    <flux:input.group>
                        <flux:input wire:model="reps" id="reps" placeholder="157" type="number" name="reps" min="0" required />
                        <flux:input.group.suffix>reps</flux:input.group.suffix>
                    </flux:input.group>
                </flux:field>

                <flux:field>
                    <flux:label>Tiebreak time</flux:label>
                    <flux:input.group>
                        <flux:input wire:model="tiebreak" id="tiebreak" name="tiebreak" placeholder="11:30" mask="99:99" value="10:56" required />
                        <flux:input.group.suffix>min</flux:input.group.suffix>
                    </flux:input.group>
                </flux:field>

                <flux:select wire:model="division" variant="listbox" placeholder="Wähle deine Division aus" required>
                    <flux:select.option value="rx">RX</flux:select.option>
                    <flux:select.option value="scaled">Scaled</flux:select.option>
                </flux:select>

                <flux:button variant="primary" type="submit" class="cursor-pointer">Absenden</flux:button>

                <x-action-message class="w-full me-3" on="score-submitted">
                    <div class="rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="shrink-0">
                                🎉
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ __('Submitted.') }}</p>
                            </div>
                        </div>
                    </div>
                </x-action-message>
            </form>
        </flux:card>
    </x-scores.layout>
</section>
