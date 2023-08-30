@extends('layouts.app')
<title>ProveedoresDG</title>

<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<div style="background: #fff">
    @section('content')
    <link rel="stylesheet" href="{{ asset('assets/home.css') }}">

        <form method="GET" action="{{ route('ArticlesAll') }}">
            @csrf            <div class="head">
                <div class="filter-bar">
                    <div class="input-container">
                        <input name="input"class="input" id="filtro" type="text"
                            placeholder="Escriba SKU, categoría o modelo">
                        <button class="btns">Buscar</button>
                    </div>
                    <div class="input-container">
                        <input class="input" type="text" id="input" name="provider_id" list="providerList"
                            placeholder="Escriba nombre de proveedor">
                        <datalist name="provider_id" id="providerList">
                            @foreach ($providers as $provider)
                            <option value="{{ $provider->ClaveProv }}  " >{{$provider->NomProv}}
                            @endforeach
                        </datalist>
                        <button class="btns" type="submit"><i class="fa fa-filter fa-lg" aria-hidden="true"></i>Filtrar
                        </button>
                    </div>
                    <div class="input-container">
                        <a href="{{ route('ArticlesAll') }}" class="delfilter"><i class="fa fa-trash"
                                aria-hidden="true"></i> Limpiar filtros</a>
                    </div>
                    
                </div>
                <div class="input-container">
                    <a href="{{ route('exportToExcel') }}" class="btn btn-success">Exportar a Excel</a>
                </div>

            </div>
        </form>

        {{-- Fin Cabecera --}}
        {{-- Inicio Tabla --}}
        <table>
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
                    <th>ST</th>
                    <th>ENT</th>
                    <th>Ajustes</th>
                    <th>DEV</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody id="resultados">
                @foreach ($articles as $article)
                    @php
                        // Concatenar el SKU a la URL base de la imagen
                        $imageUrl = 'https://img.onlyclouddg.com/fotos/DG/' . $article->SKU . '/' . $article->SKU . '_1.jpg';
                        // dd($imageUrl);
                    @endphp
                    <tr>
                        <td><img class="img"src="{{ $imageUrl }}" alt=""></td>
                        <td>{{ $article->SKU }}</td>
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
                        <td>    
                            <form action="{{ route('detailWeek') }}" method="GET">
                                @csrf
                                <input type="hidden" name="sku" value="{{ $article->SKU }}">
                                <input type="hidden" name="modelo" value="{{ $article->Modelo }}">
                                <button class="buttonsub" type="submit"><i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i></button>
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
        <div id="filtro" class="pagin">
            {{ $articles->appends(request()->query())->links() }}
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


<script>
    // JavaScript para capturar la selección y establecer el valor de provider_id
    var inputElement = document.getElementById('input');
    var providerIdInput = document.getElementById('providerIdInput');
    var dataList = document.getElementById('providerList');

    inputElement.addEventListener('input', function() {
        var selectedOption = Array.from(dataList.options).find(function(option) {
            return option.value === inputElement.value;
        });

        if (selectedOption) {
            providerIdInput.value = selectedOption.getAttribute('data-claveprov');
        } else {
            providerIdInput.value = ''; // Limpiar el valor si no se selecciona ningún proveedor válido.
        }
    });
</script>