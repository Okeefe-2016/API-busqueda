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
        <h2 class="ok-property-title">{!! isset($datos->titulo[0]['contenido']) ? $datos->titulo[0]['contenido'] : $datos->ubica[0]['valor'] !!}</h2>
        @foreach ($datos->foto as $img)
            <div class="col-xs-3" style="margin-bottom: 10px">
                <img src="{!! $img['foto'] !!}" class="img-responsive full-width" alt="">
            </div>
        @endforeach
    </div>
    <h3 class="ok-ficha-tecnica-tit">Ficha Tecnica</h3>
    <div class="row ok-ficha-tecnica">
        <div class="jumbotron informacion-propiedad">
            @if (isset($datos->ubica[0]['valor']))
                <div class="row">
                    <div class="col-xs-2"><strong>Dirección</strong></div>
                    <div class="col-xs-10">
                        <span class="dato-tec"><strong>{!! $datos->ubica[0]['valor'] !!}</strong></span></div>
                </div>
            @endif
            @if (isset($datos->ubica[0]['subzona']))
                <div class="row">
                    <div class="col-xs-2"><strong>Ubicación</strong></div>
                    <div class="col-xs-10"><span class="dato-tec">{!! $datos->ubica[0]['subzona'] !!}</span></div>
                </div>
            @endif
            @if (isset($datos->subzona))
                <div class="row">
                    <div class="col-xs-2"><strong>Tipo</strong></div>
                    <div class="col-xs-10"><span class="dato-tec">{!! $datos->subzona !!}</span></div>
                </div>
            @endif
            @if (isset($datos->estado[0]['contenido']))
                <div class="row">
                    <div class="col-xs-2"><strong>Estado</strong></div>
                    <div class="col-xs-10"><span class="dato-tec">{!! $datos->estado[0]['contenido'] !!}</span></div>
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
        <div class="<?php echo (count($datos->servicios) > 0) ? 'col-xs-8' : 'col-xs-12'  ?> padding-0">
            <h3 class="ok-caracteristicas-tit">Caracteristicas</h3>
            @foreach ($datos->propiedad_caracteristicas as $char)
                @if ($char['caracteristica']['id_tipo_carac'] == 16)
                    <div class="col-xs-12 carac-item">
                        <div class="col-xs-5 padding-left-0"
                             style="float: left">{!! $char['caracteristica']['titulo'] !!}</div>
                        <div class="col-xs-7 padding-0 text-right" style="float: left">
                            @if ($char['contenido'] == 'on' || $char['contenido'] == 'Si' || $char['contenido'] == 'si')
                                <i class="fa fa-check pull-right color-orange"></i>
                            @else
                                <strong>{!! $char['contenido'] !!}</strong>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        @if (count($datos->servicios) > 0)
            <div class="col-xs-4 padding-0">
                <h3 class="ok-caracteristicas-tit">Servicios</h3>
                @foreach ($datos->servicios as $char)
                    <div class="col-xs-12 carac-item">
                        <div class="col-xs-5 padding-left-0"
                             style="float: left">{!! $char['caracteristica']['titulo'] !!}</div>
                        <div class="col-xs-7 padding-0 text-right" style="float: left">
                            @if ($char['contenido'] == 'on' || $char['contenido'] == 'Si' || $char['contenido'] == 'si')
                                <i class="fa fa-check pull-right color-orange"></i>
                            @else
                                <strong>{!! $char['contenido'] !!}</strong>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="row ok-caracteristicas">
        @if (count($datos->amenities) > 0)
            <div class="col-xs-6 padding-0">
                <h3 class="ok-caracteristicas-tit">Amenities</h3>
                @foreach ($datos->amenities as $char)
                    <div class="col-xs-12 carac-item">
                        <div class="col-xs-5 padding-left-0"
                             style="float: left">{!! $char['caracteristica']['titulo'] !!}</div>
                        <div class="col-xs-7 padding-0 text-right" style="float: left">
                            @if ($char['contenido'] == 'on' || $char['contenido'] == 'Si' || $char['contenido'] == 'si')
                                <i class="fa fa-check pull-right color-orange"></i>
                            @else
                                <strong>{!! $char['contenido'] !!}</strong>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if (count($datos->caracteristicasEdificio) > 0)
            <div class="col-xs-6 padding-0">
                <h3 class="ok-caracteristicas-tit">El Edificio</h3>
                @foreach ($datos->caracteristicasEdificio as $char)
                    <div class="col-xs-12 carac-item">
                        <div class="col-xs-5 padding-left-0"
                             style="float: left">{!! $char['caracteristica']['titulo'] !!}</div>
                        <div class="col-xs-7 padding-0 text-right" style="float: left">
                            @if ($char['contenido'] == 'on' || $char['contenido'] == 'Si' || $char['contenido'] == 'si')
                                <i class="fa fa-check pull-right color-orange"></i>
                            @else
                                <strong>{!! $char['contenido'] !!}</strong>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div> <!-- /container -->
</body>
</html>