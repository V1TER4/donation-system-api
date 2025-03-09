<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserIntitutionsFavorite;
use Validator;

class UserFavoriteController extends Controller
{
    public function find($id)
    {
        $favorite = UserIntitutionsFavorite::with('financial_institution')->where('user_id', $id)->first();
        return response()->json(['message' => 'Success', 'data' => $favorite], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'institution_id' => 'required|exists:financial_institutions,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $data = $request->all();

        if (UserIntitutionsFavorite::where('user_id', $data['user_id'])->exists()) {
            return response()->json(['message' => 'Já existe um favorito cadastrado'], 400);
        }
        $favorite = UserIntitutionsFavorite::create($data);
        return response()->json(['message' => 'Instituição favoritada com sucesso', 'data' => $favorite], 201);
    }

    public function destroy($id)
    {
        $favorite = UserIntitutionsFavorite::where('user_id', $id)->first();
        if (!$favorite) {
            return response()->json(['message' => 'Não existe favorito cadastrado'], 404);
        }
        $favorite->delete();
        return response()->json(['message' => 'Favorito deletado'], 200);
    }

    public function update(Request $request, $id)
    {
        $favorite = UserIntitutionsFavorite::where('user_id', $id)->first();
        if (!$favorite) {
            return response()->json(['message' => 'Não existe favorito cadastrado'], 404);
        }
        $favorite->update(['institution_id' => $request->institution_id]);
        return response()->json(['message' => 'Instituição favoritada atualizada com sucesso', 'data' => $favorite], 200);
    }
}
