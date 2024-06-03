@include('common.modalHead')


<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <select name="" id="" class="form-control" wire:model='clientType'>
                <option value="default">Seleccione tipo de cliente</option>
                <option value="natural">Consumidor final</option>
                <option value="legal">Empresa</option>
            </select>
        </div>

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

        <div class="form-group">
            <input type="text" wire:model.lazy="ci" class="form-control" placeholder="Ci">
            @error('ci') <span class="text-danger er">{{$message}}</span>@enderror
        </div>

        @if ($clientType == "legal")
        <div class="form-group">
            <input type="text" wire:model.lazy="rut" class="form-control" placeholder="Rut">
            @error('rut') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
        <div class="form-group">
            <input type="text" wire:model.lazy="socialReasoning" class="form-control" placeholder="Razón social">
            @error('socialReasoning') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
        @endif

        <div class="form-group">
            <input type="text" wire:model.lazy="location" class="form-control" placeholder="Localidad">
            @error('location') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
        <div class="form-group">
            <input type="text" wire:model.lazy="mail" class="form-control" placeholder="email">
            @error('mail') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
        <div class="custom-control custom-checkbox mb-3">
            <input type="checkbox" class="custom-control-input" id="checkAllowCredit" wire:model='allowCredit'>
            <label class="custom-control-label" for="checkAllowCredit">Permitir crédito</label>
        </div>
        @if($allowCredit == true)
        <div class="form-group">
            <input type="number" wire:model.lazy="creditLimit" class="form-control" placeholder="Limite de credito">
            @error('creditLimit') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
        @endif

    </div>
</div>

@include('common.modalFooter')
