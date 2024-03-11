<div>
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <b>{{$componentName}} | {{$status_selected}}</b>
                    </h4>

                    <div class="row">
                        <div class="n-chk">
                            <label class="new-control new-radio radio-primary">
                                <input type="radio" wire:model='status_selected' class="new-control-input"
                                    name="status_selected" value="Todos" checked>
                                <span class="new-control-indicator"></span>Todos
                            </label>
                        </div>
                        <div class="n-chk">
                            <label class="new-control new-radio radio-default">
                                <input wire:model="status_selected" name="status_selected" type="radio"
                                    value="En espera" class="new-control-input" />
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
                        <div class="n-chk">
                            <label class="new-control new-radio radio-info">
                                <input wire:model="status_selected" name="status_selected" type="radio"
                                    value="Esperando delivery" class="new-control-input" />
                                <span class="new-control-indicator"></span>Esperando delivery
                            </label>
                        </div>
                        <div class="n-chk">
                            <label class="new-control new-radio radio-success">
                                <input wire:model="status_selected" name="status_selected" type="radio"
                                    value="Entregado" class="new-control-input" />
                                <span class="new-control-indicator"></span>Entregado
                            </label>
                        </div>
                    </div>

                </div>
                @include('common.searchbox')

                <div class="widget-content">
                    @if($orders != null && $orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered tableBodyColor mt-1">
                            <thead class="tableHeadColor">
                                <tr>
                                    <th class="table-th tableHeadTextColor">Nº</th>
                                    <th class="table-th tableHeadTextColor text-center">Cliente</th>
                                    <th class="table-th tableHeadTextColor text-center">Dirección</th>
                                    <th class="table-th tableHeadTextColor text-center">Estado</th>
                                    <th class="table-th tableHeadTextColor text-center">Total</th>
                                    <th class="table-th tableHeadTextColor text-center">Hora de llegada</th>
                                    <th class="table-th tableHeadTextColor text-center">Hora de entrega</th>
                                    <th class="table-th tableHeadTextColor text-center">Delivery</th>
                                    <th class="table-th tableHeadTextColor text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)

                                <tr class="">
                                    <td class="text-center">
                                        <p class="tableTextColor">{{use_order_id_daily() ? $order->dayid : $order->id}}
                                        </p>
                                    </td>
                                    <td class="text-center tableTextColor">
                                        <p class="tableTextColor">{{$order->client->name}}</p>
                                    </td>
                                    <td class="text-center tableTextColor">
                                        <p class="tableTextColor">{{$order->address}}</p>
                                    </td>
                                    @if($selectedPayroll == null || $selectedPayroll == 0)
                                    <td class="text-center">

                                        @include('livewire.sale-status')
                                    </td>
                                    @else
                                    <td class="@if($order->status == 'En espera') bg-dark @endif
                                        @if($order->status == 'En preparación') bg-warning @endif
                                        @if($order->status == 'Esperando delivery') bg-info @endif
                                        @if($order->status == 'Entregado') bg-success @endif
                                        @if($order->status == 'Cancelado') bg-danger @endif
                                        text-center text-white">{{$order->status}}</td>
                                    @endif
                                    </td>
                                    <td class="text-center">
                                        <p class="tableTextColor">$ {{$order->total}}</p>
                                    </td>
                                    <td class="text-center tableTextColor">
                                        <p class="tableTextColor">{{date('G:i', strtotime($order->created_at))}}</p>
                                    </td>
                                    <td class="text-center tableTextColor">
                                        <p class="tableTextColor">{{date('G:i', strtotime($order->deliveryTime))}}</p>
                                    </td>
                                    <td class="text-center tableTextColor">
                                        <p class="tableTextColor">@if($order->delivery != null)
                                            {{$order->delivery->name}} @else Sin entregar @endif</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click.prevent="seeDetail({{$order->id}})"
                                            class="btn btn-info tabmenu"><i class="far fa-eye"></i> Ver</a>
                                        @if($selectedPayroll == null || $selectedPayroll == 0)
                                        @if($order->status != 'Cancelado') |
                                        <a href="javascript:void(0)" wire:click.prevent="reprint({{$order->id}})"
                                            class="btn btn-info tabmenu"><i class="fas fa-print"></i> Re-imprimir</a>
                                        |
                                        <a class="btn btn-secondary"
                                            href="{{ route('PosController', ['saleId'=> $order->id]) }}">Editar</a>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$orders->links()}}
                    </div>
                    @else
                    <div class="row">
                        <div class="col-12">
                            <p>No se encuentran pedidos.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @include('livewire.orders.seeDetail')
        @include('livewire.orders.selectDelivery')
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function()
    {
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('show-selectDelivery', msg => {
            $('#theModalSelectDelivery').modal('show');
        });
        window.livewire.on('hide-selectDelivery', msg => {
            $('#theModalSelectDelivery').modal('hide');
        });
        window.livewire.on('notify', Msg => {
            noty(Msg);
        });
        window.livewire.on('error', Msg => {
            noty(Msg,2);
        });

        window.livewire.on('print-ticket', saleId => {
            window.open("print://" + saleId, '_self');
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
                    window.livewire.emit('confirmDelivery',idDelivery,idSale);
                    swal.close();
                }
            });
        }

        function selectedDelivery( sale_id,delivery_id){
            swal({
                title : 'CONFIRMAR',
                text : '¿Se lo lleva ' + delivery_id + ' al pedido?',
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
</div>
