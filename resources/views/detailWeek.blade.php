@extends('layouts.app')
<title>ProveedoresDG</title>

<div>
    @section('content')
    <link rel="stylesheet" href="{{ asset('assets/home.css') }}">
        
        @foreach ($inventario as $inv)
        @php
                // Concatenar el SKU a la URL base de la imagen
                $imageUrl = 'https://img.onlyclouddg.com/fotos/DG/' . $inv->SKU . '/' . $inv->SKU . '_1.jpg';
                // dd($imageUrl);
                @endphp
        @endforeach
        <div class="modal-content">
            <div  class="return">
                <a   href="javascript:history.back();">
                    <i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i><label for="">Regresar</label>
                    
                </a>
                
            </div>
            <div class="modalinfo">
                <div class="imgcontent">

                    <img class="img" src="{{ $imageUrl }}" alt="">
                </div>
                <div>
                    <h1>{{ $inv->SKU }}</h1>
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
