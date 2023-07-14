<script>
    document.addEventListener('DOMContentLoaded',function(){

        window.livewire.on('scan-ok', Msg => {
            noty(Msg);
            $('#set_kg').modal('hide');
            $('#set_units').modal('hide');
            $("#selected_product").val(null).trigger("change");
            $('#selected_product').select2('open');
            setTimeout(() => {
                $(".select2-search__field")[0].focus();
            }, 500);
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
        window.livewire.on('confirm-print-ticket', saleId => {
            Swal.fire({
                title: 'Pedido realizado',
                text: '¿Desea imprimir ticket #' + saleId.saleId + '?',
                showCancelButton: true,
                cancelButtonColor: '#fff',
                confirmButtonColor: '#3b3f5c',
                imageUrl:  '{{URL::asset('assets/icos/receipt.svg')}}',
                imageWidth: 100,
                imageHeight: 100,
                imageAlt: 'Custom image',
            }).then((result) => {
                if(result.value){
                    print_ticket(saleId.saleId);
                }
                location.reload();
            });
        });
        window.livewire.on('print-ticket', saleId => {
            print_ticket(saleId);
        });

        window.livewire.on('sale-ok', Msg => {
            noty(Msg);
            setTimeout(()=>{
                livewire.emit('redirectPos');
            },500);
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
            document.title = 'Cliente: ' + $('#rtelephone').val();
        noty(msg);
        });

        window.livewire.on('set_kg',msg => {
            $('#set_kg').modal('show');
        });

        window.livewire.on('set_units',msg => {
            $('#set_units').modal('show');
        });

        livewire.on('aggregate-partial-payment', () => {
            noty('pago agregado');
            $("#payment_method_selected").select2('open');
        });

        livewire.on('aggregate-total-payment', () => {
            noty('pago agregado');
            $("#addPayModal").modal('hide');
        });


        $('#set_units').on('shown.bs.modal', function () {
            $('#units_quantity').focus()
        })

        $('#set_kg').on('shown.bs.modal', function () {
            $('#kgs_quantity').focus()
        })
    });

    function print_ticket(saleId){
        window.open("print://" + saleId + "/1", '_self');
    }
</script>