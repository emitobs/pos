<div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Items</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->client->name}}</td>
                <td>{{$order->details->sum('quantity')}}</td>
                <td>{{$order->total}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$orders->links()}}
</div>
