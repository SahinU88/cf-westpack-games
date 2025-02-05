<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $profile_birthday = '';
    public string $profile_division = '';
    public bool $profile_can_do_pull_ups = false;
    public bool $profile_can_do_c2b_pull_ups = false;
    public bool $profile_can_do_t2b = false;
    public bool $profile_can_do_kipping_hspu = false;
    public bool $profile_can_do_strict_hspu = false;
    public bool $profile_can_do_wall_walks = false;
    public bool $profile_can_do_hs_walks = false;
    public bool $profile_can_do_bmu = false;
    public bool $profile_can_do_rmu = false;
    public bool $profile_can_do_dus = false;
    public bool $profile_can_handle_rx_db_weight = false;
    public bool $profile_can_handle_rx_wb_weight = false;
    public int $profile_max_snatch = 0;
    public int $profile_max_clean = 0;
    public int $profile_max_deadlift = 0;
    public ?string $profile_notes = null;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],

            // add profile information validation
            'profile_birthday' => ['required', 'date'],
            'profile_division' => ['required', 'string'],
            'profile_can_do_pull_ups' => ['required', 'boolean'],
            'profile_can_do_c2b_pull_ups' => ['required', 'boolean'],
            'profile_can_do_t2b' => ['required', 'boolean'],
            'profile_can_do_kipping_hspu' => ['required', 'boolean'],
            'profile_can_do_strict_hspu' => ['required', 'boolean'],
            'profile_can_do_wall_walks' => ['required', 'boolean'],
            'profile_can_do_hs_walks' => ['required', 'boolean'],
            'profile_can_do_bmu' => ['required', 'boolean'],
            'profile_can_do_rmu' => ['required', 'boolean'],
            'profile_can_do_dus' => ['required', 'boolean'],
            'profile_can_handle_rx_db_weight' => ['required', 'boolean'],
            'profile_can_handle_rx_wb_weight' => ['required', 'boolean'],
            'profile_max_snatch' => ['required', 'numeric', 'min:1'],
            'profile_max_clean' => ['required', 'numeric', 'min:1'],
            'profile_max_deadlift' => ['required', 'numeric', 'min:1'],
            'profile_notes' => ['nullable', 'string'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $profile = [
            'birthday' => $validated['profile_birthday'],
            'is_rx_division' => $validated['profile_division'] === 'rx',
            'is_scaled_division' => $validated['profile_division'] === 'scaled',
            'is_mixed_division' => $validated['profile_division'] === 'mixed',
            'can_do_pull_ups' => $validated['profile_can_do_pull_ups'] ?? false,
            'can_do_c2b_pull_ups' => $validated['profile_can_do_c2b_pull_ups'] ?? false,
            'can_do_t2b' => $validated['profile_can_do_t2b'] ?? false,
            'can_do_kipping_hspu' => $validated['profile_can_do_kipping_hspu'] ?? false,
            'can_do_strict_hspu' => $validated['profile_can_do_strict_hspu'] ?? false,
            'can_do_wall_walks' => $validated['profile_can_do_wall_walks'] ?? false,
            'can_do_hs_walks' => $validated['profile_can_do_hs_walks'] ?? false,
            'can_do_bmu' => $validated['profile_can_do_bmu'] ?? false,
            'can_do_rmu' => $validated['profile_can_do_rmu'] ?? false,
            'can_do_dus' => $validated['profile_can_do_dus'] ?? false,
            'can_handle_rx_db_weight' => $validated['profile_can_handle_rx_db_weight'] ?? false,
            'can_handle_rx_wb_weight' => $validated['profile_can_handle_rx_wb_weight'] ?? false,
            'max_snatch' => $validated['profile_max_snatch'],
            'max_clean' => $validated['profile_max_clean'],
            'max_deadlift' => $validated['profile_max_deadlift'],
            'notes' => $validated['profile_notes'],
        ];

        $user->profile()->create($profile);

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-12">
            <div>
                <h2 class="text-white text-base/7 font-semibold">Konto</h2>
                <p class="mt-1 text-sm/6">Deine Anmeldedaten.</p>
            </div>
            <div class="col-span-2">
                <div class="space-y-6">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <div class="mt-2">
                            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text"
                                name="name" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <div class="mt-2">
                            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email"
                                name="email" required autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Passwort')" />

                        <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password"
                            name="password" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Passwort bestätigen')" />

                        <x-text-input wire:model="password_confirmation" id="password_confirmation"
                            class="block mt-1 w-full" type="password" name="password_confirmation" required
                            autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-12">
            <div>
                <h2 class="text-white text-base/7 font-semibold">Kategorie</h2>
                <p class="mt-1 text-sm/6">Lass uns wissen, wie erfahren du bist.</p>
            </div>
            <div class="col-span-2">
                <div class="grid grid-cols-1 gap-x-6 space-y-6">
                    <div>
                        <x-input-label for="profile_birthday" :value="__('Geburtstag')" />
                        <div class="mt-2 grid grid-cols-1">
                            <x-text-input wire:model="profile_birthday" id="profile_birthday" class="block mt-1 w-full"
                                type="date" name="profile_birthday" required />
                            <x-input-error :messages="$errors->get('profile_birthday')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="profile_division" :value="__('Workout Kategorie')" />
                        <div class="mt-2 grid grid-cols-1">
                            <select wire:model="profile_division" id="profile_division" name="profile_division"
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs"
                                required>
                                <option value="">Bitte wählen</option>
                                <option value="rx">RX</option>
                                <option value="scaled">Scaled</option>
                                <option value="mixed">Mixed (Rx/Scaled)</option>
                                <option value="null">Unsicher</option>
                            </select>
                            <x-input-error :messages="$errors->get('profile_division')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <div>
                <h2 class="text-white text-base/7 font-semibold">Skills</h2>
                <p class="mt-1 text-sm/6">Bei den folgenden Fragen kannst du ankreuzen, ob du die jeweiligen Fähigkeiten
                    beherrscht. <br> Es geht nicht darum, wie viele Wiederholungen du machen kannst, sondern nur, ob du es
                    kannst.</p>
            </div>
            <div class="col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
                    <div class="flex items-center gap-x-3">
                        <x-text-input wire:model="profile_can_do_pull_ups" id="profile_can_do_pull_ups"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 focus-visible:outline-2 focus-visible:outline-offset-2 "
                            type="checkbox" name="profile_can_do_pull_ups" />
                        <x-input-label for="profile_can_do_pull_ups" :value="__('Pull-Ups')"
                            class="block text-sm/6 font-medium" />
                        <x-input-error :messages="$errors->get('profile_can_do_pull_ups')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-x-3">
                        <x-text-input wire:model="profile_can_do_c2b_pull_ups" id="profile_can_do_c2b_pull_ups"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 focus-visible:outline-2 focus-visible:outline-offset-2 "
                            type="checkbox" name="profile_can_do_c2b_pull_ups" />
                        <x-input-label for="profile_can_do_c2b_pull_ups" :value="__('Chest-To-Bar-Pull-Ups')"
                            class="block text-sm/6 font-medium" />
                        <x-input-error :messages="$errors->get('profile_can_do_c2b_pull_ups')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-x-3">
                        <x-text-input wire:model="profile_can_do_t2b" id="profile_can_do_t2b"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 focus-visible:outline-2 focus-visible:outline-offset-2 "
                            type="checkbox" name="profile_can_do_t2b" />
                        <x-input-label for="profile_can_do_t2b" :value="__('Toes-To-Bar')"
                            class="block text-sm/6 font-medium" />
                        <x-input-error :messages="$errors->get('profile_can_do_t2b')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-x-3">
                        <x-text-input wire:model="profile_can_do_kipping_hspu" id="profile_can_do_kipping_hspu"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 focus-visible:outline-2 focus-visible:outline-offset-2 "
                            type="checkbox" name="profile_can_do_kipping_hspu" />
                        <x-input-label for="profile_can_do_kipping_hspu" :value="__('Kipping Handstand Push-Ups')"
                            class="block text-sm/6 font-medium" />
                        <x-input-error :messages="$errors->get('profile_can_do_kipping_hspu')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-x-3">
                        <x-text-input wire:model="profile_can_do_strict_hspu" id="profile_can_do_strict_hspu"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 focus-visible:outline-2 focus-visible:outline-offset-2 "
                            type="checkbox" name="profile_can_do_strict_hspu" />
                        <x-input-label for="profile_can_do_strict_hspu" :value="__('Strict Handstand Push-Ups')"
                            class="block text-sm/6 font-medium" />
                        <x-input-error :messages="$errors->get('profile_can_do_strict_hspu')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-x-3">
                        <x-text-input wire:model="profile_can_do_wall_walks" id="profile_can_do_wall_walks"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 focus-visible:outline-2 focus-visible:outline-offset-2 "
                            type="checkbox" name="profile_can_do_wall_walks" />
                        <x-input-label for="profile_can_do_wall_walks" :value="__('Wall Walks')"
                            class="block text-sm/6 font-medium" />
                        <x-input-error :messages="$errors->get('profile_can_do_wall_walks')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-x-3">
                        <x-text-input wire:model="profile_can_do_hs_walks" id="profile_can_do_hs_walks"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 focus-visible:outline-2 focus-visible:outline-offset-2 "
                            type="checkbox" name="profile_can_do_hs_walks" />
                        <x-input-label for="profile_can_do_hs_walks" :value="__('Handstand Walks')"
                            class="block text-sm/6 font-medium" />
                        <x-input-error :messages="$errors->get('profile_can_do_hs_walks')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-x-3">
                        <x-text-input wire:model="profile_can_do_bmu" id="profile_can_do_bmu"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 focus-visible:outline-2 focus-visible:outline-offset-2 "
                            type="checkbox" name="profile_can_do_bmu" />
                        <x-input-label for="profile_can_do_bmu" :value="__('Bar Muscle-Ups')"
                            class="block text-sm/6 font-medium" />
                        <x-input-error :messages="$errors->get('profile_can_do_bmu')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-x-3">
                        <x-text-input wire:model="profile_can_do_rmu" id="profile_can_do_rmu"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 focus-visible:outline-2 focus-visible:outline-offset-2 "
                            type="checkbox" name="profile_can_do_rmu" />
                        <x-input-label for="profile_can_do_rmu" :value="__('Ring Muscle-Ups')"
                            class="block text-sm/6 font-medium" />
                        <x-input-error :messages="$errors->get('profile_can_do_rmu')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-x-3">
                        <x-text-input wire:model="profile_can_do_dus" id="profile_can_do_dus"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 focus-visible:outline-2 focus-visible:outline-offset-2 "
                            type="checkbox" name="profile_can_do_dus" />
                        <x-input-label for="profile_can_do_dus" :value="__('Double-Unders')"
                            class="block text-sm/6 font-medium" />
                        <x-input-error :messages="$errors->get('profile_can_do_dus')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <div>
                <h2 class="text-white text-base/7 font-semibold">Benchmarks</h2>
                <p class="mt-1 text-sm/6">Ein Hinweis auf dein Kraftniveau.</p>
            </div>
            <div class="col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 space-y-6">
                    <div class="flex items-center gap-x-3">
                        <x-text-input wire:model="profile_can_handle_rx_db_weight"
                            id="profile_can_handle_rx_db_weight"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 focus-visible:outline-2 focus-visible:outline-offset-2 "
                            type="checkbox" name="profile_can_handle_rx_db_weight" />
                        <x-input-label for="profile_can_handle_rx_db_weight" :value="__('2x 22,5/15KG Dumbbells')"
                            class="block text-sm/6 font-medium" />
                        <x-input-error :messages="$errors->get('profile_can_handle_rx_db_weight')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-x-3">
                        <x-text-input wire:model="profile_can_handle_rx_wb_weight"
                            id="profile_can_handle_rx_wb_weight"
                            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 focus-visible:outline-2 focus-visible:outline-offset-2 "
                            type="checkbox" name="profile_can_handle_rx_wb_weight" />
                        <x-input-label for="profile_can_handle_rx_wb_weight" :value="__('9/6KG Wall Balls')"
                            class="block text-sm/6 font-medium" />
                        <x-input-error :messages="$errors->get('profile_can_handle_rx_wb_weight')" class="mt-2" />
                    </div>

                    <div class="col-span-2">
                        <x-input-label for="profile_max_snatch" :value="__('Max Snatch')" />
                        <div class="mt-2">
                            <x-text-input wire:model="profile_max_snatch" id="profile_max_snatch"
                                class="block mt-1 w-full" type="number" min="1" name="profile_max_snatch"
                                required />
                            <x-input-error :messages="$errors->get('profile_max_snatch')" class="mt-2" />
                        </div>
                    </div>

                    <div class="col-span-2">
                        <x-input-label for="profile_max_clean" :value="__('Max Clean')" />
                        <div class="mt-2">
                            <x-text-input wire:model="profile_max_clean" id="profile_max_clean"
                                class="block mt-1 w-full" type="number" min="1" name="profile_max_clean"
                                required />
                            <x-input-error :messages="$errors->get('profile_max_clean')" class="mt-2" />
                        </div>
                    </div>

                    <div class="col-span-2">
                        <x-input-label for="profile_max_deadlift" :value="__('Max Deadlift')" />
                        <div class="mt-2">
                            <x-text-input wire:model="profile_max_deadlift" id="profile_max_deadlift"
                                class="block mt-1 w-full" type="number" min="1" name="profile_max_deadlift"
                                required />
                            <x-input-error :messages="$errors->get('profile_max_deadlift')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <div>
                <h2 class="text-white text-base/7 font-semibold">Anmerkung</h2>
                <p class="mt-1 text-sm/6">Gibt es etwas, das wir wissen sollten?</p>
            </div>
            <div class="col-span-2">
                <div>
                    <x-input-label for="profile_notes" :value="__('Lass es uns wissen')" />
                    <div class="mt-2">
                        <textarea name="profile_notes" id="profile_notes" rows="3"
                            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs"></textarea>
                        <x-input-error :messages="$errors->get('profile_notes')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            {{-- <a class="underline text-sm dark:text-gray-400 hover dark:hover:text-gray-100 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a> --}}

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
