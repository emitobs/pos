<div>
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title text-dark">
                        <b>Reportes</b>
                    </h4>
                    <ul class="tabs tab-pills">
                        <li>
                            <div class="n-chk">
                                <label class="new-control new-checkbox new-checkbox-rounded">
                                    <input wire:model='groupBy' type="radio" class="new-control-input" value="day"
                                        name="reportBy" wire:change='resetUI'>
                                    <span class="new-control-indicator"></span>Día
                                </label>
                                <label class="new-control new-checkbox new-checkbox-rounded">
                                    <input wire:model='groupBy' type="radio" class="new-control-input" value="month"
                                        name="reportBy" wire:change='resetUI'>
                                    <span class="new-control-indicator"></span>Mes
                                </label>
                                <label class="new-control new-checkbox new-checkbox-rounded">
                                    <input wire:model='groupBy' type="radio" class="new-control-input" value="range"
                                        name="reportBy" wire:change='resetUI'>
                                    <span class="new-control-indicator"></span>Rango de fechas
                                </label>
                                <label class="new-control new-checkbox new-checkbox-rounded">
                                    <input wire:model='groupBy' type="radio" class="new-control-input" value="year"
                                        name="reportBy" wire:change='resetUI'>
                                    <span class="new-control-indicator"></span>Año
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="widget-content">
                    <div class="inputs-groups">
                        @if($groupBy == 'day')
                        <div class="input-group mb-5" id="dayGroup">
                            <input wire:model='day' type="date" class="form-control" aria-describedby="basic-addon2">
                        </div>
                        @endif
                        @if($groupBy == 'month')
                        <div class="input-group mb-5" id="monthGroup">
                            <input wire:model='month' type="month" class="form-control" aria-describedby="basic-addon2">
                        </div>
                        @endif
                        @if($groupBy == 'range')
                        <div class="row">
                            <div class="input-group mb-5 col-6" id="monthGroup">
                                <input wire:model='start_date' type="date" class="form-control"
                                    aria-describedby="basic-addon2">
                            </div>
                            <div class="input-group mb-5 col-6" id="monthGroup">
                                <input wire:model='end_date' type="date" class="form-control"
                                    aria-describedby="basic-addon2">
                            </div>
                        </div>
                        @endif
                        @if($groupBy == 'year')
                        <div class="input-group mb-5" id="yearGroup">
                            <select wire:model='year' class="form-control">
                                <option value="">Seleccione año a consultar</option>
                                @foreach ($yearsWithActivity as $xyear)
                                <option value="{{$xyear}}">{{$xyear}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        @if($totals && count($totals) > 0)
                        {{-- Payments in Reports --}}

                        <div class="paymentsIn_reports col-12">
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="mb-3 text-white">Cobros totales  <span class="text-success">${{number_format($this->totals->sum('total_amount'), 2, '.', '')  }}</span>
                                        </h5>
                                        <table class="table payrollModalInfoContainerTextTableColor">
                                            <tr>
                                                <th class=" text-white">Metodo de pago</th>
                                                <th class=" text-white">Cobros</th>
                                                <th class=" text-white">Recaudo</th>
                                            </tr>
                                            <tbody>
                                                @foreach ($this->totals as $total)
                                                <tr>
                                                    <td class=" text-white">{{$total->payment_method_name}}</td>
                                                    <td class=" text-white">{{$total->total_count}}</td>
                                                    <td class=" text-white">$ {{$total->total_amount}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td class="text-white"><b>Totales:</b></td>
                                                    <td class="text-white "><b>{{$this->totals->sum('total_count')}}</b> </td>
                                                    <td class="text-white"><b>$ {{number_format($this->totals->sum('total_amount'), 2, '.', '')  }}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- End Payments in Reports --}}

                        {{-- Debt in Reports --}}
                        @if($countDebt && $totalDebt)
                        <div class="paymentsIn_reports col-12">
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="mb-3 text-white">Total A Cuenta  <span class="text-success">${{$totalDebt }}</span>
                                        </h5>
                                        <table class="table payrollModalInfoContainerTextTableColor">
                                            <tr>
                                                <th class=" text-white"></th>
                                                <th class=" text-white">Ventas</th>
                                                <th class=" text-white">Por Cobrar</th>
                                            </tr>
                                            <tbody>
                                                <tr>
                                                    <td class=" text-white">Deuda a cuenta</td>
                                                    <td class=" text-white">{{$countDebt}}</td>
                                                    <td class="text-white"><b>$ {{$totalDebt }}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- End Debt in Reports --}}

                        {{-- Deliveries Reports --}}
                        @if($delivery_totals && count($delivery_totals) > 0)
                        <div class="deliveries_reports col-12">
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="mb-3 text-white">Cobros por delivery
                                        </h5>
                                        <div class="row justify-content-between">
                                            @foreach($delivery_totals->groupBy('delivery_name') as $deliveryName =>
                                            $deliveryTotals)
                                            <div class="card component-card_1 mb-2">
                                                <div class="card-body">
                                                    <h5 class="card-title"> <b>{{ $deliveryName }}</b></h5>
                                                    <table class="table">
                                                        <tr>
                                                            <th class=" text-white">Metodo de pago</th>
                                                            <th class=" text-white">Cobros</th>
                                                            <th class=" text-white">Recaudo</th>
                                                        </tr>
                                                        <tbody>
                                                            @foreach ($deliveryTotals as $deliveryTotal)
                                                            <tr>
                                                                <td class=" text-white">{{
                                                                    $deliveryTotal->payment_method_name }}
                                                                </td>
                                                                <td class=" text-white">{{$deliveryTotal->total_count}}
                                                                </td>
                                                                <td class=" text-white">$
                                                                    {{$deliveryTotal->total_amount}}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td class="text-white"><b>Totales:</b></td>
                                                                <td class="text-white "><b>{{$deliveryTotals->sum('total_count')}}</b> </td>
                                                                <td class="text-white"><b>$ {{number_format($deliveryTotals->sum('total_amount'), 2, '.', '')  }}</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- END Deliveries Reports --}}


                        @if($products_sold && count($products_sold) > 0)
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Que se vendió?</h5>
                                    <table class="table">
                                        <tr>
                                            <th class="text-white">Producto</th>
                                            <th class="text-white">Cantidad</th>
                                        </tr>
                                        <tbody>
                                            @foreach ($products_sold as $product)
                                            <tr>
                                                <td class="text-white">{{$product->product_name}}</td>
                                                <td class="text-white">{{$product->total_quantity}}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td class="text-white"><b>Totales:</b></td>
                                                <td class="text-white"><b>{{$products_sold->sum('total_quantity')}}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- TABLA GENERICA FIN --}}

                        {{-- TABLA GENERICA INICIO // INFORMACION --}}
                        <div class="col-6">
                            <div class="card ">
                                <div class="card-bodyshadow-lg">
                                    <h5 class="mb-3">Información</h5>
                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="card payrollModalInfoContainerbodyColor">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-3 payrollModalInfoContainerTextColor"></h5>
                                                    <table class="table payrollModalInfoContainerTextTableColor">
                                                        <tr>
                                                            <td>Total de ventas: {{$total_sales}}</td>
                                                            <td>Total recaudado: {{$total_cash}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- TABLA GENERICA FIN --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
