<div class="row mb-3">
    <div class="col-12">
        <div class="connect-sorting-content">
            <div class="card simple-normal-title-task ui-sorteable-handle">
                <div class="card-body">
                    <div class="task-header">
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group mb-2" wire:ignore>
                                    <select id="selected_product" wire:model='select_product' class="form-control">
                                        
                                </div>
                                <div class="form-group mt-2">
                                    <input type="number" id="quantity" wire:model="quantity" placeholder="Cantidad"
                                        class="form-control mt-2">
                                </div>
                                <div class="form-group">
                                    <textarea wire:model='detail' name="" id="" cols="30" rows="4" class="form-control"
                                        placeholder="Detalle"></textarea>
                                </div>
                                <input wire:click="ScanCode" type="button" class="btn btn-primary"
                                    value="Agregar al pedido">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
