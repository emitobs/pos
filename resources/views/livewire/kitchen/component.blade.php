<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} @if($orders != null && $orders->count()) | {{$status_selected}} @endif</b>
                </h4>
                <div class="row">
                    <div class="n-chk">
                        <label class="new-control new-radio radio-default">
                            <input wire:model="status_selected" name="status_selected" type="radio" value="En espera"
                                class="new-control-input" />
                            <span class="new-control-indicator"></span>En espera
                        </label>
                    </div>
                    <div class="n-chk">
                        <label class="new-control new-radio radio-warning">
                            <input wire:model="status_selected" name="status_selected" type="radio"
                                value="En preparación" class="new-control-input" />
                            <span class="new-control-indicator"></span>En preparación
                        </label>
                    </div>
                </div>
            </div>
            @if($orders != null && $orders->count())
            @include('common.searchbox')
            @endif
            <div class="widget-content">
                @if($orders != null && $orders->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-striped  mt-1">
                        <thead class="text-white" style="background: #3b3f5c;">
                            <tr>
                                <th class="table-th text-white">Nº</th>
                                <th class="table-th text-white text-center">Estado</th>
                                <th class="table-th text-white text-center">Hora de llegada</th>
                                <th class="table-th text-white text-center">Hora de entrega</th>
                                <th class="table-th text-white text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td class="@if($order->status == 'En espera') bg-dark @endif
                                    @if($order->status == 'En preparación') bg-warning @endif
                                    @if($order->status == 'Esperando delivery') bg-info @endif
                                    @if($order->status == 'Entregado') bg-success @endif
                                    text-center text-white">{{$order->status}}</td>
                                <td class="text-center">{{date('G:i:s', strtotime($order->created_at))}}</td>
                                <td class="text-center">{{$order->deliveryTime}}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click.prevent="seeDetail({{$order->id}})"
                                        class="btn btn-info tabmenu"><i class="far fa-eye"></i> Ver</a> |
                                    @if($order->status == 'En espera')
                                    <a href="javascript:void(0)" wire:click.prevent="inTheKitchen({{$order->id}})"
                                        class="btn btn-warning mb-2 tabmenu">En cocina</a> |
                                    @endif
                                    @if($order->status == 'En preparación')
                                    <a href="javascript:void(0)" wire:click.prevent="readyToDeliver({{$order->id}})"
                                        class="btn btn-info mb-2 tabmenu">Para entregar</a> |
                                    @endif
                                    @if($order->status == 'Esperando delivery')
                                    <a href="javascript:void(0)" wire:click.prevent="delivered({{$order->id}})"
                                        class="btn btn-success mb-2 tabmenu">Entregado</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$orders->links()}}
                </div>
                @else
                No se encuentras pedidos,
                @endif
            </div>
        </div>
    </div>
    @include('livewire.kitchen.seeDetail')
</div>



<script>
    document.addEventListener('DOMContentLoaded', function()
    {
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('notify', Msg => {
            noty(Msg);
        });
    });


        function Confirm(id, products){

            if(products > 0){
                swal('NO SE PUEDE ELIMINAR CATEGORIA, POSEE PRODUCTOS')
            }

            swal({
                title : 'CONFIRMAR',
                text : '¿Confirmas eliminar el registro?',
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cerrar',
                cancelButtonColor: '#fff',
                confirmButtonColor: '#3b3f5c',
                confirmButtonText: 'Aceptar'
            }).then(function(result){
                if(result.value){
                    window.livewire.emit('deleteRow',id);
                    swal.close();
                }
            });
        }
</script>
