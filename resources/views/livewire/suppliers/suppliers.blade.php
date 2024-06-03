<div>
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <b>Proveedores</b>
                    </h4>
                    <ul class="tabs tab-pills">
                        <li>
                            <a href="javascript:void(0)" wire:click.prevent="createSupplier()"
                                title="Iniciar planilla">Nuevo
                                +</a>
                        </li>
                    </ul>
                </div>

                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table striped mt-1">
                            <thead class="text-white" style="background: #3b3f5c;">
                                <tr>
                                    <th class="table-th text-white">Nombre</th>
                                    <th class="table-th text-white text-center">RUT</th>
                                    <th class="table-th text-white text-center">Telefono</th>
                                    <th class="table-th text-white text-center">Mail</th>
                                    <th class="table-th text-white text-center">Dirección</th>
                                    <th class="table-th text-white text-center">Persona de contacto</th>
                                    <th class="table-th text-white text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{$supplier->name}}</td>
                                    <td>{{$supplier->rut}}</td>
                                    <td>{{$supplier->phone}}</td>
                                    <td>{{$supplier->mail}}</td>
                                    <td>{{$supplier->location}}</td>
                                    <td>{{$supplier->contactPerson}}</td>
                                    <td><button class="btn btn-primary"
                                            wire:click='editSupplier({{$supplier->id}})'>Editar</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.suppliers.form')
    @push('scripts')
    <script>
        Livewire.on('show-modal', () => {
            $('#supplierForm').modal('show');
        });

        Livewire.on('hide-modal',() => {
            $('#supplierForm').modal('hide');
        });
    </script>
    @endpush
</div>
