@extends('layouts.app')
<title>ProveedoresDG</title>

<div>
    @section('content')
        @vite(['resources/css/home.css'])
        <div>
            <div class="return">
                <a  href="javascript:history.back();">
                    <i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i><label for="">Regresar</label>
                </a>
                
            </div>
            <div>
                <h1 class="info">Información por periodo</h1>
            </div>

        </div>
        
        @foreach ($inventario as $inv)
        @php
                // Concatenar el SKU a la URL base de la imagen
                $imageUrl = 'https://img.onlyclouddg.com/fotos/DG/' . $inv->SKU . '/' . $inv->SKU . '_1.jpg';
                // dd($imageUrl);
                @endphp
        @endforeach
        <div class="modal-content">
            
            <div class="modalinfo">
                <div class="imgcontent">

                    <img class="img" src="{{ $imageUrl }}" alt="">
                </div>
                <div>
                    <h1>{{ $inv->SKU }}</h1> <br>
                    <p>{{ $inv->Modelo }}</p>
                </div>
            </div>
            <div class="modal-tab">

                <table>
                    <thead>
                        <tr>
                            <th>Semana</th>
                            <th>VTA</th>
                            <th>Inv.Inicial</th>
                            <th>Inv.Final</th>
                            <th>ST</th>
                            <th>Ajustes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventario as $inv)
                            <tr>
                                <td>
                                    <form action="{{ route('detailStore') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="sku" value="{{ $inv->SKU }}">
                                        <input type="hidden" name="semana" value="{{ $inv->Semana }}">
                                        <button class="buttonsub" type="submit" style="text-decoration:underline">{{ $inv->Semana }}</button>
                                    </form>
                                </td>
                                <td>{{ $inv->Ventas }}</td>
                                <td>{{ $inv->InventarioI }}</td>
                                <td>{{ $inv->InventarioF }}</td>
                                <td>{{ $inv->ST }}%</td>
                                <td>{{ $inv->Ajustes }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    @endsection
</div>
