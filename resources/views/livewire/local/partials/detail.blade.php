<div class="connect-sorting">
    <h5 class="text-center mb-3">Venta</h5>
    <div class="connect-sorting-content">
        <div class="card simple-title-task ui-sorteable-handle">
            <div class="card-body">
                Articulos: {{$itemsQuantity}}
                @if ($total > 0)
                <div class="table-responsive tblscroll" style="max-height: 650px; overflow:hidden;">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c;">
                            <tr>
                                <th class="table-th text-left text-white">Descripción</th>
                                <th class="table-th text-center text-white">Precio</th>
                                <th class="table-th text-center text-white">Cantidad</th>
                                <th class="table-th text-center text-white">Importe</th>
                                <th class="table-th text-center text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)
                            @dd($cart)
                            <tr>
                                <td>
                                    <h6>{{$item->name}}</h6>
                                </td>
                                <td class="text-center">${{number_format($item->price,2)}}</td>
                                <td>
                                    <input type="number" min="1" id="r{{$item->id}}" style="font-size:1rem!important;"
                                        class="form-control text-center" value="{{$item->quantity}}">
                                </td>
                                <td class="text-center">
                                    <h6>
                                        ${{number_format($item->price * $item->quantity,2)}}</h6>
                                </td>
                                <td class="text-center">
                                    <button wire:click.prevent="decreaseQty({{$item->id}})"
                                        class="btn btn-dark mbmobile">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button wire:click.prevent="increaseQty({{$item->id}})"
                                        class="btn btn-dark mbmobile">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <h5 class="text-center text-muted">Agrega productos a la venta</h5>
                @endif

                <div wire:loading.inline wire:target="saveSale">
                    <h4 class="text-danger text-center">Guardando Venta...</h4>
                </div>
            </div>
        </div>
    </div>
</div>
