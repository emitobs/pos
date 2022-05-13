<div wire:ignore.self class="modal fade" id="select_modal_attendant" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    Mesa {{$table_selected->id}}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="txt_attendant">Encargad@</label>
                            <input type="text" class="form-control" id="txt_attendant" wire:model="attendant">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal">Cerrar</button>
                <button type="button" wire:click.prevent="init_service()" class="btn btn-primary"
                    data-dismiss="modal">Iniciar</button>
            </div>
        </div>
    </div>
</div>
