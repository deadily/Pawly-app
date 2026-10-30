<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetThing extends Model
{
    protected $table = 'pet_things';
    protected $fillable = ['pet_id', 'thing_id'];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function thing()
    {
        return $this->belongsTo(Thing::class);
    }
}