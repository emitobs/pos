<div style="min-height: 30vh; max-height: 30vh; overflow-y:auto;">
    <div class="card simple-title-task ui-sorteable-handle">
        <div class="card-body">
            Articulos: {{count($cart_local)}}
            @if($cart_local && count($cart_local) > 0)
            <ul class="orderlines">
                @foreach (array_reverse($cart_local, true) as $key => $item)
                <li class="orderline">
                    <span class="product-name">{{$item['product_name']}}</span>
                    <span class="price">${{$item['quantity'] * $item['product_price']}}<span><a
                                href="javascript:void(0)" wire:click.prevent="decreaseQty({{$key}})"
                                class="discount bg-danger"><i class="fas fa-minus"></i></a></span></span>
                    <ul class="info-list">
                        <li class="info"><em>
                                {{$item['quantity']}}{{$item['unit']}}
                            </em><span> </span> x $ {{$item['product_price']}}
                            @if ($item['detail'] != "")
                            <p>{{$item['detail']}}</p>
                            @endif
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
