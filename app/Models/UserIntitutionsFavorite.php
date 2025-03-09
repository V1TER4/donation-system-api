<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserIntitutionsFavorite extends Model
{
    //
    protected $fillable = [
        'user_id', 'institution_id'
    ];

    public function financial_institution(){
        return $this->belongsTo(FinancialInstitution::class, 'institution_id');
    }
}
