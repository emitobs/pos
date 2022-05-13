<div>
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <b>Pedidos</b>
                    </h4>
                </div>
                <div class="widget-content">
                    <div class="row">
                        @foreach ($data as $payroll)
                        @foreach ($payroll->sales->where('status', "!=", 'Cancelado')->where('status', "!=",
                        'Entregado') as $order)
                        <div class="order col-2 text-center" wire:click.prevent="seeOrder({{$order->id}})">
                            <p>Pedido# {{$order->id}}</p>
                            <p>Beeper# {{$order->beeper}}</p>
                            <br>
                        </div>
                        @endforeach
                        @endforeach
                    </div>


                </div>
            </div>
        </div>

    </div>
    @if($sale)
    <div class="modal fade" id="theModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white">
                        <b>Pedido Nº {{$sale->id}}</b> | Detalles
                    </h5>
                    <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table mb-4">
                                    <thead>
                                        <tr>

                                            <th class="text-center">Cantidad</th>
                                            <th>Producto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sale->details as $index => $detail)
                                        <tr>
                                            <td class="text-center">
                                                @if($detail->product->unit_sale == 1)
                                                {{intval($detail->quantity)}} u
                                                @else
                                                @if($detail->quantity > 0.9)
                                                {{$detail->quantity}} Kg
                                                @else
                                                {{$detail->quantity}} gr
                                                @endif
                                                @endif</td>
                                            <td class="text-primary">{{($detail->product->name)}}</td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="infobox-1">
                                <h5 class="info-heading">Aclaraciones</h5>
                                <p class="info-text">{{$sale->clarifications}}.</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" wire:click.prevent="deliver_order({{$sale->id}})"
                        class="btn btn-dark mb-2">Entregar</button>
                    <button type="button" class="btn btn-dark close-btn text-info" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });

        window.livewire.on('order_delivered', msg => {
            noty('Orden entregada');
            $('#theModal').modal('hide');
        });
        });
    </script>

</div>
