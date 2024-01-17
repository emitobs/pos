<div>
    <div wire:ignore='self' class="modal fade" id="addPayModal" tabindex="-1" role="dialog"
        aria-labelledby="addPayModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPayModalLabel">Nuevo pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x
                    </button>
                </div>
                <div class="modal-body">
                    <label for="">Metodo de pago</label>
                    <select wire:model='payment_method_selected' id="payment_method_selected"
                        class="form-control basic">
                        @foreach ($payment_methods as $paymentMethod)
                        <option @if($paymentMethod->id == $payment_method_selected) selected @endif
                            value="{{$paymentMethod->id}}">{{$paymentMethod->name}}</option>
                        @endforeach
                    </select>
                    <div class="form-group mt-2">
                        <label for="">Monto</label>
                        <input wire:keydown.enter='addPay()' wire:ignore.self type="number" class="form-control"
                            wire:model="amount" id="amount" required="">
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                        <button wire:click='addPay()' type="button" class="btn btn-primary">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
        @push('scripts')
        <script>
            var ss = $(".basic").select2({
                tags: true,
                dropdownParent: $('#addPayModal')
            });

    $("#payment_method_selected").on('change',function(){

    });
        </script>
        @endpush
    </div>
</div>
