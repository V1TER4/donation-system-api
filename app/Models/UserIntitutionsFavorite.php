<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserIntitutionsFavorite extends Model
{
    //
    protected $fillable = [
        'user_id', 'institution_id'
    ];
}
