@extends('layouts.app')
<title>ProveedoresDG</title>

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/icon.ico') }}">

</head>

<div style="background: #fff">
    @section('content')
        <link rel="stylesheet" href="{{ asset('assets/home.css') }}">

        <form method="GET" action="{{ route('ArticlesAll') }}">
            @csrf <div class="head">
                <div class="filter-bar">
                    <div class="input-container">
                        <input name="input"class="input" id="filtro" type="text"
                            placeholder="Escriba SKU, categoría o modelo">
                        <button class="btns">Buscar</button>
                    </div>
                    <div class="input-container">
                        @if (Auth::user()->provider_id === '0000')
                            <input class="input" type="text" id="input" name="provider_id" list="providerList"
                                placeholder="Escriba nombre de proveedor">
                            <datalist name="provider_id" id="providerList">
                                @foreach ($providers as $provider)
                                    <option value="{{ $provider->ClaveProv }}  ">{{ $provider->NomProv }}
                                @endforeach
                            </datalist>
                            <button class="btns" type="submit"><i class="fa fa-filter fa-lg"
                                    aria-hidden="true"></i>Filtrar
                            </button>
                        @else
                            <input type="hidden" name="provider_id" value="{{ Auth::user()->provider_id }}">
                        @endif
                    </div>
                    <div class="input-container">
                        <a href="{{ route('ArticlesAll') }}" class="delfilter"><i class="fa fa-trash"
                                aria-hidden="true"></i> Limpiar filtros</a>
                    </div>

                    <div class="input-container">
                        <a href="{{ route('exportToExcel', ['provider_id' => request('provider_id'), 'input' => request('input')]) }}"
                            class="btn btn-success">Exportar a Excel <i class="fa fa-table" aria-hidden="true"></i></a>

                    </div>
                </div>

            </div>
        </form>
        @if ($selectedProvider)
            <div class="provider_name">
                <p>{{ $selectedProvider->NomProv }}</p>
                <p style="font-weight: bold"> Pares totales: <font color="red"> {{ $totalRecords }} </font>
                </p>
            </div>
        @else
        @endif
        {{-- Fin Cabecera --}}
        {{-- Inicio Tabla --}}
        <table id="table" class="resultados">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>SKU</th>
                    <th>Modelo</th>
                    <th>Categoría</th>
                    <th>VTA</th>
                    <th>Costo</th>
                    <th>Inv.Inicial</th>
                    <th>Inv.Final</th>
                    <th>Rotación</th>
                    <th>Entradas</th>
                    <th>Ajustes</th>
                    <th>Devoluciones</th>
                    <th>Descuento</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody id="resultados">
                @foreach ($articles as $article)
                    @php
                        // Concatenar el SKU a la URL base de la imagen
                        $imageUrl = 'https://posdg.onlyclouddg.com/img/miniaturas/' .  $article->SKU . '.webp';
                        // dd($imageUrl);
                        // $image = @file_get_contents($imageUrl);
                    @endphp
                    <tr>
                        <td>
                            @if ($imageUrl !== false)
                                <img class="img"src="{{ $imageUrl }}" alt="">
                            @else
                                <i class="fa fa-picture-o fa-4x" style="color: #E0E0E0; padding:15px"
                                    aria-hidden="true"></i>
                            @endif
                        </td>
                        <td @if ($article->Descuento != 0) style="color: #FF0000; font-weight: bolder"   @endif>{{ $article->SKU }}</td>
                        <td>{{ $article->Modelo }}</td>
                        <td>{{ $article->Categoria }}</td>
                        <td>{{ $article->Ventas }}</td>
                        <td>${{ $article->Costo }}</td>
                        <td>{{ $article->InventarioI }}</td>
                        <td>{{ $article->InventarioF }}</td>
                        <td>{{ $article->ST }}%</td>
                        <td>{{ $article->Entradas }}</td>
                        <td>{{ $article->Ajustes }}</td>
                        <td>{{ $article->Devoluciones }}</td>
                        <td>{{ $article->Descuento }}%</td>
                        <td>
                            <form action="{{ route('detailWeek') }}" method="GET">
                                @csrf
                                <input type="hidden" name="sku" value="{{ $article->SKU }}">
                                <input type="hidden" name="modelo" value="{{ $article->Modelo }}">
                                <button class="buttonsub" type="submit"><i class="fa fa-file-text-o fa-2x"
                                        aria-hidden="true"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div id="no-results-message" style="display: none;">
            <div class="noresult" style="text-align: center">
                <i class="fa fa-exclamation-circle fa-5x" aria-hidden="true"></i>
                <h1>¡Sin resultados!</h1>
                <p>Por favor, ingrese correctamente la información. </p>
            </div>
        </div>
        {{-- <div id="filtro" class="pagin">
            {{ $articles->appends(request()->query())->links() }}
        </div> --}}

        <!-- Modal para mostrar la imagen más grande -->
        <div class="modal fade" id="imagenModal" tabindex="-1" role="dialog" aria-labelledby="imagenModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-body">
                    <img id="imagenAmpliada" class="img-fluid" src="" alt="Imagen Ampliada">
                </div>
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
{{-- No Result --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const resultados = document.getElementById("resultados"); // El elemento <tbody> de resultados
        const noResultsMessage = document.getElementById("no-results-message");

        // Verifica si hay resultados en la tabla
        const hayResultados = resultados.children.length > 0;

        if (!hayResultados) {
            noResultsMessage.style.display = "block";
        } else {
            noResultsMessage.style.display = "none";
        }
    });
</script>
@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var miTabla = new DataTable('#table', {
                paging: false,
                lengthChange: false,
                info: false,
                searching: false,
                
                columnDefs: [
                    { orderable: false, targets: [0, 13] } // Desactivar ordenación para la primera y última columna
                ]
            });
        });
    </script>
@endsection
