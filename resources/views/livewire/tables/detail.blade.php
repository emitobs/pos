<div>
    <div class="card simple-title-task ui-sorteable-handle">
        <div class="card-body" style="padding: 5px;">
            Articulos: {{$table_selected->current_service->products->where('order_id',null)->count()}}
            @if($table_selected && $table_selected->current_service->products->where('order_id',null)->count() > 0)
            <div style="min-height: 30vh; max-height: 30vh; overflow-y:auto;">
                <ul class="orderlines">
                    @foreach ($table_selected->current_service->products->where('order_id',null) as $xproduct)
                    <li class="orderline" style="border-bottom:solid 1px black; margin-bottom: 5px;">
                        <span class="product-name">{{$xproduct->product->name}}</span>
                        <span class="price">${{$xproduct->quantity * $xproduct->unit_price}}<span><a
                                    href="javascript:void(0)" wire:click.prevent="decreaseQty({{$xproduct->id}})"
                                    class="discount bg-danger"><i class="fas fa-minus"></i></a></span></span>
                        <ul class="info-list">
                            <li class="info"><em>
                                    {{$xproduct->detail}}
                            </li>
                        </ul>
                    </li>
                    @endforeach
                </ul>
                @else
                <h5 class="text-center text-muted">Agrega productos a la venta</h5>
                @endif
                <div wire:loading.inline wire:target="saveSale">
                    <h4 class="text-danger text-center">Guardando Venta...</h4>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-danger mt-2">Limpiar pedido</button>
    <button class="btn btn-info mt-2" wire:click='generate_order'>Generar pedido</button>

    <div class="card simple-title-task ui-sorteable-handle mt-4">
        Ordenes
        @foreach ($table_selected->current_service->orders as $order)
        <div style="border-bottom:solid 1px black;">
            <p>#: {{$order->id}} | Hora entrega: {{\Carbon\Carbon::parse($order->delivery_time)->format('H:i')}}</p>
            @foreach ($order->products as $product)
            <div>
                <p>{{$product->product->name}}</p>
                <p>{{$product->detail}}</p>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>

    <script>
        window.livewire.on('empty-cart', data => {
            noty('No hay productos para ordenar.')
        });
    </script>
