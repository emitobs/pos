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

                                        <td class="text-center">{{$detail->quantity}}</td>
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
                <button type="button" class="btn btn-dark close-btn text-info" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endif
