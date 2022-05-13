<div>
    @if($payroll)
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
            @include('livewire.pos.partials.clarifications')
        </div>
        <div class="col">
            @include('livewire.pos.partials.products')
        </div>
        <div class="col-sm-12 col-md-3">
            @include('livewire.pos.partials.detail')
            <div class="mt-2">

                <div class="connect-sorting-content mt-4">
                    <div class="card simple-title-task ui-sortable-handle">
                        <div class="card-body">
                            <div class="input-group mb-4">
                                <div class="custom-control custom-radio mr-2">
                                    <input wire:model='payment_method' value='cash' type="radio" id="payment_cash"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="payment_cash">Efectivo</label>
                                </div>
                                <div class="custom-control custom-radio mr-2">
                                    <input wire:model='payment_method' value='card' type="radio" id="card"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="card">Tarjeta</label>
                                </div>

                                @if($selected_client && $selected_client->allowed_debts)
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
                                    wire:keydown.enter="refreshTotal" class="form-control text-center" value="0">
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
                                        <span wire:click.prevent="ClearChangeCash()" class="input-group-text"
                                            style="background: #3b3f5c; color:white;">
                                            <i class="fas fa-backspace fa-2x"></i>
                                        </span>
                                    </div>
                                </div>
                                @if($payment_method == 'cash')
                                <button wire:click.prevent="ACash(0)" class="btn btn-dark btn-block den">
                                    Exacto
                                </button>

                                @endif
                                <ul class="ul-money-detail">
                                    <li>
                                        <h4 class="text-muted">Cambio: ${{number_format($change + $discount,2)}}</h4>
                                    </li>
                                    <li>subtotal: ${{$cart_total - $discount}}</li>
                                    @if($rounding != 0.00)
                                    <li>redondeo: ${{$rounding}}</li>
                                    @endif
                                    <li>
                                        <h2>TOTAL: ${{$total_result}}</h2>
                                    </li>
                                </ul>



                            </div>
                            <input type="hidden" id="hiddenTotal" value="{{number_format($cart_total,2)}}">
                            <div class="row justify-content-between mt-3">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    @if ($total > 0)
                                    <button onclick="Confirm('','clearCart', '¿SEGURO DE ELIMINAR EL CARRITO?')"
                                        class="btn btn-dark mtmobile">
                                        CANCELAR F4
                                    </button>
                                    @endif
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    @if($cash >= $total_result && $total_result > 0 || $discount - $total_result == 0 &&
                                    $itemsQuantity > 0 || $payment_method == 'card' || $payment_method == 'debt')
                                    @if($saleSelected)
                                    <button wire:click.prevent="updateSale()" class="btn btn-dark btn-md btn-block">
                                        ACTUALIZAR F9
                                    </button>
                                    @else
                                    <button wire:click.prevent="saveSale()" class="btn btn-dark btn-md btn-block">
                                        GUARDAR F9
                                    </button>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($selected_Product)
        @if ($selected_Product->unit_sale == 1)
        @include('livewire.pos.set_unit')
        @endif
        @if ($selected_Product->unit_sale == 2)
        @include('livewire.pos.set_kg')
        @endif
        @endif


    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function(){
        // $('#select-client').on('change', function(e){
        //     var client_id = $('#select-client').select2("val");
        //     //@this.set()
        // });
        window.livewire.on('noty', msg => {
        noty(msg);
        });

        window.livewire.on('set_kg',msg => {
            $('#set_kg').modal('show');
        });

        window.livewire.on('set_units',msg => {
            $('#set_units').modal('show');
        });

        $('#set_units').on('shown.bs.modal', function () {
            // get the locator for an input in your modal. Here I'm focusing on
            // the element with the id of myInput
            $('#units_quantity').focus()
        })

        $('#set_kg').on('shown.bs.modal', function () {
            // get the locator for an input in your modal. Here I'm focusing on
            // the element with the id of myInput
            $('#kgs_quantity').focus()
        })
    });
    </script>
    <script src="{{asset('js/keypress.js')}}"></script>
    <script src="{{asset('js/onscan.min.js')}}"></script>

    @include('livewire.pos.scripts.shortcuts')
    @include('livewire.pos.scripts.events')
    @include('livewire.pos.scripts.general')
    @include('livewire.pos.scripts.scan')

    @else
    <div class="row">
        <div class="col">
            <p>No posee caja abierta para su usuario.</p>
        </div>
    </div>
    @endif
</div>
