<div>
    <style>
        .order {
            width: 125px;
            background-color: pink;
            height: 125px;
            cursor: pointer;
            box-sizing: border-box;
            padding: 13px;
            margin: 0 5px 10px 5px;
        }
    </style>
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
                        @foreach ($payroll->sales->where('status', "!=", 'Cancelado')->where('status', "!=", 'Entregado') as $order)
                        <div class="order col-2 text-center" wire:click.prevent="deliver_order({{$order->id}})">
                            <p># {{$order->id}}</p>
                            <br>
                        </div>
                        @endforeach
                        @endforeach
                    </div>


                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {});
    </script>

</div>
