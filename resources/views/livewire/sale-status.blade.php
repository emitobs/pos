<div>
    @if($order->status == 'En espera') <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        En espera <i class="fas fa-angle-down ml-3"></i>
    </button>
    @endif
    @if($order->status == 'En preparación') <button type="button" class="btn btn-warning dropdown-toggle"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        En cocina <i class="fas fa-angle-down ml-3"></i>
    </button>
    @endif
    @if($order->status == 'Esperando delivery') <button type="button" class="btn btn-info dropdown-toggle"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Esperando delivery <i class="fas fa-angle-down ml-3"></i>
    </button>
    @endif
    @if($order->status == 'Entregado') <button type="button" class="btn btn-success dropdown-toggle"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Entregado <i class="fas fa-angle-down ml-3"></i>
    </button>
    @endif
    @if($order->status == 'Cancelado') <button type="button" class="btn btn-danger dropdown-toggle"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Cancelado <i class="fas fa-angle-down ml-3"></i>
    </button>
    @endif
    <div class="dropdown-menu">
        <a class="dropdown-item text-dark" href="javascript:void(0)" wire:click.prevent="onHold({{$order->id}})">En
            espera</a>
        <a class="dropdown-item text-warning" href="javascript:void(0)" wire:click.prevent="inTheKitchen({{$order->id}})">En
            cocina</a>
        <a class="dropdown-item text-info" href="javascript:void(0)"
            wire:click.prevent="readyToDeliver({{$order->id}})">Preparado</a>
        <a class="dropdown-item text-success" href="javascript:void(0)"
            wire:click.prevent="selectDelivery({{$order->id}})">Entregar</a>
        <a class="dropdown-item text-danger" href="javascript:void(0)"
            wire:click.prevent="cancel({{$order->id}})">Cancelar</a>
    </div>
</div>
