<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Deuda pendiente de {{$selected_client->name}}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
        h1 {
            font-size: 14px;
        }

        .table td,
        .table th {
            padding: 0;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
</head>

<main class="container">
    <div class="row">
        <div class="col">
            <h1>{{$selected_client->name}}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table">
                <tr class="bg-dark">
                    <th class="text-white" scope="col">Ticket #</th>
                    <th class="text-white" scope="col">Fecha</th>
                    <th class="text-white" scope="col"></th>
                    <th class="text-white" scope="col">Total</th>
                </tr>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>

                <tbody>
                    @foreach ($selected_client->debts as $debt)
                    <tr class="bg-dark">
                        <td class="text-white">{{$debt->id}}</td>
                        <td class="text-white">{{\Carbon\Carbon::parse($debt->created_at)->format('d/m/Y')}}</td>
                        <td class="text-white"></td>
                        <td class="text-white">${{$debt->total}}</td>
                        <td class="text-white"></td>
                    </tr>
                    @foreach ($debt->details as $detail)
                    <tr>
                        <td scope="col">{{$detail->product->name}}</td>
                        <td scope="col">
                            @if($detail->product->unitSale->unit == 'ud')
                            {{number_format($detail->quantity,0)}}
                            @elseif($detail->product->unitSale->unit == 'Kg')
                            {{number_format($detail->quantity,3,',','.')}}
                            @endif
                            {{$detail->product->unitSale->unit}}</td>
                        <td scope="col">${{number_format($detail->price / $detail->quantity,0)}}</td>
                        <td scope="col">${{number_format($detail->price,0)}}</td>
                    </tr>
                    @endforeach
                    @endforeach
                    <tr class="bg-dark">
                        <th class="text-white" scope="col">@if($selected_client->discount > 0) sub-total @else Total
                            @endif</th>
                        <th class="text-white" scope="col"></th>
                        <th class="text-white" scope="col"></th>
                        <th class="text-white" scope="col">${{$selected_client->debts->sum('total')}}</th>
                    </tr>
                    @if($selected_client->discount > 0)
                    <tr class="bg-dark">
                        <th class="text-white" scope="col">Descuento</th>
                        <th class="text-white" scope="col"></th>
                        <th class="text-white" scope="col"></th>
                        <th class="text-white" scope="col">%{{$selected_client->discount}}</th>
                    </tr>
                    <tr class="bg-dark">
                        <th class="text-white" scope="col">Total</th>
                        <th class="text-white" scope="col"></th>
                        <th class="text-white" scope="col"></th>
                        <th class="text-white" scope="col">${{$selected_client->debts->sum('total')}}</th>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</main>

</html>
