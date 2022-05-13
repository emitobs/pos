<div class="row mb-3">
    <div class="col-sm-12">
        <div class="connect-sorting-content">
            <div class="card simple-normal-title-task ui-sorteable-handle">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h2>Productos</h2>
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                                    <thead>
                                        <tr>
                                            <th class="checkbox-column">
                                                <div class="custom-control custom-checkbox checkbox-primary">
                                                    <input type="checkbox" class="custom-control-input todochkbox"
                                                        id="todoAll">
                                                    <label class="custom-control-label" for="todoAll"></label>
                                                </div>
                                            </th>
                                            <th>Cantidad</th>
                                            <th class="">Producto</th>
                                            <th class="">Detalle</th>
                                            <th class="">Precio</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($service_to_finish->products as $product_in_service)
                                        <tr>
                                            <td class="checkbox-column">
                                                <div class="custom-control custom-checkbox checkbox-primary">
                                                    <input type="checkbox" class="custom-control-input todochkbox"
                                                        id="todo-1">
                                                    <label class="custom-control-label" for="todo-1"></label>
                                                </div>
                                            </td>
                                            <td>{{$product_in_service->quantity}}</td>
                                            <td>{{$product_in_service->product}}</td>
                                            <td>{{$product_in_service->detail}}</td>
                                            <td>{{$product_in_service->unit_price}}</td>
                                            <td>{{$product_in_service->total}}</td>
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
</div>
