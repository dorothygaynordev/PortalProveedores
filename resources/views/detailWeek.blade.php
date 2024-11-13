@extends('layouts.app')
<title>ProveedoresDG</title>

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

<head>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/icon.ico') }}">
</head>
<div>
    @section('content')
        <link rel="stylesheet" href="{{ asset('assets/home.css') }}">
        <div class="return">
            <a href="javascript:history.back();">
                <i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i><label for="">Regresar</label>

            </a>

        </div>

        @foreach ($inventario as $inv)
            @php
                // Concatenar el SKU a la URL base de la imagen
                $imageUrl = 'https://img.onlyclouddg.com/fotos/DG/' . $inv->SKU . '/' . $inv->SKU . '_1.jpg';
                // dd($imageUrl);
                // $image = @getimagesize($imageUrl);
            @endphp
        @endforeach
        <div class="modal-content">
            <p class="title">Informacion por periodo (Mensual) <i class="fa fa-calendar-check-o" style="padding:5px"
                    aria-hidden="true"></i></p>
            <div class="modalinfo">
                <div class="imgcontent">
                    @if ($imageUrl !== false)
                    <img class="img"src="{{ $imageUrl }}" alt="">
                @else
                    <i class="fa fa-picture-o fa-4x" style="color: #E0E0E0; padding:15px"
                        aria-hidden="true"></i>
                @endif
                </div>
                <div class="inf">
                    <h1 >{{ $inv->SKU }}</h1>
                    <p >{{ $inv->Modelo }}</p>
                </div>
            </div>
            <div class="modal-tab">

                <table id="table">
                    <thead>
                        <tr>
                            <th name="semana">Mes</th>
                            <th>VTA</th>
                            <th>Inv.Inicial</th>
                            <th>Inv.Final</th>
                            <th>ST</th>
                            <th>Entradas</th>
                            <th>Ajustes</th>
                            <th>Ver Más</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventario as $inv)
                            <tr>
                                <td> {{ $inv->Semana }}</td>
                                <td>{{ $inv->Ventas }}</td>
                                <td>{{ $inv->InventarioI }}</td>
                                <td>{{ $inv->InventarioF }}</td>
                                <td>{{ $inv->ST }}%</td>
                                <td>{{$inv->Entradas}}</td>
                                <td>{{ $inv->Ajustes }}</td>
                                <td>
                                    <form action="{{ route('detailStore') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="sku" value="{{ $inv->SKU }}">
                                        <input type="hidden" name="semana" value="{{ $inv->Semana }}">
                                        <button class="buttonsub" type="submit"><i class="fa fa-info-circle fa-lg"
                                                style="margin-top: 19px" aria-hidden="true"></i></button>

                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

        </div>
        <!-- Modal para mostrar la imagen más grande -->
        <div class="modal fade" id="imagenModal" tabindex="-1" role="dialog" aria-labelledby="imagenModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-body">
                    <img id="imagenAmpliada" class="img-fluid" src="" alt="Imagen Ampliada">
                </div>
            </div>
        </div>
    @endsection

    {{-- Modal Foto --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Script para manejar el evento de clic en la imagen y mostrarla en el modal
        $(document).ready(function() {
            $('.img').click(function() {
                const imageUrl = $(this).attr('src');
                $('#imagenAmpliada').attr('src', imageUrl);
                $('#imagenModal').modal('show');
            });
        });
    </script>
</div>
@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var miTabla = new DataTable('#table', {
                searching: false,
                paging: false,
                lenghtChange: false,
                info: false,
                order: [
                    [0, ''],
                    [1, ''],
                    [2, ''],
                    [3, ''],
                    [4, '']
                ], // Ordena todas las columnas en orden ascendente
                columnDefs: [{
                    targets: [
                    0,6], // Reemplaza 'columnNameToDisableSorting' con el nombre de la columna que deseas desactivar el ordenamiento
                    orderable: false // Desactiva el ordenamiento para la columna especificada
                }]

            });
        });
    </script>
@endsection
