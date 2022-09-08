<script>
    document.addEventListener('DOMContentLoaded',function(){
        window.livewire.on('scan-ok', Msg => {
            noty(Msg);
            $('#set_kg').modal('hide');
            $('#set_units').modal('hide');
            $("#selected_product").val('default');
            $("#select2-selected_product-container").html('Buscar producto');
            $("#selected_product").focus();
        });

        window.livewire.on('scan-notfound', Msg => {
            noty(Msg, 2);
        });
        window.livewire.on('no-stock', Msg => {
            noty(Msg, 2);
        });
        window.livewire.on('sale-error', Msg => {
            noty(Msg);
        });
        window.livewire.on('print-ticket', saleId => {
            window.open("print://" + saleId + "/1", '_self');
        });
        window.livewire.on('sale-ok', Msg => {
            noty(Msg);
        });

        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('product_selected', msg => {
            noty('Producto seleccionado');
            $('#quantity').focus();
        });
        window.livewire.on('noty', msg => {
        noty(msg);
        });

        window.livewire.on('set_kg',msg => {
            $('#set_kg').modal('show');
        });

        window.livewire.on('set_units',msg => {
            $('#set_units').modal('show');
        });

        $('#set_units').on('shown.bs.modal', function () {
            // get the locator for an input in your modal. Here I'm focusing on
            // the element with the id of myInput
            $('#units_quantity').focus()
        })

        $('#set_kg').on('shown.bs.modal', function () {
            // get the locator for an input in your modal. Here I'm focusing on
            // the element with the id of myInput
            $('#kgs_quantity').focus()
        })
    })
</script>
