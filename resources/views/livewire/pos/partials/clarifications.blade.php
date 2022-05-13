<div>
    <div class="form-group mb-4">
        <input type="number" class="form-control" wire:model="telephone" id="rtelephone" placeholder="Teléfono" required>
        @error('telephone') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <div class="form-group mb-4">
        <input type="text" class="form-control" wire:model="client" id="rClientName" placeholder="Cliente" required>
        @error('client') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <div class="form-group mb-4">
        <input type="text" class="form-control" wire:model="address" id="rAdress" placeholder="Dirección" required>
        @error('address') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <div class="form-group mb-4">
        <input type="time" class="form-control" wire:model="deliveryTime" id="rDeliveryTime"
            placeholder="Hora de entrega" required>
        @error('deliveryTime') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    @if (use_beepers())
    <div class="form-group mb-4">
        <select class="form-control" wire:model.lazy='beeper'>
            <option value="default">Selecciona beeper</option>
            @foreach ($beepers as $beeper )
            <option value="{{$beeper->id}}">{{$beeper->id}}</option>
            @endforeach
        </select>
        @error('bipper') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    @endif

    <div class="input-group mb-4">
        <textarea wire:model="clarifications" class="form-control" placeholder="Aclaraciones"
            aria-label="Aclaraciones"></textarea>
    </div>
</div>
