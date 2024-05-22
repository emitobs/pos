<script>
    document.addEventListener('DOMContentLoaded',function(){

        window.livewire.on('scan-ok', Msg => {
            noty(Msg);
            $('#set_kg').modal('hide');
            $('#set_units').modal('hide');
            $("#selected_product").val(null).trigger("change");
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
                text: '¿Desea imprimir ticket?',
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

    // //OBTENER LOS PEDIDOS GUARDADOS
    // function getOrdersNotSavedFromLocalStorage(){
    //     return JSON.parse(localStorage.getItem('orders'));
    // }

    // //GUARDAR PEDIDO NO TERMINADOS
    // function setOrderNotSavedFromLocalStorage(order){
    //     let orderString = JSON.stringify(order);
    //     localStorage.setItem('orders', orderString)
    // }

    // //EVENT LISTENER PARA GUARDAR EL PEDIDO
    // let saveOrderBtn = document.getElementById('saveOrder');
    // saveOrderBtn.addEventListener('click', function (){

    //     let pedido = {
    //         id: 1;
    //         cliente: 'Julian',
    //         caca: 'No'
    //     }

    //     let savedOrders = getOrdersNotSavedFromLocalStorage();
    //     if(savedOrders){
    //         //obtene el pedido del formulario y lo guardas en una variable
    //         savedOrders.push(pedido)
    //         setOrderNotSavedFromLocalStorage(saveOrders);
    //     }else{
    //         let arrOrders = [pedido];
    //         setOrderNotSavedFromLocalStorage(arrORders)
    //     }
    // })

</script>
