<div>
    <label>Seleccione color para {{$element}}</label>
    <input id="{{$element}}" type="color" wire:model="color" wire:change="updateColor($event.target.value)">
</div>
