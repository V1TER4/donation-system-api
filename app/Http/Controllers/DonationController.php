<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\User;
use Validator;
use App\Models\FinancialInstitution;
use DB;

class DonationController extends Controller
{
    public function index(Request $request){
        $filters = $request->only(['user_id', 'institution_id', 'value', 'date']);
        $query = Donation::query();

        foreach ($filters as $key => $value) {
            if ($key == 'date') {
                $query->whereDate('created_at', $value);
            } else {
                $query->where($key, $value);
            }
        }

        $donations = $query->with('user', 'financial_institution')->get();

        return response()->json(['message' => 'Success', 'data'=> $donations, 'count' => $donations->count()], 200 );
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'institution_id' => 'required_without:financial_institution_code|exists:financial_institutions,id',
            'value' => 'required|numeric|min:5.00',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = $request->all();

        DB::beginTransaction();
        try {
            $user = User::findOrFail($data['user_id']);
            $financial_institution = FinancialInstitution::findOrFail($data['institution_id']);

            $existingDonation = Donation::where('user_id', $data['user_id'])
                                        ->where('institution_id', $data['institution_id'])
                                        ->first();
            if ($existingDonation) {
                DB::rollBack();
                return response()->json(['message' => 'Usuário já fez uma doação para esta instituição'], 400);
            }

            $donation = Donation::create($data);

            DB::commit();
            return response()->json(['data' => $donation, 'message' => 'Doação realizada com sucesso'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao realizar doação: ' . $e->getMessage());
            return response()->json(['message' => 'Erro ao realizar doação', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id){
        $donation = Donation::with('user', 'financial_institution')->find($id);

        if (!$donation) {
            return response()->json(['message' => 'Doação não encontrada'], 404);
        }

        return response()->json(['message' => 'Success', 'data'=> $donation], 200 );
    }
}
