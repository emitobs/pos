<div wire:ignore.self class="modal fade" id="set_kg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>¿Cuánto lleva?</b> | <b>{{$selected_Product->name}}</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="mb-2">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="radio-grs" class="custom-control-input" wire:model='kg_unit'
                                    value="grs">
                                <label class="custom-control-label" for="radio-grs">Grs</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="radio-kgs" class="custom-control-input" wire:model='kg_unit'
                                    value="kgs">
                                <label class="custom-control-label" for="radio-kgs">Kgs</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="radio-money" class="custom-control-input"
                                    wire:model='kg_unit' value="money">
                                <label class="custom-control-label" for="radio-money">$</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="number" id='kgs_quantity' autofocus='focus' wire:model.lazy="kgs_quantity"
                                wire:keydown.enter='addProduct' class="form-control" @if($kg_unit=='kgs' )
                                placeholder="1.5" step="0.01" @else placeholder="250" @endif>
                            @error('quantity') <span class="text-danger er">{{$message}}</span>@enderror
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="addProduct()" class="btn btn-dark">
                    Agregar</button>
            </div>
        </div>
    </div>
</div>
