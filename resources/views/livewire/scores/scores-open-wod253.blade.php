<section class="w-full">
    @include('partials.scores-heading')

    <x-scores.layout :heading="__('Open WOD 25.3')" :subheading="__('Submit your score until 18.03.2025 23:59')">

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
                    <flux:label>Did you finish the workout?</flux:label>

                    <flux:select wire:model="finishedWod" placeholder="Did you finish the workout?">
                        <flux:select.option>Yes</flux:select.option>
                        <flux:select.option>No</flux:select.option>
                    </flux:select>
                </flux:field>

                <flux:field wire:show="finishedWod === 'Yes'">
                    <flux:label>Time for finishing the workout</flux:label>
                    <flux:input.group>
                        <flux:input wire:model="time" id="time" name="time" placeholder="11:30" mask="99:99" value="11:56" required />
                        <flux:input.group.suffix>min</flux:input.group.suffix>
                    </flux:input.group>
                </flux:field>

                <flux:field wire:show="finishedWod === 'No'">
                    <flux:label>Repetitions done at the end of the workout</flux:label>
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
