<?php

namespace App\Http\Controllers;
use App\Models\InventoryModel;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request){
        $sku = $request->input('sku');
        // $limit = 10;
        $inventario=InventoryModel::where('sku',$sku)
        ->orderBy('semana','desc')
        ->get();
        // dd($inventario);
        return view('detailWeek', ['inventario' => $inventario]);
    }
}
