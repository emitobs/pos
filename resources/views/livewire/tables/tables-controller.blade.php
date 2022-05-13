<div>
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <b>Mesas</b>
                    </h4>
                    <ul class="tabs tab-pills">
                        <li>
                            <button href="javascript:void(0)" class="tabmenu bg-dark"
                                wire:click='create_table'>Agregar</button>
                        </li>
                    </ul>
                </div>

                <div class="widget-content">
                    <div class="row d-flex justify-content-around">
                        @foreach ($tables as $table)

                        <div class="col-md-2">
                            <div class="card mb-3" style="max-width: 18rem; ">
                                <div class="card-header">Mesa {{$table->id}} | Estado: <i class="fa fa-circle @switch($table->status)
                                    @case('busy')
                                    text-danger
                                    @break
                                    @case('reserved')
                                        text-warning
                                    @break
                                    @default
                                    text-success
                                @endswitch"></i></div>
                                <div class="card-body">
                                    @switch($table->status)
                                    @case('busy')
                                    <p>Inicio:
                                        {{\Carbon\Carbon::parse($table->current_service->created_at)->format('H:i')}}
                                    </p>
                                    <p>Ultimo pedido:
                                        @if($table->current_service->products->count() > 0)
                                        {{\Carbon\Carbon::parse($table->current_service->products->first()->created_at)->format('H:i')}}
                                        @endif
                                    </p>
                                    <p>Total:
                                        ${{$table->current_service->products->where('order_id','!=',null)->sum('unit_price')}}
                                    </p>
                                    <p>Atiende: {{$table->current_service->attendant}}</p>
                                    <button class="btn btn-primary"
                                        wire:click="select_table({{$table->id}})">Gestionar</button>
                                    @break
                                    @case('reserved')
                                    <p>Mesa reservada hora: </p>
                                    @break
                                    @default
                                    <p>Servicio sin iniciar</p>
                                    <button class="btn btn-success" wire:click="select_attendant({{$table->id}})">Inciar
                                        servicio
                                        servicio</button>
                                    @endswitch
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Modal -->
    @if($table_selected && $table_selected->current_service != null)
    <div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white">
                        Mesa {{$table_selected->id}}
                    </h5>
                    <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
                    <button class="btn btn-danger"
                        onclick="confirm_end_service({{$table_selected->current_service->id}})">Finalizar
                        servicio</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="connect-sorting-content">
                                <div class="card simple-normal-title-task ui-sorteable-handle">
                                    <div class="card-body">
                                        <div class="task-header">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <input type="number" id='units_quantity' autofocus='focus'
                                                            wire:model.lazy="units_quantity"
                                                            wire:keydown.enter='addProduct' class="form-control"
                                                            placeholder="1" step="1">
                                                        @error('units_quantity') <span
                                                            class="text-danger er">{{$message}}</span>@enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea id='detail' wire:model.lazy="detail"
                                                            class="form-control" placeholder="Detalle"></textarea>
                                                        @error('detail') <span
                                                            class="text-danger er">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    @include('common.searchbox')
                                                    @if(strlen($search) > 0)
                                                    <div wire:loading class="rounded-t-none shadow-lg list-group">
                                                        <div class="list-item">Buscando...</div>
                                                    </div>
                                                    @if($searched_products->count() > 0)
                                                    <ul class="list-group">
                                                        @foreach ($searched_products as $searched_product)
                                                        <li class="list-group-item"
                                                            wire:click.prevent="$emit('add_product_to_cart', {{$searched_product->barcode}})">
                                                            Producto: <b>{{$searched_product->name}}</b> &nbsp;
                                                            Precio:
                                                            <b>${{$searched_product->price}}</b>{{$searched_product->unitSale->unit}}
                                                            &nbsp;
                                                            Stock: <b>{{$searched_product->stock}}</b>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                    @endif
                                                </div>
                                            </div>
                                            @if(strlen($search) == 0)
                                            {{-- <div class="row">
                                                <div class="form-inline">
                                                    @foreach ($categoriesProducts as $category)
                                                    <div class="n-chk">
                                                        <label class="new-control new-radio radio-primary">
                                                            <input wire:model="category_selected"
                                                                name="category_selected" type="radio"
                                                                value="{{$category->id}}" class="new-control-input" />
                                                            <span
                                                                class="new-control-indicator"></span>{{$category->name}}
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div> --}}
                                            {{--
                                            <hr>
                                            <div class="row products-container">
                                                @foreach ($products as $product )
                                                <div class="col-6 mb-1">
                                                    <a href="javascript:void(0)"
                                                        wire:click.prevent="$emit('select_product', {{$product->barcode}})"
                                                        title="Ver">
                                                        <div class="card component-card_2">
                                                            <div class="card-body">
                                                                <h5 class="card-title text-center">
                                                                    {{$product->name}}</h5>
                                                                <p>Precio: ${{$product->price}} | Stock:
                                                                    {{$product->stock}}</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                @endforeach
                                            </div> --}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            @include('livewire.tables.detail')
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                        data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($table_selected)
    @include('livewire.tables.select_modal_attendant')
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('print-order', saleId => {
            window.open("print://" + saleId + '/2', '_self');
        });
        window.livewire.on('set_attendant', data => {
            $('#select_modal_attendant').modal('show');
        });

        window.livewire.on('set_units',msg => {
            $('#set_units').modal('show');
        });
        });

        function confirm_end_service(serviceid){
            swal({
                title : 'Finalizar servicio',
                text : '¿Confirmas finalizar el servicio?',
                type: 'success',
                showCancelButton: true,
                cancelButtonText: 'Cerrar',
                cancelButtonColor: '#fff',
                confirmButtonColor: '#3b3f5c',
                confirmButtonText: 'Aceptar'
            }).then(function(result){
                if(result.value){
                    @this.set('service_to_finish',serviceid);
                    window.livewire.emit('confirm_end_of_service');
                    swal.close();
                }
            });
        };
    </script>
</div>
