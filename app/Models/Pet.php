<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Type;
use App\Models\User;
use App\Models\PetPhoto;
use App\Models\Thing;

class Pet extends Model
{
    protected $fillable = [
        'type_id', 'breed', 'name', 'nickname', 
        'date_of_birth', 'date_of_adoption', 
        'is_alive', 'pet_avatar_url'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_adoption' => 'date',
        'is_alive' => 'boolean',
    ];

    // Связи
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'typeID');
    }

    public function owner()
    {
        return $this->belongsToMany(User::class, 'user_pets', 'pet_id', 'user_id')
                    ->withTimestamps();
    }

    public function photos()
    {
        return $this->hasMany(PetPhoto::class, 'pet_id', 'petID');
    }

    public function things()
    {
        return $this->belongsToMany(Thing::class, 'pet_things', 'pet_id', 'thing_id')
                    ->withTimestamps();
    }
}