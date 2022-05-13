<div>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/forms/theme-checkbox-radio.css')}}">
    <link href="{{asset('assets/css/tables/table-basic.css')}}" rel="stylesheet" type="text/css">
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <b>Finalizando servicio</b>
                    </h4>
                </div>
                <div class="widget-content">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Ingresar cliente buscado..."
                                    wire:model='searched_client'>
                                @if(strlen($searched_client) > 0)
                                <div wire:loading class="rounded-t-none shadow-lg list-group">
                                    <div class="list-item">Buscando...</div>
                                </div>
                                <ul class="list-group">
                                    @foreach ($clients as $client)
                                    <li class="list-group-item" style="font-size: 12px"
                                        wire:click.prevent="selectClient({{$client->id}})">
                                        {{$client->name}} | {{$client->telephone}} | {{$client->default_address}}
                                    </li>

                                    @endforeach
                                </ul>
                                @if(!empty($client))
                                <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="reset"></div>
                                @endif
                                @error('client') <span class="text-danger er">{{$message}}</span>@enderror
                                @endif
                            </div>
                            <hr>
                            <div class="form-group mb-4">
                                <input type="text" class="form-control" wire:model="client" id="rClientName"
                                    placeholder="Cliente *" required>
                                @error('client') <span class="text-danger er">{{$message}}</span>@enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row mb-3">
                                <div class="col">
                                    <button class="btn btn-primary" wire:click="select_all_products">Seleccionar
                                        todo</button>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($out as $product)
                                <a href="javascript:void(0)"
                                    wire:click.prevent="$emit('select_product', {{$product->id}})" title="Ver"
                                    class="mr-5">
                                    <div class="col-6 mb-1 mr-3">
                                        <div class="card component-card_2">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">{{$product->product->name}}</h5>
                                                <p>Precio: ${{$product->unit_price}}</p>
                                                <p>{{$product->detail}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-4">
                            @include('livewire.processServices.partials.detail')
                            <div class="mt-2">
                                <div class="connect-sorting-content mt-4">
                                    <div class="card simple-title-task ui-sortable-handle">
                                        <div class="card-body">
                                            <div class="input-group mb-4">
                                                <div class="custom-control custom-radio mr-2">
                                                    <input wire:model='payment_method' value='cash' type="radio"
                                                        id="payment_cash" class="custom-control-input">
                                                    <label class="custom-control-label"
                                                        for="payment_cash">Efectivo</label>
                                                </div>
                                                @if(number_format(-$in->sum('unit_price') + $cash +
                                                $discount,2) < 0) <div class="custom-control custom-radio mr-2">
                                                    <input wire:model='payment_method' value='card' type="radio"
                                                        id="card" class="custom-control-input">
                                                    <label class="custom-control-label" for="card">Tarjeta</label>
                                            </div>
                                            <div class="custom-control custom-radio mr-2">
                                                <input wire:model='payment_method' value='debt' type="radio" id="debt"
                                                    class="custom-control-input">
                                                <label class="custom-control-label" for="debt">A cuenta</label>
                                            </div>
                                            @endif
                                        </div>
                                        {{-- <div class="input-group input-group-md mb-3">
                                            <div class="input-group-prepend" style="min-width: 133px;">
                                                <span class="input-group-text input-gp hideonsm"
                                                    style="background: #3b3f5c; color:white;  min-width: 133px;">
                                                    Descuento

                                                </span>
                                            </div>
                                            <input type="number" id="discount" wire:model.lazy="discount"
                                                wire:keydown.enter="refreshTotal" class="form-control text-center"
                                                value="0">
                                            <div class="input-group-append">
                                                <span wire:click.prevent="ClearChangeCash()" class="input-group-text"
                                                    style="background: #3b3f5c; color:white;"">
                                                            <i class=" fas fa-backspace fa-2x"></i>
                                                </span>
                                            </div>
                                        </div> --}}
                                        <div id="cash_data">
                                            <div class="input-group input-group-md mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text input-gp hideonsm "
                                                        style="background: #3b3f5c; color:white; min-width: 133px;">
                                                        Efectivo F8
                                                    </span>
                                                </div>
                                                <input type="number" id="cash" wire:model.lazy="cash"
                                                    wire:keydown.enter="refreshTotal" wire:keydown.tab="refreshTotal"
                                                    class="form-control text-center" value="0">
                                                <div class="input-group-append">
                                                    <span wire:click.prevent="ClearChangeCash()"
                                                        class="input-group-text"
                                                        style="background: #3b3f5c; color:white;">
                                                        <i class="fas fa-backspace fa-2x"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            @if($payment_method == 'cash')
                                            <button wire:click.prevent="ACash(0)" class="btn btn-dark btn-block den">
                                                Exacto
                                            </button>
                                            <ul class="ul-money-detail">
                                                <li>
                                                    <h4 class="text-muted">Cambio:
                                                        ${{number_format(-$in->sum('unit_price') + $cash +
                                                        $discount,2)}}
                                                    </h4>
                                                </li>
                                                <li>subtotal: ${{$cart_total - $discount}}</li>
                                                @if($rounding != 0.00)
                                                <li>redondeo: ${{$rounding}}</li>
                                                @endif
                                            </ul>
                                            @endif
                                        </div>
                                        <input type="hidden" id="hiddenTotal" value="{{number_format($cart_total,2)}}">
                                        <div class="row justify-content-between mt-3">
                                            <div class="col-sm-12 col-md-12 col-lg-6">
                                                @if ($total > 0)
                                                <button
                                                    onclick="Confirm('','clearCart', '¿SEGURO DE ELIMINAR EL CARRITO?')"
                                                    class="btn btn-dark mtmobile">
                                                    CANCELAR F4
                                                </button>
                                                @endif
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-6">

                                                <button wire:click.prevent="saveSale()"
                                                    class="btn btn-dark btn-md btn-block">
                                                    GUARDAR F9
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('print-ticket', saleId => {
            window.open("print://" + saleId + "/1", '_self');
        });
        });
</script>
</div>
