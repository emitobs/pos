$(document).ready(function () {
    setTitle();
});


$('#rtelephone').on('change', function () {
    setTitle();
});

function setTitle() {
    let client = $('#rtelephone').val();
    if (client != null || client != '')
        client = 'Sin asignar';
    document.title = 'Cliente: ' + client;
}