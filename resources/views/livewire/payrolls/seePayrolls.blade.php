@if($payroll_selected)
<div class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Planilla Nº {{$payroll_selected->id}}</b> | Detalles
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-12">
                        <div class="widget widget-account-invoice-one">
                            <div class="widget-content">
                                <div class="invoice-box">
                                    <div class="acc-total-info">
                                        <h5>Fecha</h5>
                                        <p class="acc-amount">{{date_format($payroll_selected->created_at, 'd-m-Y')}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="widget widget-account-invoice-one">

                                        <div class="widget-heading">
                                            <h5 class="">Recaudo</h5>
                                        </div>

                                        <div class="widget-content">
                                            <div class="invoice-box">

                                                <div class="acc-total-info">
                                                    <h5>TOTAL</h5>
                                                    <p class="acc-amount">${{$payroll_selected->total}}</p>
                                                </div>

                                                <div class="inv-detail">
                                                    <div class="info-detail-1">
                                                        <p>Total a cuenta:</p>
                                                        <p>$ {{$totalDebts}}</p>
                                                    </div>
                                                    <div class="info-detail-3 info-sub">
                                                        <div class="info-detail">
                                                            <p>Total pago con Handy</p>
                                                            <p>$ {{$totalHandy}}</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="widget widget-account-invoice-one">
                                        <div class="widget-content">
                                            <div class="invoice-box">
                                                <div class="acc-total-info">
                                                    <h5>PEDIDOS</h5>
                                                    <p class="acc-amount">{{$totalSales}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="widget widget-account-invoice-one mt-3">
                                        <div class="widget-content">
                                            <div class="invoice-box">
                                                <div class="acc-total-info">
                                                    <h5>Deliverys</h5>
                                                    <p class="acc-amount">{{$payroll_selected->totalSales}}</p>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered mb-4">
                                                            <thead>
                                                                <tr>
                                                                    <th>Delivery</th>
                                                                    <th>Pedidos</th>
                                                                    <th>Entregó</th>
                                                                    <th>Debe</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($deliveriesWorked as $delivery)
                                                                <tr>
                                                                    <td>{{$delivery->deliveryName}}</td>
                                                                    <td>{{$delivery->totalDeliveries}}</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>{{$delivery->totalRaised}}</td>
                                                                </tr>
                                                                @endforeach
                                                                <tr>
                                                                    <th>Total</th>
                                                                    <th>{{$deliveriesWorked->sum('totalDeliveries')}}
                                                                    </th>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <th>${{$deliveriesWorked->sum('totalRaised')}}</th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
