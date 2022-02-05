<div class="connect-sorting">
    {{-- <h5 class="text-center mb-3">Cliente</h5>
    <div class="form-group mb-4">
        <input type="text" class="form-control" wire:model="client" id="rClientName" placeholder="Cliente *" required>
        @error('client') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <div class="form-group mb-4">
        <input type="text" class="form-control" wire:model="address" id="rAdress" placeholder="Dirección *" required>
        @error('address') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <div class="form-group mb-4">
        <input type="time" class="form-control" wire:model="deliveryTime" id="rDeliveryTime"
            placeholder="Hora de entrega" required>
        @error('deliveryTime') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <div class="input-group mb-4">
        <textarea wire:model="clarifications" class="form-control" placeholder="Aclaraciones"
            aria-label="Aclaraciones"></textarea>
    </div> --}}
    <div class="input-group mb-4">
        <div class="n-chk">
            <label class="new-control new-checkbox checkbox-primary">
                <input type="checkbox" wire:model="payWithHandy" class="new-control-input">
                <span class="new-control-indicator"></span>Con tarjeta
            </label>
        </div>

    </div>
    <div class="input-group mb-4">
        <div class="n-chk">
            <label class="new-control new-checkbox checkbox-primary">
                <input type="checkbox" wire:model="payinhouse" class="new-control-input">
                <span class="new-control-indicator"></span>A cuenta
            </label>
        </div>
    </div>
    <div class="connect-sorting-content mt-4">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                <div class="input-group input-group-md mb-3">
                    <div class="input-group-prepend" style="min-width: 133px;">
                        <span class="input-group-text input-gp hideonsm"
                            style="background: #3b3f5c; color:white;  min-width: 133px;">
                            Descuento

                        </span>
                    </div>
                    <input type="number" id="discount" wire:model="discount" wire:change="refreshTotal"
                        class="form-control text-center" value="0">
                    <div class="input-group-append">
                        <span wire:click.prevent="ClearChangeCash()" class="input-group-text"
                            style="background: #3b3f5c; color:white;"">
                            <i class=" fas fa-backspace fa-2x"></i>
                        </span>
                    </div>
                </div>
                <button wire:click.prevent="ACash(0)" class="btn btn-dark btn-block den">
                    Exacto
                </button>
                <div class="input-group input-group-md mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-gp hideonsm "
                            style="background: #3b3f5c; color:white; min-width: 133px;">
                            Efectivo F8

                        </span>
                    </div>
                    <input type="number" id="cash" wire:model="cash" wire:keydown.enter="saveSale"
                        wire:change="refreshTotal" class="form-control text-center" value="{{$cash}}">
                    <div class="input-group-append">
                        <span wire:click.prevent="ClearChangeCash()" class="input-group-text"
                            style="background: #3b3f5c; color:white;">
                            <i class="fas fa-backspace fa-2x"></i>
                        </span>
                    </div>
                </div>
                <h4 class="text-muted">Cambio: ${{(number_format($change,2) - $discount)}}</h4>
                @dd($total)
                <h2>TOTAL: ${{$total}}a</h2>
                <input type="hidden" id="hiddenTotal" value="{{$total}}">
                <div class="row justify-content-between mt-5">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        @if ($total > 0)
                        <button onclick="Confirm('','clearCart', '¿SEGURO DE ELIMINAR EL CARRITO?')"
                            class="btn btn-dark mtmobile">
                            CANCELAR F4
                        </button>
                        @endif
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        @if($cash >= $total && $total > 0)
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
