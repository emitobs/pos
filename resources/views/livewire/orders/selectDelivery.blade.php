@if($sale)
<div wire:ignore class="modal fade" id="theModalSelectDelivery" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Seleccionar delivery</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Seleccione delivery</label>
                            <select class="form-control" id="selectDelivery" wire:model.defer="selectedDelivery">
                                <option value="0">Seleccione delivery</option>
                                @foreach ($deliveries as $delivery)
                                <option value="{{$delivery->id}}">{{$delivery->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" wire:click.prevent="delivered({{$sale->id}})"
                    class="btn btn-success mb-2 tabmenu">Entregado</a>
                <button type="button" class="btn btn-dark close-btn text-info" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endif
