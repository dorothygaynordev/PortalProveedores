<?php

namespace App\Http\Controllers;
use App\Models\ProvidersModel;
use App\Models\ArticlesModel;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index(Request $request)//Agregar variable $provider_id dentro del parentesis para filtrar articulos por proveedor
    {
        $providers = ProvidersModel::all();
        $articlesProvider= ArticlesModel::query();
        $provider_id = $request->input('provider_id');
        $filterSKU  = $request->input('input');

        if ($provider_id){
            $articlesProvider->where('SKU','LIKE','D'.$provider_id.'%');
        }
        if ($filterSKU) {
            $articlesProvider->where(function ($query) use ($filterSKU) {
                $query->where('SKU', 'LIKE', '%' . $filterSKU . '%')
                      ->orWhere('Modelo', 'LIKE', '%' . $filterSKU . '%')
                      ->orWhere('Categoria', 'LIKE', '%' . $filterSKU . '%');
            });
        }
        // $articles = ArticlesModel::where('SKU','LIKE','D'.$provider_id.'%')->paginate(5); // Obtener todos los registros de la tabla asociada al Modelo
        $articles = $articlesProvider->paginate(5); // Obtener todos los registros de la tabla asociada al Modelo
        return view('home',compact('articles','providers'));
    }

    public function details($sku){
        $article = ArticlesModel::where('SKU',$sku)->first();
        $descripcion = $article->descripcion;

        return view('home',['article' => $article, 'descripcion' => $descripcion]);
    }

    
}