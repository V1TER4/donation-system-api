<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialInstitution;

class InstitutionController extends Controller
{
    public function list(){
        return response()->json(['message' => 'Success', 'data'=> FinancialInstitution::all()], 200 );
    }
}
