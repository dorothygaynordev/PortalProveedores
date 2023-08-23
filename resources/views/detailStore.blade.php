@extends('layouts.app')
<title>ProveedoresDG</title>

<div>
    @section('content')
        @vite(['resources/css/home.css'])
        <div>
            <div  class="return">
                <a   href="javascript:history.back();">
                    <i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i><label for="">Regresar</label>
                </a>
                
            </div>
            <div>
                <h1 class="info">Información por Tienda</h1>
            </div>

        </div>
        <div class="modal-content">
        
                @foreach ($tienda->unique() as $store)
                    @php
                        // Concatenar el SKU a la URL base de la imagen
                        $imageUrl = 'https://img.onlyclouddg.com/fotos/DG/' . $store->SKU . '/' . $store->SKU . '_1.jpg';
                        // dd($imageUrl);
                    @endphp
                    <div class="modalinfo">
                        <div class="imgcontent">

                            <img class="img" src="{{ $imageUrl }}" alt="">
                        </div>
                        <div>
                            <h1>{{ $store->SKU }}</h1> <br>
                            <p>{{ $store->Modelo }}</p>
                        </div>
                    </div>
                @endforeach
        
            <div class="modal-tab">
                <table>
                    <thead>
                        <tr>
                            <th>Centro</th>
                            <th>VTA</th>
                            <th>Inv.Inicial</th>
                            <th>Inv.Final</th>
                            <th>Ajustes</th>
                            <th>ST</th>
                        </tr>
                    </thead>
                    @if ($tienda->isEmpty())
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <div class="errore">
                                        <i class="fa fa-exclamation-triangle fa-3x" aria-hidden="true"></i>
                                        <h1>Lo sentimos :(</h1>
                                        <p>No hay información para mostrar</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($tienda as $store)
                                <tr>
                                    <td>{{ $store->CenterId }}</td>
                                    <td>{{ $store->Ventas }}</td>
                                    <td>{{ $store->InventarioI }}</td>
                                    <td>{{ $store->InventarioF }}</td>
                                    <td>{{ $store->Ajustes }}</td>
                                    <td>{{ $store->ST }}%</td>
                                </tr>
                            @endforeach
                    @endif
                    </tbody>

                </table>
            </div>
        </div>
    @endsection
</div>
