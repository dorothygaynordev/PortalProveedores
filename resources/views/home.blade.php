@extends('layouts.app')
<title>ProveedoresDG</title>

<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<div style="background: #fff">
    @section('content')
        @vite(['resources/css/home.css'])

        <form method="GET" action="{{ route('ArticlesAll') }}">
            <div class="head">
                <div class="filter-bar">
                    <div class="input-container">
                        <input name="input"class="input" id="filtro" type="text"
                            placeholder="Escriba SKU o característica">
                        <button class="btns">Buscar</button>
                    </div>
                    <div class="input-container">
                        <input class="input" type="text" id="input" name="provider_id" list="providerList"
                            placeholder="Escriba nombre de proveedor">
                        <datalist name="provider_id" id="providerList">
                            @foreach ($providers as $provider)
                                <option type="submit" class="inputlist" value="{{ $provider->ClaveProv }}">{{$provider->NomProv}}
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

            </div>
        </form>
        {{-- Fin Cabecera --}}
        {{-- Inicio Tabla --}}
        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>SKU</th>
                    <th>Color</th>
                    <th>Modelo</th>
                    <th>Categoría</th>
                    <th>VTA</th>
                    <th>Costo</th>
                    <th>Inv. Inicial</th>
                    <th>Inv.Final</th>
                    <th>TOS</th>
                    <th>ENT</th>
                    <th>PEN</th>
                    <th>DEV</th>
                    <th>Ult. Ent</th>
                    <th>Existencia Tiendas</th>
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
                        <td>546-LATTE</td>
                        <td>{{ $article->Modelo }}</td>
                        <td>{{ $article->Categoria }}</td>
                        <td>{{ $article->Ventas }}</td>
                        <td>$299.99</td>
                        <td>{{ $article->InventarioI }}</td>
                        <td>{{ $article->InventarioF }}</td>
                        <td>100%</td>
                        <td>{{ $article->Entradas }}</td>
                        <td>{{ $article->Pendientes }}</td>
                        <td>{{ $article->Devoluciones }}</td>
                        <td>{{ $article->Ult_Entrada }}</td>
                        <td class="car" onclick="mostrarModal('{{ $article->SKU }}', '{{ $article->Modelo }}')">🛒</td>
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
            {!! $articles->onEachSide(1)->links() !!}

        </div>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="cerrarModal()">&times;</span>
                <!-- Contenido del modal -->
                <div class="modalinfo">
                    <div>
                        <img id="modalImage" src="" class="modalimage img">
                    </div>
                    <div>

                        <h1 id="modalSKU"></h1>
                        <p id="modalDescription"></p>
                    </div>
                </div>
                <div class="modal-tab">

                    <table class="modal-table">
                        <thead>
                            <tr>
                                <th>Tienda</th>
                                <th>Inventario</th>
                                <th>Entradas</th>
                                <th>Ventas</th>
                                <th>TOS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>D003</td>
                                <td>200</td>
                                <td>100</td>
                                <td>300</td>
                                <td>45%</td>
                            </tr>
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
    </div>
@endsection
    <script>
        function mostrarModal(sku, descripcion) {
            // Actualiza el SKU y la descripción en el modal
            document.getElementById('modalSKU').textContent = sku;
            document.getElementById('modalDescription').textContent = descripcion;

            var imageUrl = 'https://img.onlyclouddg.com/fotos/DG/' + sku + '/' + sku + '_1.jpg';
            // Obtiene la URL de la imagen correspondiente al SKU

            // Actualiza la fuente de la imagen en el modal
            document.getElementById('modalImage').src = imageUrl;

            // Muestra el modal
            var modal = document.getElementById('myModal');
            modal.style.display = 'block';
        }

        function cerrarModal() {
            // Cierra el modal
            var modal = document.getElementById('myModal');
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            var modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    </script>

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

<script>
    document.addEventListener("DOMContentLoaded", function () {
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
