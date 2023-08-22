<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticlesModel;

class SearchController extends Controller
{
    public function buscar(Request $request)
    {
        $keyword = $request->input('q');

        $query = ArticlesModel::query();

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('SKU', 'like', '%' . $keyword . '%')
                    ->orWhere('Modelo', 'like', '%' . $keyword . '%')
                    ->orWhere('Venta', 'like', '%' . $keyword . '%')
                    ->orWhere('Genero', 'like', '%' . $keyword . '%')
                    ->orWhere('Categoria', 'like', '%' . $keyword . '%')
                    ->orWhere('Ult_Entrada', 'like', '%' . $keyword . '%');
            });
        }

        $articles = $query->get();

        return response()->json($articles);
    }
}
