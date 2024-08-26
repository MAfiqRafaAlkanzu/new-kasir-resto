<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function seat(): HasMany
    {
        return $this->hasMany(Transaction::class, 'seat_id', 'id');
    }
}
