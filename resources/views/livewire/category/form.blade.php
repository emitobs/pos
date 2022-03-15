@include('common.modalHead')


<div class="row">
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit"></span>
                </span>
            </div>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Nombre categoria">
        </div>
        @error('name') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <div class="col-sm-12 mt-3">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image"
                accept="image/x-png, image/gif, image/jpeg">
            <label class="custom-file-label">Imagen {{$image}}</label>
        </div>
        @error('image') <span class="text-danger er">{{$message}}</span>@enderror
        <div class="form-inline">
            <div class="n-chk form-check form-check-inline">
                <label class="new-control new-checkbox checkbox-primary">
                    <input type="checkbox" class="new-control-input" wire:model="desactivated" @if($desactivated)cheked
                        @endif>
                    <span class="new-control-indicator"></span>Desactivado
                </label>
            </div>
        </div>
    </div>
</div>

@include('common.modalFooter')
