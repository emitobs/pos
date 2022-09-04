<div>
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <b>Deliveries</b>
                    </h4>
                    <ul class="tabs tab-pills">
                        <li>
                            <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                                data-target="#theModal">Agregar</a>
                        </li>
                    </ul>
                </div>
                @include('common.searchbox')
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped  mt-1">
                            <thead class="text-white" style="background: #3b3f5c;">
                                <tr>
                                    <th class="table-th text-white">Nombre</th>
                                    <th class="table-th text-white text-center">Teléfono</th>
                                    <th class="table-th text-white">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deliveries as $delivery )
                                <tr>
                                    <td class="text-center">{{$delivery->name}}</td>
                                    <td class="text-center">{{$delivery->telephone}}</td>
                                    <td class="text-center">
                                        <button class="btn btn-primary"
                                            wire:click="assign_orders({{$delivery->id}})">Asignar pedido</button>
                                        <button class="btn btn-secondary"
                                            wire:click="Edit({{$delivery->id}})">Editar</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$deliveries->links()}}
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('livewire.deliveries.form')
    @if($selected_delivery)
    <div wire:ignore.self class="modal fade" id="assing_orders" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white">
                        <b>Asignar pedidos a: {{$selected_delivery->name}}</b>
                    </h5>
                    <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="txtNroOrder"></label>
                                <input type="text" class="form-control" id='order_to_assign' placeholder="Nro pedido"
                                    wire:keydown.enter='assign_order()' wire:model='order_to_assign'>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Dirección</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($delivery_daily_orders as $order)
                                    <tr>
                                        <td>{{$order->id}}</td>
                                        <td>{{$order->client->name}}</td>
                                        <td>{{$order->client->address}}</td>
                                        <td>{{$order->details->count()}}</td>
                                        <td>{{$order->total}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                        data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    @endif
</div>
<script src="{{asset('js/onscan.min.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var e = jQuery.Event("keydown");
        e.which = 13;
        window.livewire.on('delivery_created', msg => {
            $('#theModal').modal('hide');
            noty('Delivery creado.');
        });

        window.livewire.on('edit_delivery', msg => {
            $('#theModal').modal('show');
        });

        window.livewire.on('delivery_updated', msg =>{
            $('#theModal').modal('hide');
            noty(msg);
        });

        window.livewire.on('noty', msg => {
            noty(msg);
        })

        window.livewire.on('show_assing_orders', msg => {
            $('#assing_orders').modal('show');
        });


        window.livewire.on('order_assigned', msg => {
            noty(msg);
        });

        window.livewire.on('order_not_found', msg => {
            noty(msg);
        });

        window.livewire.on('refresh_daily_deliveries', data => {

        });

        try {
    onScan.attachTo(document,{
        suffixKeyCodes:[13],
        onScan: function(barcode){
            @this.order_to_assign = barcode;
            Livewire.emit('assign_order')
        },
        minLength: 4,
        onScanError: function(e){
        }
    });
} catch (e) {

}
    });

</script>
<script>

</script>
