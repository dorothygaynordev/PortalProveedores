<?php

namespace App\Http\Controllers;
use App\Models\ProvidersModel;
use Illuminate\Http\Request;

class ProvidersController extends Controller
{
    public function index()
    {
        $providers = ProvidersModel::all(); // Obtener todos los registros de la tabla asociada al Modelo

        return view('auth.register',compact('providers'));
    }
}

