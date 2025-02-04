<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();

            $table->date('birthday');
            $table->boolean('is_rx_division');
            $table->boolean('is_scaled_division');
            $table->boolean('is_mixed_division');

            $table->boolean('can_do_pull_ups');
            $table->boolean('can_do_c2b_pull_ups');
            $table->boolean('can_do_t2b');
            $table->boolean('can_do_kipping_hspu');
            $table->boolean('can_do_strict_hspu');
            $table->boolean('can_do_wall_walks');
            $table->boolean('can_do_hs_walks');
            $table->boolean('can_do_bmu');
            $table->boolean('can_do_rmu');
            $table->boolean('can_do_dus');

            $table->boolean('can_handle_rx_db_weight');
            $table->boolean('can_handle_rx_wb_weight');

            $table->unsignedSmallInteger('max_snatch');
            $table->unsignedSmallInteger('max_clean');
            $table->unsignedSmallInteger('max_deadlift');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }
};
