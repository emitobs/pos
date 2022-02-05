<div>
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
                    <div class="row">
                        <div class="col-6">
                            <div class="card component-card_1">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Grafica de productos vendidos</h5>
                                    <ul class="tabs tab-pills">
                                        <li>
                                            <div class="n-chk">
                                                <label class="new-control new-checkbox new-checkbox-rounded">
                                                    <input wire:model='category_selected' type="radio"
                                                        class="new-control-input" value="all" name="category_selected">
                                                    <span class="new-control-indicator"></span>Todos
                                                </label>
                                                @foreach ($categories as $category )
                                                <label class="new-control new-checkbox new-checkbox-rounded">
                                                    <input wire:model='category_selected' type="radio"
                                                        class="new-control-input" value="{{$category->name}}"
                                                        name="category_selected">
                                                    <span class="new-control-indicator"></span>{{$category->name}}
                                                </label>
                                                @endforeach
                                            </div>
                                        </li>
                                    </ul>

                                    @if($total_sales < 1) <span class="text-danger">{{$msgNoSales}}</span>
                                        @endif

                                        <div id="donut-chart"></div>
                                        <div id="donut-chart-byCategories"></div>

                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card component-card_1">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Información</h5>
                                    <p class="card-text">Total de ventas: {{$total_sales}}</p>
                                    <p class="card-text">Total recaudado: {{$totalCash}}</p>
                                    </p>
                                </div>
                            </div>
                            <div class="card component-card_1 mt-2">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">¿Qué se vendio?</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($resultado_productos as $producto)
                                            <tr>
                                                <td>{{$producto['product_name']}}</td>
                                                <td>{{$producto['quantity']}} {{$producto['product_unit']}}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
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
