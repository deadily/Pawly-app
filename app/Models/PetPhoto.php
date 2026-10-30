<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pet;

class PetPhoto extends Model
{
    protected $fillable = ['pet_id', 'photo_url'];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }
}