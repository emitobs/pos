<div style="min-height: 30vh; max-height: 30vh; overflow-y:auto;">
    <style>
        .orderline {
            width: 100%;
            margin: 0px;
            padding-top: 3px;
            padding-bottom: 10px;
            padding-left: 15px;
            padding-right: 15px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -ms-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-transition: background 250ms ease-in-out;
            -moz-transition: background 250ms ease-in-out;
            transition: background 250ms ease-in-out;
        }

        li {
            list-style-type: none;
        }

        .orderlines {
            padding: 0;
            margin: 0;
            list-style-type: none;
        }

        .product-name {
            padding: 0;
            display: inline-block;
            font-weight: bold;
            width: 80%;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #555555;
        }

        .info-list {
            color: #888;
        }

        .price {
            padding: 0;
            font-weight: bold;
            float: right;
            color: #555555;
        }

        em {
            color: #777;
            font-weight: bold;
            font-style: normal;
        }

        ul .info-list {
            padding-left: 13px;
        }

        .discount {
            color: #555555;
            padding: 3px;
            box-sizing: border-box;
            border-radius: 50%;
        }

        .discount i {
            color: #fff;
        }
    </style>
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
                            </em><span> </span> x $ {{$item['product_price']}} /
                            {{$item['unit']}}
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
