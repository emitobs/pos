<div>
    @push('styles')
    <style>
        title {
            background-color: red;
        }
    </style>
    @endpush

    @if($payroll)
    <!-- Inicio POS-->
    <div class="row">
        <div class="col-4">
            @include('livewire.quickPos.partials.client')
        </div>
        <div class="col-8">
            <div class="col-8">
                @include('livewire.quickPos.partials.products')
            </div>
            @include('livewire.quickPos.partials.detail')

        </div>
    </div>
    <div class="d-flex justify-content-end" style="min-height: 30vh">
        <div class="col-sm-8">
            <div class="mt-2">
                <div class="connect-sorting-content mt-4">
                    <div class="card simple-title-task ui-sortable-handle">
                        <div class="card-body">
                            @if($selected_client && $selected_client->allowed_debts == 1 && $cart_total >
                            $payments_total)
                            <div class="input-group">
                                <div class="n-chk">
                                    <label class="new-control new-checkbox checkbox-primary">
                                        <input type="checkbox" wire:model="debt" class="new-control-input">
                                        <span class="new-control-indicator"></span>A cuenta
                                    </label>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col mb-3">
                                    @if(count($cart_local) > 0 && $this->getTotalPayments() < $cart_total) <button
                                        id="btn-addPayment" data-toggle="modal" data-target="#addPayModal"
                                        class="btn btn-primary mtmobile">
                                        Agregar pago F11
                                        </button>
                                        @endif
                                </div>
                                {{-- <div class="col mb-3">
                                    <input id="saveOrder" type="button" class="btn btn-primary" value="Guardar Pedido">
                                </div> --}}
                            </div>


                            {{-- @if(use_discount())
                            <div class="input-group input-group-md mb-3">
                                <div class="input-group-prepend" style="min-width: 133px;">
                                    <span class="input-group-text input-gp hideonsm"
                                        style="background: #3b3f5c; color:white;  min-width: 133px;">
                                        Descuento F7
                                    </span>
                                </div>
                                <input type="number" id="discount" wire:model="discount"
                                    class="form-control text-center" value="0">
                                <div class="input-group-append">
                                    <span wire:click.prevent="ClearChangeCash()" class="input-group-text"
                                        style="background: #3b3f5c; color:white;">
                                        <i class=" fas fa-backspace fa-2x"></i>
                                    </span>
                                </div>
                            </div>
                            @endif --}}

                            <div id="cash_data">
                                <ul class="ul-money-detail">
                                    @if ($change > 0)
                                    <li>
                                        <h4 class="text-muted">Cambio: ${{number_format($change)}}</h4>
                                    </li>
                                    @endif
                                    @if ($cart_total != $total_result)
                                    <li>subtotal: ${{$cart_total}}</li>
                                    @endif
                                    @if($rounding != 0.00)
                                    <li>redondeo: ${{$rounding}}</li>
                                    @endif
                                    @if($discount > 0)
                                    <li>
                                        descuento: ${{$discount}}
                                    </li>
                                    @endif
                                    <li>
                                        <h2>TOTAL: ${{$total_result}}</h2>
                                        @if($remainingAmount > 0 && $remainingAmount < $total_result) <p
                                            class="text-danger">FALTANTE: ${{$remainingAmount}}</p>
                                            @endif
                                            @if($remainingAmount < 0 ) <p class="text-success">SOBRANTE:
                                                ${{$remainingAmount}}</p>
                                                @endif
                                    </li>
                                </ul>
                                @if(count($payments) > 0)
                                <span><b>Pagos:</b></span>
                                <ul class="ul-money-detail">


                                    @foreach ($payments as $key => $xpayment)
                                    <li>
                                        {{$payment_methods->where('id',$xpayment['method_id'])->first()->name}}:
                                        ${{$xpayment['amount']}} <a wire:click='deletePay({{$key}},{{$xpayment[' id'] ??
                                            0}})' href="javascript:void(0)"><i
                                                class="fas fa-times-circle text-danger"></i></a></li>
                                    @endforeach
                                </ul>
                                @endif

                            </div>
                            <div class="row justify-content-between mt-3">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    @if($total_items> 0 || $debt && $client && $address && $total_items > 0 )
                                    @if($saleSelected)
                                    <button id="btnSaveSale" wire:click.prevent="updateSale()"
                                        class="btn btn-dark btn-md btn-block">
                                        ACTUALIZAR F10
                                    </button>
                                    @else
                                    <button id="btnSaveSale" wire:click.prevent="saveSale()"
                                        class="btn btn-primary btn-md btn-block">
                                        GUARDAR F10
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
    </div>
    @include('livewire.quickPos.modals.addPay')
    <!-- Fin POS-->
    @push('scripts')
    <script src="{{asset('js/title.js')}}"></script>
    <script src="{{asset('js/onscan.min.js')}}"></script>
    <script>
        window.addEventListener('close-modal', event => {
        $('#modal').modal('hide');
         // Reemplaza 'modalId' con el ID real de tu modal.
    });
    </script>
    @include('livewire.quickPos.scripts.shortcuts')
    @include('livewire.quickPos.scripts.scan')
    @include('livewire.quickPos.scripts.events')
    @include('livewire.quickPos.scripts.general')
    @endpush
    @else
    <div class="row">
        <div class="col">
            <p>No posee caja abierta para su usuario.</p>
        </div>
    </div>
    @endif
</div>
