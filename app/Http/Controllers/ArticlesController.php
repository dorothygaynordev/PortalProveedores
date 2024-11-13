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
        $totalRecords = 0;
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
        $selectedProvider = $providers->firstWhere('ClaveProv', $filterProvider);

        if ($filterProvider) {
            $articlesProvider->where('SKU', 'LIKE', 'D' . $filterProvider . '%');
            $totalRecords = $articlesProvider->count();
        }
        // Obtener los parámetros de ordenamiento de la solicitud
        $orderBy = $request->input('orderBy','ST'); // Columna de ordenamiento predeterminada
        $orderDirection = $request->input('orderDirection', 'desc'); // Dirección de ordenamiento predeterminada

        // Verificar si las columnas permitidas son las que se están ordenando
        $allowedColumns = ['ventas', 'InventarioI', 'InventarioF', 'ST'];
        if (!in_array($orderBy, $allowedColumns)) {
            $orderBy = 'ST'; // Columna de ordenamiento predeterminada si la columna no está permitida
        }

        // Aplicar el ordenamiento a la consulta
        $articlesProvider->orderBy($orderBy, $orderDirection);
        if ($provider_id === '0000') {
            $articles = $articlesProvider
                // ->orderBy('ventas','desc')
                ->get();
        } else {
            // Si el provider_id no es "0000", solo se permite filtrar por SKU
            $articles = $articlesProvider->where('SKU', 'LIKE', 'D' . $provider_id . '%')
                // ->orderBy('ventas', 'desc') //Ordenamiento por defecto de ventas
                ->get();
        }


        return view('home', compact('articles', 'providers','selectedProvider','totalRecords'));
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
