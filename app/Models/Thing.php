<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thing extends Model
{
    protected $fillable = ['name', 'description', 'form_id', 'photo_url'];

    // Связи
    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function pets()
    {
        return $this->belongsToMany(Pet::class, 'pet_things', 'thing_id', 'pet_id')
                    ->withTimestamps();
    }
}