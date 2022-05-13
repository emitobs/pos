<script>
    document.addEventListener('DOMContentLoaded',function(){
        window.livewire.on('scan-ok', Msg => {
            noty(Msg);
            $('#set_kg').modal('hide');
            $('#set_units').modal('hide');
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
    })
</script>
