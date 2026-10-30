<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Article;
use App\Models\Pet;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pet> $pets
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany pets()
 */

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'userID';

    protected $fillable = [
        'name', 
        'email', 
        'password_hash', 
        'role_id'
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    public function pets()
    {
        return $this->belongsToMany(
            Pet::class,       // Связанная модель
            'user_pets',      // Промежуточная таблица
            'user_id',        // Внешний ключ в промежуточной таблице,指向 текущую модель (User)
            'pet_id',         // Внешний ключ в промежуточной таблице,指向 связанную модель (Pet)
            'userID',         // !!! ЛОКАЛЬНЫЙ КЛЮЧ В ТАБЛИЦЕ users (вместо дефолтного 'id')
            'petID'           // !!! РОДСТВЕННЫЙ КЛЮЧ В ТАБЛИЦЕ pets (вместо дефолтного 'id')
        )->withTimestamps();
    }
}