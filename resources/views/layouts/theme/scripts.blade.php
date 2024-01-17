<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->

<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/apps.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
            App.init();
        });
</script>
<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
<script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>
<script src="{{asset('plugins/currency/currency.js')}}"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

<script src="{{asset('assets/js/dashboard/dash_2.js')}}"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script>
    function noty(msg, option = 1)
    {
    Snackbar.show({
    text: msg.toUpperCase(),
    actionText: 'CERRAR',
    actionTextColor: '#fff',
    backgroundColor: option == 1 ? '#3b3f5c' : '#e7515a',
    pos: 'top-right'
    });
    }
</script>
<script>
    function getContrastColor(hexColor){
    // Si el color de fondo no es en formato hexadecimal de 6 caracteres, regresa un valor predeterminado
    if(hexColor.length !== 7 || hexColor[0] !== '#') return '#000000';

    var r = parseInt(hexColor.substr(1,2), 16); // Extraer color rojo
    var g = parseInt(hexColor.substr(3,2), 16); // Extraer color verde
    var b = parseInt(hexColor.substr(5,2), 16); // Extraer color azul

    // Calcular la luminosidad del color (luminance)
    var luminance = 0.299*r + 0.587*g + 0.114*b;

    // Dependiendo de la luminosidad, decidir si el color de texto debe ser claro u oscuro
    return (luminance > 128) ? '#000000' : '#FFFFFF';
}

function setTextLogoColor(){
    var navbar = $('.navbar');
    var rgbColor = navbar.css('backgroundColor');

    // Convertir el color de fondo a hexadecimal
    var hexColor = rgbColor.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    hexColor = "#" + hex(hexColor[1]) + hex(hexColor[2]) + hex(hexColor[3]);

    // Obtener el color de contraste adecuado y aplicarlo al elemento navbar
    var contrastColor = getContrastColor(hexColor);
    $('b').css('color',contrastColor);

}
$(document).ready(function() {
    setTextLogoColor();
});
</script>
@livewireScripts
@stack('scripts')
