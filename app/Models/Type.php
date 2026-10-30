<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pet;

class Type extends Model
{
    protected $fillable = ['name'];

    public function pets()
    {
        return $this->hasMany(Pet::class, 'type_id');
    }
}