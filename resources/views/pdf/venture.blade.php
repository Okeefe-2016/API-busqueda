<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- Bootstrap core CSS -->
    {!! Html::style('assets/css/bootstrap.min.css') !!}
    {!! Html::style('assets/css/custom.css') !!}
    {!! Html::style('assets/css/font-awesome.min.css') !!}
</head>
<body>
<div class="container">
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="row">
        <h2 class="ok-property-title">{!! isset($datos->nombre) ? $datos->nombre : $datos->id_emp !!}</h2>
        <!-- imagenes -->
    </div>
    <h3 class="ok-ficha-tecnica-tit">Ficha Tecnica</h3>
    <div class="row ok-ficha-tecnica">
        <div class="jumbotron informacion-propiedad">
            @if (isset($datos->ubicacion))
                <div class="row">
                    <div class="col-xs-2"><strong>Ubicación</strong></div>
                    <div class="col-xs-10"><span class="dato-tec">{!! $datos->ubicacion !!}</span></div>
                </div>
            @endif
            @if (isset($datos->estado))
                <div class="row">
                    <div class="col-xs-2"><strong>Estado</strong></div>
                    <div class="col-xs-10"><span class="dato-tec">{!! $datos->estado !!}</span></div>
                </div>
            @endif
            @if (isset($datos->descripcion) || isset($datos->desc[0]['contenido']))
                <div class="row">
                    <div class="col-xs-2"><strong>Descripción</strong></div>
                    <div class="col-xs-10"><span
                                class="dato-tec">{!! isset($datos->desc[0]['contenido']) ? $datos->desc[0]['contenido'] : $datos->descripcion !!}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="row ok-caracteristicas">
        @if (count($datos->amenities) > 0)
            <div class="<?php echo (count($datos->terminaciones) > 0) ? 'col-xs-6' : 'col-xs-12'  ?> padding-0">
                <h3 class="ok-caracteristicas-tit">Amenities</h3>
                @foreach ($datos->amenities as $char)
                    <div class="col-xs-12 carac-item">
                        {!! $char['contenido'] !!}
                    </div>
                @endforeach
            </div>
        @endif
        @if (count($datos->terminaciones) > 0)
            <div class="<?php echo (count($datos->amenities) > 0) ? 'col-xs-6' : 'col-xs-12'  ?> padding-0">
                <h3 class="ok-caracteristicas-tit">Terminaciones</h3>
                @foreach ($datos->terminaciones as $char)
                    <div class="col-xs-12 carac-item">
                        {!! $char['contenido'] !!}
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="row ok-caracteristicas">
        <div class="col-xs-12 padding-0">
            <h3 class="ok-caracteristicas-tit">Propiedades</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>Ubicación</th>
                    <th class="text-center">Ambientes</th>
                    <th class="text-center">Superficie total</th>
                    <th class="text-center">Operación</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($datos->properties as $char)
                    <tr>
                        <td>
                            <a href="http://sitio.okeefe.com.ar/#!/ficha-emprendimiento/{!! $char['id_emp'] !!}">{!! $char['calle'] !!}</a>
                        </td>
                        <td class="text-center">
                            @if (isset($char['cantidad_ambientes']))
                                {!! count($char['cantidad_ambientes']) !!}
                            @else
                                ---
                            @endif
                        </td>
                        <td class="text-center">
                            @if (count($char['sup_total']) > 0)
                                {!! $char['sup_total'][0]['contenido'] !!}
                            @else
                                ---
                            @endif
                        </td>
                        <td class="text-center">
                            @if (isset($char['operacion']))
                                {!! $char['operacion'] !!}
                            @else
                                ---
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="col-xs-12 carac-item">

            </div>
        </div>
    </div>
</div> <!-- /container -->
</body>
</html>