<script src="{{asset('js/keypress.js')}}"></script>
<script>
    var listener = new window.keypress.Listener();

listener.simple_combo('f1',function(){
    $('#selected_product').select2('close');
    $('#search_client').select2('open');
    $(".select2-search__field")[0].focus();
});

listener.simple_combo('f2',function(){
    $('#search_client').select2('close');
    $('#selected_product').select2('open');
    $(".select2-search__field")[0].focus();
});

listener.simple_combo("f3", function(){
   $('#payment_cash').focus();
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