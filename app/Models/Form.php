<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Thing;

class Form extends Model
{
    protected $fillable = ['name', 'description'];

    public function things()
    {
        return $this->hasMany(Thing::class, 'form_id');
    }
}