<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                            data-target="#theModal">
                            <i class="bi bi-plus-lg"></i> Agregar
                        </a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background:#3b3f5c;">
                            <tr>
                                <th class="table-th text-white">ID</th>
                                <th class="table-th text-white text-center">DESCRIPCION</th>
                                <th class="table-th text-white">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <td>
                                    <h6>{{$role->id}}</h6>
                                </td>
                                <td class="text-center">
                                    {{$role->name}}
                                </td>
                                <td class="text-center" style="width: 150px">
                                    <a href="javascript:void(0)" wire:click="Edit({{$role->id}})"
                                        class="btn btn-dark mtmobile" title="Editar registro"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0)" onclick="confirm({{$role->id}})"
                                        class="btn btn-dark mtmobile" title="Eliminar registro"><i
                                            class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$roles->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.roles.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('role-added', Msg =>{
            $("#theModal").modal('hide');
            noty(Msg);
        })
        window.livewire.on('role-updated', Msg =>{
            $("#theModal").modal('hide');
            noty(Msg);
        })
        window.livewire.on('role-deleted', Msg =>{
            noty(Msg);
        })
        window.livewire.on('role-exists', Msg =>{
            noty(Msg);
        })
        window.livewire.on('role-error', Msg =>{
            noty(Msg);
        })
        window.livewire.on('hide-modal', Msg =>{
            $("#theModal").modal('hide');
            noty(Msg);
        })
        window.livewire.on('show-modal', Msg =>{
            $("#theModal").modal('show');

        })
        window.livewire.on('hidden-bs-modal', Msg =>{
            $(".er").css('display', 'none');
        })
    });

    function confirm(id)
    {
         Swal.fire({
          title: 'CONFIRMAR',
          text: "Â¿CONFIRMAS ELIMINAR EL REGISTRO?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Aceptar',
          confirmButtonColor: '#3B3F5C',
          cancelButtonText: 'Cerrar',
          cancelButtonColor: '#ADADB0',

        }).then((result) => {
          if (result.value) {
                window.livewire.emit('deleteRow', id);
                $("#theModal").modal('hide');
                Swal.fire.close();
          }
        })
    }
</script>
