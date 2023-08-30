<?php

namespace App\Http\Controllers;

use App\Models\ProvidersModel;
use App\Models\ArticlesModel;
use App\Models\InventoryModel;
use Illuminate\Http\Request;
use App\Exports\ArticlesExport;
use Maatwebsite\Excel\Facades\Excel;

class ArticlesController extends Controller
{
    public function index(Request $request) //Agregar variable $provider_id dentro del parentesis para filtrar articulos por proveedor
    {
        $providers = ProvidersModel::all();
        $articlesProvider = ArticlesModel::query();
        $provider_id = $request->input('provider_id');
        $filterSKU  = $request->input('input');

        if ($provider_id) {
            $articlesProvider->where('SKU', 'LIKE', 'D' . $provider_id . '%');
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
        return view('home', compact('articles', 'providers'));
    }

    public function details($sku)
    {
        $article = ArticlesModel::where('SKU', $sku)->first();
        $descripcion = $article->descripcion;

        $inventario = InventoryModel::where('SKU', $sku)->first();

        return view('home', ['article' => $article, 'descripcion' => $descripcion]);
    }



    public function exportToExcel(Request $request)
    {
        $providers = ProvidersModel::all();
        $articlesProvider = ArticlesModel::query();
        $provider_id = $request->input('provider_id');
        $filterSKU = $request->input('input');


    // dd($provider_id,$filterSKU);
        if ($provider_id) {
            $articlesProvider->where('SKU', 'LIKE', 'D' . $provider_id . '%');
        }
        if ($filterSKU) {
            $articlesProvider->where(function ($query) use ($filterSKU) {
                $query->where('SKU', 'LIKE', '%' . $filterSKU . '%')
                    ->orWhere('Modelo', 'LIKE', '%' . $filterSKU . '%')
                    ->orWhere('Categoria', 'LIKE', '%' . $filterSKU . '%');
            });
        }

        // Obtener todos los registros sin paginación
        $articles = $articlesProvider->get();

        // Exportar los datos a Excel
        return Excel::download(new ArticlesExport($articles), 'articles.xlsx');
    }
}
