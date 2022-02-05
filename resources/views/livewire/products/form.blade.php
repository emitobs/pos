@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ej: Pepsi">
            @error('name') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Código</label>
            <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="Ej: 12345678">
            @error('barcode') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Costo</label>
            <input type="text" data-type='currency' wire:model.lazy="cost" class="form-control" placeholder="Ej: 25.00">
            @error('cost') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Precio</label>
            <input type="text" data-type='currency' wire:model.lazy="price" class="form-control"
                placeholder="Ej: 25.00">
            @error('price') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Stock</label>
            <input type="number" wire:model.lazy="stock" class="form-control" placeholder="Ej: 25">
            @error('stock') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Alertas / Inv. Minimo</label>
            <input type="text" wire:model.lazy="alerts" class="form-control" placeholder="Ej: 10">
            @error('alerts') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Categoría</label>
            <select wire:model.lazy='categoryid' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            @error('categoryid') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Unidad de venta</label>
            <select wire:model.lazy='unit_sale' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($units_sale as $c_unit_sale)
                <option value="{{$c_unit_sale->id}}">{{$c_unit_sale->unit}}</option>
                @endforeach
            </select>
            @error('categoryid') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-8 mb-5">
        <div class="form-group">
            <div class="col-sm-2">Descripción</div>
            <div class="col-sm-10">
                <div class="form-inline">
                    <textarea name="" id="" cols="30" rows="5" class="form-control" wire:model="description"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-8">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image"
                accept="image/x-png, image/gif, image/jpeg">
            <label class="custom-file-label">Imagen {{$image}}</label>
        </div>
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
