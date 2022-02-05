@include('common.modalHead')


<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Nombre">
            @error('name') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
        <div class="form-group">
            <input type="text" wire:model.lazy="telephone" class="form-control" placeholder="Teléfono">
            @error('telephone') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
        <div class="form-group">
            <input type="text" wire:model.lazy="address" class="form-control" placeholder="Dirección">
            @error('address') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>
</div>

@include('common.modalFooter')
