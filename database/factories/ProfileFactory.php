<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isRxDivision = fake()->boolean();
        $isScaledDivision = $isRxDivision ? false : fake()->boolean();
        $isMixedDivision = $isRxDivision || $isScaledDivision ? false : fake()->boolean();

        return [
            'birthday' => fake()->date(),
            'is_rx_division' => $isRxDivision,
            'is_scaled_division' => $isScaledDivision,
            'is_mixed_division' => $isMixedDivision,
            'can_do_pull_ups' => fake()->boolean(),
            'can_do_c2b_pull_ups' => fake()->boolean(),
            'can_do_t2b' => fake()->boolean(),
            'can_do_kipping_hspu' => fake()->boolean(),
            'can_do_strict_hspu' => fake()->boolean(),
            'can_do_wall_walks' => fake()->boolean(),
            'can_do_hs_walks' => fake()->boolean(),
            'can_do_bmu' => fake()->boolean(),
            'can_do_rmu' => fake()->boolean(),
            'can_do_dus' => fake()->boolean(),
            'can_handle_rx_db_weight' => fake()->boolean(),
            'can_handle_rx_wb_weight' => fake()->boolean(),
            'max_snatch' => fake()->numberBetween(20, 150),
            'max_clean' => fake()->numberBetween(20, 150),
            'max_deadlift' => fake()->numberBetween(20, 150),
            'notes' => fake()->sentence(),
        ];
    }
}
