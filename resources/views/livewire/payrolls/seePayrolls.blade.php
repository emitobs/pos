<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header bgPayrollModalHeaderColor">
                <h5 class="modal-title textPayrollModalHeaderTextColor">
                    Planilla Nº {{$payroll_selected->id}} | Detalles
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body bgPayrollModalBodyColor">
                <div class="row mb-3">
                    <div class="col-12 ">
                        <div class="card bgPayrollModalContainerColor">
                            <div class="card-body bgPayrollModalInfoContainerColor">
                                <h5 class="card-title">Fecha: {{date_format($payroll_selected->created_at,
                                    'd-m-Y')}}</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div
                                                                class="card-body bgPayrollModalInfoContainerColor shadow-lg">
                                                                <h5
                                                                    class="card-title mb-3 payrollModalInfoContainerTextColor">
                                                                    Recaudos totales</h5>
                                                                <table
                                                                    class="table payrollModalInfoContainerTextTableColor">
                                                                    <tr>
                                                                        <th>Metodo de pago</th>
                                                                        <th>Pedidos</th>
                                                                        <th>Recaudo</th>
                                                                    </tr>
                                                                    @foreach ($this->totals as $total)
                                                                    <tr>
                                                                        <td>{{$total->name}}</td>
                                                                        <td>{{$total->NumberOfPayments}}</td>
                                                                        <td>$ {{$total->Total}}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div
                                                                class="card-body bgPayrollModalInfoContainerColor shadow-lg">
                                                                <h5
                                                                    class="card-title mb-3 payrollModalInfoContainerTextColor">
                                                                    Entregas {{$orders_delivered}}</h5>
                                                                <table
                                                                    class="table payrollModalInfoContainerTextTableColor">
                                                                    <tr>
                                                                        <th>Delivery</th>
                                                                        <th>Cantidad</th>
                                                                    </tr>
                                                                    @foreach ($reportesDeDeliveries as $reporteDelivery)
                                                                    <tr>
                                                                        <td>{{$reporteDelivery['delivery_name']}}</td>
                                                                        <td>{{$reporteDelivery['orders_delivered']}}
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="mb-3 payrollModalInfoContainerTextColor">Cobros {{$chargers}}
                                                </h5>
                                                <div class="row">
                                                    @foreach ($reportesDeDeliveries as $reporteDelivery)

                                                    <div class="col-12 col-md-6">
                                                        <div class="card">
                                                            <div
                                                                class="card-body bgPayrollModalInfoContainerColor shadow-lg">
                                                                <h5
                                                                    class="card-title mb-3 payrollModalInfoContainerTextColor">
                                                                    {{$reporteDelivery['delivery_name']}}
                                                                </h5>
                                                                <table
                                                                    class="table payrollModalInfoContainerTextTableColor">
                                                                    <tr>
                                                                        <th>Metodo de pago</th>
                                                                        <th>Pedidos</th>
                                                                        <th>Recaudo</th>
                                                                    </tr>
                                                                    @foreach ($reporteDelivery['reportes'] as $item)
                                                                    <tr>
                                                                        <td>{{$item['name']}}</td>
                                                                        <td>{{$item['chargers']}}</td>
                                                                        <td>${{$item['total']}}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
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
</div>
