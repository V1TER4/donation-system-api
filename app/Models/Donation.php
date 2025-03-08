<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    //
    protected $fillable = [
        'user_id', 'institution_id', 'value'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function financial_institution()
    {
        return $this->belongsTo(FinancialInstitution::class, 'institution_id');
    }
}
