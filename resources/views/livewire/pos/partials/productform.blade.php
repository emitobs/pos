<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    @if($selected_Product)
                    <b>{{$selected_Product->name}} | </b>
                    @endif
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="card component-card_2">
                    <div class="row">
                        <div class="col-6"><img src="assets/img/400x300.jpg" class="card-img-top" alt="widget-card-2">
                        </div>
                        <div class="col-6">
                            <div class="card-body">
                                <h5 class="card-title">{{$selected_Product ? $selected_Product->name : ''}}</h5>
                                <p class="card-text">{{$selected_Product ? $selected_Product->description : ''}}</p>
                                <div class="form-inline">
                                    <button type="submit"
                                        wire:click.prevent="$emit('scan-code', {{$selected_Product ? $selected_Product->barcode : ''}})"
                                        class="btn btn-dark mb-2">Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
