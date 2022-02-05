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
                            <input type="text" class="form-control" placeholder="Nro pedido" name="" id=""
                                wire:keydown.enter='assign_order' wire:model='order_to_assign'>
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
                                @dd($orders)
                                @foreach ($orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->client->name}}</td>
                                    <td>{{$order->client->address}}</td>
                                    <td>{{$order->details->sum('quantity')}}</td>
                                    <td>{{$order->total}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$orders->links()}}
                        {{-- @livewire('delivery-daily-orders', ['selected_delivery' => $selected_delivery->id]) --}}
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
