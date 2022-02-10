<div wire:ignore.self class="modal fade" id="payrollForm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Apertura de caja</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <select class="form-control" wire:model='cashier'>
                                <option value="default">Seleccione cajero...</option>
                                @foreach ($cashiers as $xcashier )
                                <option value="{{$xcashier->id}}">{{$xcashier->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" wire:model='zone'>
                                <option value="default">Seleccione zona...</option>
                                @foreach ($zones as $xzone )
                                <option value="{{$xzone->id}}">{{$xzone->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">$</div>
                                </div>
                                <input wire:model='initialCash' type="number" class="form-control"
                                    placeholder="ingresa con">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="initPayroll()" class="btn btn-primary"
                    data-dismiss="modal">Iniciar</button>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
