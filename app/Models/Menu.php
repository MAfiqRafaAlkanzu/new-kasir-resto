<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $guarded = ['id'];
    
    use HasFactory;

    public function menu() : HasMany
    {
        return $this->hasMany(Detail::class, 'menu_id', 'id');
    }
}
