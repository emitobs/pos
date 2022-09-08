<script src="{{asset('js/keypress.js')}}"></script>
<script>
var listener = new window.keypress.Listener();

listener.simple_combo('f1',function(){
    document.getElementById('search_client').focus();
});

listener.simple_combo('f2',function(){
    document.getElementById('search_product').focus();
});


listener.simple_combo("f6", function(){
    livewire.emit('saveSale');
});

listener.simple_combo("f8", function(){
    document.getElementById('cash').value = '';
    document.getElementById('cash').focus();
    document.getElementById('hidenTotal').value = '';
});

</script>
