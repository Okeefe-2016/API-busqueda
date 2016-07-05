<!-- JS -->
<script src="{{ asset('assets/js/angular/base/angular.min.js') }}"></script>
<script src="{{ asset('assets/js/angular/base/angular-animate.min.js') }}"></script>
<script src="{{ asset('assets/js/angular/base/angular-route.min.js') }}"></script>
<script src="{{ asset('assets/js/angular/base/angular-sanitize.min.js') }}"></script>
<script src="{{ asset('assets/js/angular/base/ui-bootstrap.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/jquery.flex-images.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/isotope.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('assets/js/angular/app.js') }}"></script>
<script src="{{ asset('assets/js/angular/services/entitiesService.js') }}"></script>
<script src="{{ asset('assets/js/angular/services/propertiesService.js') }}"></script>
<script src="{{ asset('assets/js/angular/controllers/indexController.js') }}"></script>
<script src="{{ asset('assets/js/angular/controllers/homeController.js') }}"></script>
<script src="{{ asset('assets/js/angular/controllers/investmentsController.js') }}"></script>
<script src="{{ asset('assets/js/angular/controllers/appraisalsController.js') }}"></script>
<script src="{{ asset('assets/js/angular/controllers/newsController.js') }}"></script>
<script src="{{ asset('assets/js/angular/controllers/propertiesController.js') }}"></script>
<script src="{{ asset('assets/js/angular/controllers/propertySheetController.js') }}"></script>
<script src="{{ asset('assets/js/angular/controllers/aboutController.js') }}"></script>
<script src="{{ asset('assets/js/angular/controllers/workWithUsController.js') }}"></script>
<script type="text/javascript">
    function initMap() {
        var map;
        var ico_marc = 'assets/img/marcador_1.png';
        map = new google.maps.Map(document.getElementById('mapa-home'), {
            center: {lat: -34.7156697, lng: -58.2854728},
            zoom: 16
        });

        var marcador = new google.maps.Marker({
            position: {lat: -34.7156697, lng: -58.2854728},
            map: map,
            title: "Inmobiliaria O'keefe",
            icon: ico_marc
        });
    }
    $(function () {
        // Switches
        if ($('[data-toggle="switch"]').length) {
            $('[data-toggle="switch"]').bootstrapSwitch({
                onColor: 'normal',
                offColor: 'default'
            });
        }
        $('#contacto').click(function() {
            $('#nombre').focus();
        });
    });
    $( document ).ready(function() {
        $('#enlace_reg').click(function(){
            $('#modal-login').modal('hide');
            $('#modal-registro').modal('show');
        });
        $('#enlace_ing').click(function(){
            $('#modal-registro').modal('hide');
            $('#modal-login').modal('show');
        });
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMSy5R0Rfyx7rnhJ50sBUsHawncc87tJo&callback=initMap" async defer></script>


</html>