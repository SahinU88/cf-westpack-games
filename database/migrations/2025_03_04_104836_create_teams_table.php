<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();

            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('team_id')->after('id')->nullable()->constrained();
        });

        // Seed the teams table
        DB::table('teams')->insert([
            ['name' => 'Bum Tschak', 'slug' => 'bum-tschak', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'The Weight Swifters', 'slug' => 'the-weight-swifters', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sashimi', 'slug' => 'sashimi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Westpack Unbroken', 'slug' => 'westpack-unbroken', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('team_id');
        });
    }
};
