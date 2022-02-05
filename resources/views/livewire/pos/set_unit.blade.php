<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>


<div wire:ignore.self class="modal fade" id="set_units" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>¿Cuánto lleva? | <b>{{$selected_Product->name}}</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="number" id='units_quantity' autofocus='focus' wire:model.lazy="units_quantity"
                                wire:keydown.enter='addProduct' class="form-control" placeholder="1" step="1">
                            @error('units_quantity') <span class="text-danger er">{{$message}}</span>@enderror
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="addProduct()" class="btn btn-dark">
                    Agregar</button>
                {{-- @if($selected_id < 1) <button type="button" wire:click.prevent="Store()" class="btn btn-dark">
                    Guardar</button>
                    @else
                    <button type="button" wire:click.prevent="Update()"
                        class="btn btn-dark close-modal">Actualizar</button>
                    @endif --}}
            </div>
        </div>
    </div>
</div>
