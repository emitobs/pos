<div>
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <b>Sorteos</b>
                    </h4>
                    <ul class="tabs tab-pills">
                        <li>
                            <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                                data-target="#theModal">Agregar</a>
                        </li>
                    </ul>
                </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table striped mt-1">
                            <thead class="text-white" style="background: #3b3f5c;">
                                <tr>
                                    <th class="table-th text-center text-white">Nombre</th>
                                    <th class="table-th text-center text-white">Cod Generados</th>
                                    <th class="table-th text-center text-white">Cant Premios</th>
                                    <th class="table-th text-center text-white">Premios Reclamados</th>
                                    <th class="table-th text-center text-white">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($raffles as $raffle)
                                <tr>
                                    <td class="pl-4">
                                        <h6>{{$raffle->name}}</h6>
                                    </td>
                                    <td class="text-center">
                                        <span>
                                            <h6>{{$raffle->codes->count()}}</h6>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span>
                                            <h6>{{$raffle->codes->where('award', 1)->count()}}</h6>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span>
                                            <h6>{{$raffle->codes->where('award', 1)->where('used_at', '!=', null)->count()}}</h6>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-dark" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {});
    </script>
</div>
