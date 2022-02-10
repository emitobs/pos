<div wire:ignore.self class="modal fade" id="userForm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Nuevo usuario</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                     <form class="col-sm-12">
                        <div class="form-group">
                            <input type="text" class="form-control" id="txtName" wire:model='name'
                                placeholder="Nombre completo">
                            @error('name')
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
                            <input type="password" class="form-control" id="txtPassword" wire:model='password'
                                placeholder="Contraseña">
                            @error('password')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="txtRePassword"
                                wire:model='password_confirmation' placeholder="Repetir contraseña">
                            @error('password_confirmation')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select class="form-control" wire:model.lazy='role'>
                                <option value="default">Rol...</option>
                                @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        </form>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="saveUser()" class="btn btn-primary">Registrar</button>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
