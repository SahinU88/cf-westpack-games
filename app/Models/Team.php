<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory;

    public function imageUrl(): Attribute
    {
        return new Attribute(
            get: function(){
                return asset('images/team-' . $this->slug . '.jpg');
            }
        );
    }

    public function scoresOpenWod251(): Attribute
    {
        return new Attribute(
            get: function(){
                return Score::with(['user', 'user.team'])
                    ->rankingOpenWod251()
                    ->get()
                    ->whereStrict('user.team.id', $this->id);
            }
        );
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
