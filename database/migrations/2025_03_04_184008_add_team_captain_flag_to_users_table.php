<?php

use App\Models\User;
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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_team_captain')->default(false);
        });

        User::query()
            ->where('email', 'sahin.ucar.su@gmail.com')
            ->orWhere('email', 'katharina.maehr@gmx.at')
            ->orWhere('email', 'michel.haug@hotmail.com')
            ->orWhere('email', 'ritterjessica11@gmail.com')
            ->update(['is_team_captain' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_team_captain');
        });
    }
};
