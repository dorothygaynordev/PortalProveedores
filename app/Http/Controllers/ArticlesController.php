<?php

namespace App\Http\Controllers;

use App\Models\ProvidersModel;
use App\Models\ArticlesModel;
use App\Models\InventoryModel;
use Illuminate\Http\Request;
use App\Exports\ArticlesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{
    public function index(Request $request)
    { // Obtener el usuario autenticado
        $user = Auth::user();
        $provider_id = $user->provider_id;
        $providers = ProvidersModel::all();
        $articlesProvider = ArticlesModel::query();

        // Verificar si se ha proporcionado un filtro por propiedad de artículo
        $filterSKU = $request->input('input');

        if ($filterSKU) {
            $articlesProvider->where(function ($query) use ($filterSKU) {
                $query->where('SKU', 'LIKE', '%' . $filterSKU . '%')
                    ->orWhere('Modelo', 'LIKE', '%' . $filterSKU . '%')
                    ->orWhere('Categoria', 'LIKE', '%' . $filterSKU . '%');
            });
        }
        // Verificar si se ha proporcionado el filtro de proveedor
        $filterProvider = $request->input('provider_id');

        if ($filterProvider) {
            $articlesProvider->where('SKU', 'LIKE', 'D' . $filterProvider . '%');
        }
        if ($provider_id === '0000') {
            $articles = $articlesProvider
            // ->orderBy('ventas','desc')
            ->paginate(5);
        } else {
            // Si el provider_id no es "0000", solo se permite filtrar por SKU
            $articles = $articlesProvider->where('SKU', 'LIKE', 'D' . $provider_id . '%')
            ->orderBy('ventas','desc') //Ordenamiento por defecto de ventas
            ->paginate(5);
        } 

        return view('home', compact('articles', 'providers'));
    }





    public function exportToExcel(Request $request)
    {
        $user = Auth::user();
        $provider_id = $user->provider_id;
        $filterSKU = $request->input('input');
        $articlesProvider = ArticlesModel::query();

        if ($filterSKU) {
            $articlesProvider->where(function ($query) use ($filterSKU) {
                $query->where('SKU', 'LIKE', '%' . $filterSKU . '%')
                    ->orWhere('Modelo', 'LIKE', '%' . $filterSKU . '%')
                    ->orWhere('Categoria', 'LIKE', '%' . $filterSKU . '%');
            });
        }
        // Verificar si se ha proporcionado un filtro de proveedor
        $filterProvider = $request->input('provider_id');
        if ($filterProvider) {
            $articlesProvider->where('SKU', 'LIKE', 'D' . $filterProvider . '%');
        }

        // Verificar si el provider_id es igual a "0000"
        if ($provider_id === '0000') {
        } else {
            // Si el provider_id no es "0000", filtramos por el proveedor correspondiente
            $articlesProvider->where('SKU', 'LIKE', 'D' . $provider_id . '%');
        }

        // Obtener todos los registros sin paginación
        $articles = $articlesProvider->get();

        // Exportar los datos a Excel
        return Excel::download(new ArticlesExport($articles), 'articles.xlsx');
    }
}
