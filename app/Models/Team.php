<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Team extends Model
{

    public function imageUrl(): Attribute
    {
        return new Attribute(
            get: function(){
                return asset('images/team-' . $this->slug . '.jpg');
            }
        );
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
