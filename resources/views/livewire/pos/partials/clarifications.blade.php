<div>
    <div class="form-group mb-4">
        <input type="text" class="form-control" wire:model="client" id="rClientName" placeholder="Cliente *" required>
        @error('client') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <div class="form-group mb-4">
        <input type="text" class="form-control" wire:model="address" id="rAdress" placeholder="Dirección *" required>
        @error('address') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <div class="form-group mb-4">
        <input type="time" class="form-control" wire:model="deliveryTime" id="rDeliveryTime"
            placeholder="Hora de entrega" required>
        @error('deliveryTime') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <div class="input-group mb-4">
        <textarea wire:model="clarifications" class="form-control" placeholder="Aclaraciones"
            aria-label="Aclaraciones"></textarea>
    </div>
</div>
