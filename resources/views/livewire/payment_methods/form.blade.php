@include('common.modalHead')


<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Nombre método de pago">
            @error('name') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
        <div class="form-inline">
            <div class="n-chk form-check form-check-inline">
                <label class="new-control new-checkbox checkbox-primary">
                    <input type="checkbox" class="new-control-input" wire:model="disabled" @if($disabled)cheked @endif>
                    <span class="new-control-indicator"></span>Desactivado
                </label>
            </div>
        </div>
    </div>
</div>

@include('common.modalFooter')
