@include("inc.header")

<body ng-controller="indexController">
<div class="encabezado">
    <div class="container-fluid">
        <div class="row">
            <div class="logo col-xs-3">
                <div class="img-logo">
                    <a href="#/inicio"><img class="img-responsive" src="assets/img/logo.gif"></a>
                </div>
            </div>
            <div class="grupo-enc">
                <div class="btn_contacto col-xs-2 pull-right">
                    <a id="contacto" class="btn btn-verde btn-block btn-lg" role="button">CONTACTO</a>
                </div>
                <div class="menu text-center pull-right">
                    <div class="item i1">
                        <a href="">Rural</a>
                    </div>
                    <div class="item i2">
                        <a href="#/inversiones">Inversiones</a>
                    </div>
                    <div class="item i3">
                        <a href="#/tasaciones">Tasaciones</a>
                    </div>
                    <div class="item i4">
                        <a href="#/noticias">Noticias</a>
                    </div>
                    <div class="item i5">
                        <a data-toggle="modal" data-target="#modal-login">Registrarse</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <form class="filtros">
                <div class="col-xs-3">
                    <label class="flecha-select lg">
                        <select class="form-control input-lg custom">
                            <option>Compra</option>
                        </select>
                    </label>
                </div>
                <div class="col-xs-3">
                    <label class="flecha-select lg">
                        <select class="form-control input-lg custom">
                            <option>Tipo de Inmueble</option>
                        </select>
                    </label>

                </div>
                <div class="col-xs-4">
                    <input class="form-control input-lg custom" type="text" name="" placeholder="Zona|Emprendimiento">
                </div>
                <div class="btn_buscar col-xs-2 pull-right">
                    <a href="#/propiedades" type="submit" class="btn btn-naranja btn-block btn-lg">BUSCAR</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="todo container-fluid">
    <div id="siteContent"  ng-view autoscroll="true">
        <!-- Site content -->
    </div>
    <!---FOOTER-->
    <div class="row footer">
        <div class="col-xs-3">
            <img class="img-responsive center-block foot-logo" src="assets/img/logo.gif">

            <div class="col-xs-6 enlaces">
                <a href="">Nosotros</a>
                <a href="">Servicios</a>
                <a href="">Tasaciones</a>
                <a href="">Contacto</a>
                <a href="">Sitemap</a>
            </div>
            <div class="col-xs-6 enlaces">
                <a href="">Rural</a>
                <a href="">Residencial</a>
                <a href="">Comercial</a>
                <a href="">Eprendimientos</a>
                <a href="">Industrial</a>
            </div>
            <div class="col-xs-12 foot-datos">
                <address>
                    <small>
                        <strong>Oficina central: </strong>Mitre 491 Quilmes <br>
                        <strong>Tel: </strong> 5411 4253-3961<br>
                        <strong>email: </strong> inmobiliaria@okeefe.com.ar<br>
                    </small>
                </address>

                <div class="redes">
                    <div class="red">
                        <a href="">
                            <img class="img-responsive" src="assets/img/FACEBOOK.svg">
                        </a>
                    </div>
                    <div class="red">
                        <a href="">
                            <img class="img-responsive" src="assets/img/LINKEDIN.svg">
                        </a>
                    </div>
                    <div class="red">
                        <a href="">
                            <img class="img-responsive" src="assets/img/YOUTUBE.svg">
                        </a>
                    </div>
                </div>
            </div>


        </div>
        <div class="col-xs-4 col-xs-offset-1">
            <h5>Nuestras oficinas</h5>
            <div id="mapa-home"></div>
            <span class="enlace-sucursal"><a href=""><h3>SUCURSAL QUILMES<i class="fa fa-chevron-right"></i></h3></a></span>
        </div>
        <div class="col-xs-4">
            <h5>Formulario de consultas</h5>
            <form class="f_contacto">
                <input id="nombre" class="form-control custom" type="text" name="nombre" placeholder="Nombre">
                <input class="form-control custom" type="text" name="apellido" placeholder="Apellido">
                <input class="form-control custom" type="text" name="telefono" placeholder="Telefono">
                <input class="form-control custom" type="text" name="celular" placeholder="Celular">
                <input class="form-control custom" type="text" name="email" placeholder="E-mail">
                <textarea class="form-control custom" name="mensaje" placeholder="Mensaje"></textarea>
                <div class="checkbox">
                    <div class="bootstrap-switch-square">
                        <input type="checkbox" data-toggle="switch" id="sub" data-on-text="<span class='fa fa-check'></span>" data-off-text="<span class='fa fa-close'></span>" />
                        <label for="sub" class="css-label">Suscribirme al newsletter</label>
                    </div>
                    <div class="col-xs-4 pull-right">
                        <button class="btn btn-verde btn-block" type="submit">ENVIAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- MODAL LOGIN -->
<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="labelModalReg">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="assets/img/cerrar.png"></span></button>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="titulo">Guardando tus búsquedas en <strong>Favoritos</strong> podrás acceder a ellas en cualquier momento!</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 logins">
                            <div class="l_face">
                                <div class="col-xs-3">
                                    <img class="img-responsive" src="assets/img/face_reg.svg">
                                </div>
                                <span>Iniciar sesión con Facebook</span>
                            </div>

                            <div class="l_goo">
                                <div class="col-xs-3 ">
                                    <img class="img-responsive" src="assets/img/goo_reg.svg">
                                </div>
                                <span>Iniciar sesión con Google</span>
                            </div>

                            <span class="nota1">Nunca publicaremos nada sin tu permiso</span>
                            <h3>¿NO TENÉS CUENTA?</h3>
                            <a id="enlace_reg" class="enlace_reg">¡Registrate!</a>
                        </div>
                        <div class="col-xs-6 form_login">
                            <form class="f_login">
                                <input class="form-control input-lg custom" type="text" name="nombre" placeholder="Email*">
                                <input class="form-control input-lg custom" type="text" name="nombre" placeholder="Contraseña*">

                                <div class="blq_not">
                                    <span class="nota">* campo obligatorio</span>
                                </div>
                                <div class="blq_not">
                                    <input type="checkbox" name="recordar_c" id="recordar_c" class="css-checkbox-mini" />
                                    <label for="recordar_c" class="css-label-mini">Recordar contraseña</label>
                                </div>
                                <div class="col-xs-7 pull-right">
                                    <button class="btn btn-verde btn-block" type="submit">INGRESAR</button>
                                </div>

                                <span class="enlace_rec"><a href="">¿Olvidaste tu contraseña?</a></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- FIN MODAL LOGIN -->
<!--- MODAL REGISTRO -->
<div class="modal fade" id="modal-registro" tabindex="-1" role="dialog" aria-labelledby="labelModalReg">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="assets/img/cerrar.png"></span></button>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="titulo">Guardando tus búsquedas en <strong>Favoritos</strong> podrás acceder a ellas en cualquier momento!</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 logins">
                            <div class="l_face">
                                <div class="col-xs-3">
                                    <img class="img-responsive" src="assets/img/face_reg.svg">
                                </div>
                                <span>Iniciar sesión con Facebook</span>
                            </div>

                            <div class="l_goo">
                                <div class="col-xs-3 ">
                                    <img class="img-responsive" src="assets/img/goo_reg.svg">
                                </div>
                                <span>Iniciar sesión con Google</span>
                            </div>

                            <span class="nota1">Nunca publicaremos nada sin tu permiso</span>
                            <h3>¿YA TENÉS CUENTA?</h3>
                            <a id="enlace_ing" class="enlace_ing">Ingresá!</a>
                        </div>
                        <div class="col-xs-6 form_reg">
                            <form class="f_reg">
                                <input class="form-control custom" type="text" name="nombre" placeholder="Nombre*">
                                <input class="form-control custom" type="text" name="apellido" placeholder="Apellido*">
                                <input class="form-control custom" type="text" name="email" placeholder="Email*">
                                <input class="form-control custom" type="text" name="tel" placeholder="Teléfono*">
                                <input class="form-control custom" type="text" name="contraseña" placeholder="Contraseña*">
                                <input class="form-control custom" type="text" name="confirmar" placeholder="Confirmar Contraseña*">
                                <select name="pregunta" class="form-control custom">
                                    <option>Elige tu pregunta secreta</option>
                                </select>
                                <input class="form-control custom" type="text" name="respuesta" placeholder="Respuesta secreta">

                                <div class="blq_not">
                                    <span class="nota">* campo obligatorio</span>
                                </div>
                                <div class="blq_not">
                                    <input type="checkbox" name="aceptar" id="aceptar" class="css-checkbox-mini" />
                                    <label for="aceptar" class="css-label-mini">Acepto los <a class="enlace_term" href="">Terminos y condiciones</a></label>
                                </div>
                                <div class="col-xs-8 pull-right">
                                    <button class="btn btn-verde btn-block" type="submit">CREAR CUENTA</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- FIN  MODAL REGISTRO -->
</body>

@include("inc.footer")