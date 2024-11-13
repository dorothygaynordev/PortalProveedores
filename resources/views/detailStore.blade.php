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
        <div class="modal-content">
            <p class="title">Informacion por Tiendas <i class="fa fa-shopping-cart" style="padding:5px"
                    aria-hidden="true"></i></p>
            @foreach ($tienda->unique() as $store)
                @php
                    // Concatenar el SKU a la URL base de la imagen
                    $imageUrl = 'https://posdg.onlyclouddg.com/img/miniaturas/' . $store->SKU . '.webp';
                    // dd($imageUrl);
                    // $image = @getimagesize($imageUrl);
                @endphp
                <div class="modalinfo">
                    <div class="imgcontent">
                        @if ($imageUrl !== false)
                            <img class="img"src="{{ $imageUrl }}" alt="">
                        @else
                            <i class="fa fa-picture-o fa-4x" style="color: #E0E0E0; padding:15px" aria-hidden="true"></i>
                        @endif
                    </div>
                    <div>
                        <h1>{{ $store->SKU }}</h1>
                        <p>{{ $store->Modelo }}</p>
                    </div>
                </div>
            @endforeach

            <div class="modal-tab">
                <table id="tienda">
                    <thead>
                        <tr>
                            <th>Centro</th>
                            <th>Nombre Tienda</th>
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
                                    <td>{{ $store->CenterName }}</td>
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
</div>
@section('js')

    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (!$tienda->isEmpty())
                var miTabla = new DataTable('#tienda', {
                    paging: false,
                    lengthChange: false,
                    info: false,
                    searching: false,
                    language: {
                        search: "Buscar por tienda:"
                    }
                });
            @endif
        });
    </script>
@endsection
@endsection
