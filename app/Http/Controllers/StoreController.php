<?php

namespace App\Http\Controllers;
use App\Models\StoreModel;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request){
        $sku = $request->input('sku');
        $semana = $request->input('semana');
        // $limit = 10;
        $tienda=StoreModel::where('sku',$sku)
        ->orderBy('ventas','desc')
        ->where('semana',$semana)
        ->get();
        // dd($inventario);
        return view('detailStore', ['tienda' => $tienda]);
    }
}
