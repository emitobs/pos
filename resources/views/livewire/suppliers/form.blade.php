<div wire:ignore.self class="modal fade" id="supplierForm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    @if($selected_id > 0)
                    <b>Editar proveedor</b>
                    @else
                    <b>Nuevo proveedor</b>
                    @endif
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="col-sm-12">
                        <div class="form-group">
                            <input type="text" class="form-control" id="txtName" wire:model='name' placeholder="Nombre">
                            @error('name')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="txtRut" wire:model='rut' placeholder="rut">
                            @error('rut')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="txtEmail" wire:model='email'
                                placeholder="Email">
                            @error('email')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="txtTelephone" wire:model='phone'
                                placeholder="Telefono">
                            @error('phone')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="txtAddress" wire:model='address'
                                placeholder="Direccion">
                            @error('address')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="txtContactPerson" wire:model='contactPerson'
                                placeholder="Persona de contacto">
                            @error('contactPerson')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </form>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="saveSuppliers()" class="btn btn-primary">Registrar</button>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
