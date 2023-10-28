
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <b>Clientes</b>
                    </h4>
                    <ul class="tabs tab-pills">
                        <li>
                            <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                                data-target="#theModal">Agregar</a>
                        </li>
                    </ul>
                </div>
                @include('common.searchbox')
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-bordered  tableBodyColor mt-1">
                            <thead class="tableHeadColor">
                                <tr>
                                    <th class="table-th tableHeadTextColor text-center">Nombre</th>
                                    <th class="table-th tableHeadTextColor text-center">Teléfono</th>
                                    <th class="table-th tableHeadTextColor text-center">Direcciones</th>
                                    <th class="table-th tableHeadTextColor text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client )
                                <tr>
                                    <td>
                                        <h6 class="tableTextColor">{{$client->name}}</h6>
                                    </td>
                                    <td class="text-center">
                                        <p class="tableTextColor">{{$client->telephone}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="tableTextColor">{{$client->default_address}}</p>
                                    </td>
                                    <td class="text-center">
                                        @if($client->debts->count() > 0)
                                            <a href="javascript:void(0)" wire:click.prevent='see_debts({{$client->id}})' class="btn btn-warning mtmobile" title="Ver deudas">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                        <a href="javascript:void(0)" wire:click.prevent="Edit({{$client->id}})" class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" wire:click.prevent="Edit({{$client->id}})" class="btn btn-dark" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$clients->links()}}
                </div>
            </div>
        </div>
        @include('livewire.clients.form')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('stored_client', msg => {
                $('#theModal').modal('hide');
                noty('Cliente registrado.');
            })
            window.livewire.on('edit_client', msg => {
                $('#theModal').modal('show');
            })
        });
    </script>


