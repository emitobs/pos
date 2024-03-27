@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6 mb-5">
        <div class="form-group">
            <label>Descripción</label>
            <input type="text" wire:model.lazy="description" class="form-control" placeholder="Ej: Pago a proveedor">
            @error('description') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
            <label>Monto</label>
            <input type="number" wire:model.lazy="amount" class="form-control" placeholder="Ej: 5000">
            @error('amount') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Fecha</label>
            <input type="date" wire:model.lazy="date" class="form-control" placeholder="Ej: 25.00">
            @error('date') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Comprobante</label>
            <input type="file" class="form-control-file" wire:model.lazy="receipt"
                accept="image/x-png, image/gif, image/jpeg">
            @error('receipt') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Caja</label>
            <select class="form-control " id="inputAddressSelect" wire:model="inputAddressSelect">
                <option value="">No caja</option>
                @foreach ($payrolls as $key => $value)
                <option value="{{ $value->id }}">{{ $value->id }}</option>
                @endforeach
            </select>
        </div>
    </div>

</div>

@include('common.modalFooter')
