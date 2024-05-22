<div class="row mb-3">
    <div class="col-12">
        <div class="connect-sorting-content">
            <div class="card simple-normal-title-task ui-sorteable-handle">
                <div class="card-body">
                    <div class="col-12">
                        <div class="form-row d-flex align-items-center">
                            <div class="col-md-5" wire:ignore>
                                <select id="selected_product" wire:model='select_product' class="form-control"></select>
                            </div>
                            <!-- asd-->
                            <div class="col-md-3">
                                <input type="number" id="quantity" wire:model="quantity" placeholder="Cantidad"
                                    class="form-control">
                            </div>
                            <!-- asd-->
                            <div class="col-md-4">
                                <input wire:click="ScanCode" type="button" class="btn btn-primary col-12" value="+ al pedido">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
