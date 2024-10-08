<style>
    .quantity {
        position: relative;
        display: flex;
        align-items: center;
    }

    .quantity-buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-right: 10px;
    }

    .input-quantity {
        width: 45px;
        height: 42px;
        line-height: 1.65;
        padding-left: 20px;
        border: 1px solid #eee;
    }

    .quantity-button {
        cursor: pointer;
        border: none;
        background: none;
        color: #333;
        font-size: 13px;
        font-family: "Trebuchet MS", Helvetica, sans-serif !important;
        line-height: 1.7;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        -o-user-select: none;
        user-select: none;
        padding: 0;
        margin-bottom: 5px;
    }

    .quantity-button.quantity-up {
        margin-bottom: 0;
    }

    .quantity-button {
        display: inline-block;
        background-color: #f8f9fa;
        color: #333;
        text-align: center;
        font-size: 16px;
        padding: 10px;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        border: none;
        transition: background-color 0.3s ease;
        line-height: 10px;
        /* ajustar si es necesario */
    }

    .quantity-button:hover {
        background-color: #e2e6ea;
        cursor: pointer;
    }

    .quantity-up {
        margin-bottom: 5px;
    }

    .quantity-down {
        margin-top: 5px;
    }
</style>
<div style="min-height: 30vh; max-height: 30vh; overflow-y:auto;">
    <div class="">
        <div class="card-body" style="background-color: white">
            Articulos: {{$total_items}}
            @if($cart_local && $total_items > 0)
            <table class="table">
                <tr>
                    <th>Codigo</th>
                    <th>Articulo</th>
                    <th>Precio</th>
                    <th class="text-center">Cantidad</th>
                    <th>Desc</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
                @foreach ($cart_local as $key => $item)
                <tr>
                    <td>{{ $item['product_barcode'] }}</td>
                    <td>{{$item['product_name']}}</td>
                    <td>{{$item['product_price']}}</td>
                    <td class="text-center">
                        <button wire:click="decreaseQuantity({{$key}},1,{{$item['product_id']}})"
                            class="quantity-button quantity-down bg-dark text-white">-</button>
                        {{$item['quantity']}}{{$item['unit']}}</em>
                        <button wire:click="increaseQuantity({{$key}},1,{{$item['product_id']}})"
                            class="quantity-button quantity-up bg-dark text-white">+</button>
                    </td>
                    <td>{{$item['detail']}}</td>
                    <td>{{$item['product_price'] * $item['quantity'] }}
                    </td>
                    <td>
                        <a href="javascript:void(0)" wire:click.prevent="remove_from_cart({{$key}})" class="discount">
                            <i class="fas fa-times-circle text-danger"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </table>
            {{-- <ul class="orderlines">
                @foreach (array_reverse($cart_local, true) as $key => $item)
                <li class="orderline">
                    <span class="product-name"></span>
                    <span class="price">${{$item['quantity'] * $item['product_price']}}<span><a
                                href="javascript:void(0)" wire:click.prevent="remove_from_cart({{$key}})"
                                class="discount"><i class="fas fa-times-circle text-danger"></i></a></span></span>
                    <ul class="info-list">
                        <li class="info">
                            <div class="d-flex align-items-center">
                                <div class="d-flex flex-column">
                                    <button wire:click="increaseQuantity({{$key}},1,{{$item['product_id']}})"
                                        class="quantity-button quantity-up mr-2 bg-dark text-white">+</button>
                                    @if($item['quantity'] > 1)
                                    <button wire:click="decreaseQuantity({{$key}},1,{{$item['product_id']}})"
                                        class="quantity-button quantity-down mr-2 bg-dark text-white">-</button>
                                    @endif
                                </div>
                                <div>
                                    <em>{{$item['quantity']}}{{$item['unit']}}</em> x $ {{$item['product_price']}}
                                    @if ($item['detail'] != "")
                                    <p>{{$item['detail']}}</p>
                                    @endif
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                @endforeach
            </ul> --}}
            @else
            <h5 class="text-center text-muted">Agrega productos a la venta</h5>
            @endif

            <div wire:loading.inline wire:target="saveSale">
                <h4 class="text-danger text-center">Guardando Venta...</h4>
            </div>
        </div>
    </div>
</div>
