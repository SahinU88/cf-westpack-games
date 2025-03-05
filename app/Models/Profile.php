<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory;

    public function division(): Attribute
    {
        return new Attribute(
            get: function () {
                if ($this->is_rx_division){
                    return 'rx';
                }

                if ($this->is_scaled_division){
                    return 'scaled';
                }

                if ($this->is_mixed_division){
                    return 'mixed';
                }

                return 'n.a.';
            }
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
