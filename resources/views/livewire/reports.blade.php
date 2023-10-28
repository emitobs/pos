<div>
    <link href="{{asset('plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <b>Totales</b>
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
                            <input wire:model='month' type="date" class="form-control" aria-describedby="basic-addon2">
                        </div>
                        <div class="input-group mb-5 col-6" id="monthGroup">
                            <input wire:model='month' type="date" class="form-control" aria-describedby="basic-addon2">
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
                    @if($year != '' || $month != '' || $day != '')
                    <div class="row justify-space-between">
                        {{-- TABLA GENERICA INICIO // RECAUDOS TOTALES --}}
                        <div class="col-12">
                            <div class="card ">
                                <div class="card-body bgPayrollModalInfoContainerColor shadow-lg">
                                    <h5 class="mb-3 payrollModalInfoContainerTextColor">Recaudos totales</h5>
                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="card payrollModalInfoContainerbodyColor">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-3 payrollModalInfoContainerTextColor"></h5>
                                                    <table class="table payrollModalInfoContainerTextTableColor">
                                                        <tr>
                                                            <th>Metodo de pago</th>
                                                            <th>Pedidos</th>
                                                            <th>Recaudo</th>
                                                        </tr>
                                                        <tbody>
                                                            @foreach ($this->totals as $total)
                                                            <tr>
                                                                <td>{{$total->name}}</td>
                                                                <td>{{$total->PaymentCount}}</td>
                                                                <td>$ {{$total->Total}}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- TABLA GENERICA FIN --}}

                        {{-- TABLA GENERICA INICIO  // Que se vendió?--}}
                        <div class="col-6">
                            <div class="card ">
                                <div class="card-body bgPayrollModalInfoContainerColor shadow-lg">
                                    <h5 class="mb-3 payrollModalInfoContainerTextColor">Que se vendió?</h5>
                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="card payrollModalInfoContainerbodyColor">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-3 payrollModalInfoContainerTextColor"></h5>
                                                    <table class="table payrollModalInfoContainerTextTableColor">
                                                        <tr>
                                                            <th>Metodo de pago</th>
                                                            <th>Pedidos</th>
                                                            <th>Recaudo</th>
                                                        </tr>
                                                        <tbody>
                                                            @foreach ($this->totals as $total)
                                                            <tr>
                                                                <td>{{$total->name}}</td>
                                                                <td>{{$total->PaymentCount}}</td>
                                                                <td>$ {{$total->Total}}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- TABLA GENERICA FIN --}}

                        {{-- TABLA GENERICA INICIO // INFORMACION --}}
                        <div class="col-6">
                            <div class="card ">
                                <div class="card-body bgPayrollModalInfoContainerColor shadow-lg">
                                    <h5 class="mb-3 payrollModalInfoContainerTextColor">Información</h5>
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
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('plugins/apex/apexcharts.min.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('loadCharts', data => {
                var donutChart = {
                chart: {
                    height: 350,
                    type: 'donut',
                    toolbar: {
                        show: true,
                    }
                },
                series: @this.series,
                labels: @this.labels,
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
            }

            var donut = new ApexCharts(
                document.querySelector("#donut-chart"),
                donutChart
            );

            donut.render();

            var donutByCategories = {
                chart: {
                    height: 350,
                    type: 'donut',
                    toolbar: {
                        show: false,
                    }
                },
                series: @this.seriesByCategories,
                labels: @this.labelsByCategories,
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            }

            var donutByCategories = new ApexCharts(
                document.querySelector("#donut-chart-byCategories"),
                donutByCategories
            );

            donutByCategories.render();
        });

    });
    </script>
</div>
