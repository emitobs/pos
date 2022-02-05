<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
            </div>



            <div class="widget-content">

                <div class="form-inline">
                    <div class="form-group mr-5">
                        <label for=""></label>
                        <select wire:model='role' class="form-control">
                            <option value="Elegir" selected>Selecciona el rol</option>
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button wire:click.prevent='SyncAll()' class="btn btn-dark mbmobile inblock mr-5">Sincronizar
                        todos</button>
                    <button onclick='revoke()' class="btn btn-dark mbmobile mr-5">Revocar todos</button>
                </div>


                <div class="row mt-3">
                    <div class="table-responsive">
                        <table class="table table-bordered table striped mt-1">
                            <thead class="text-white" style="background: #3b3f5c;">
                                <tr>
                                    <th class="table-th text-white text-center">Id</th>
                                    <th class="table-th text-white text-center">Permiso</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission )
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{$permission->id}}</h6>
                                    </td>
                                    <td class="text-center">
                                        <div class="n-chk text-center">
                                            <label class="new-control new-checkbox checkbox-primary">
                                                <input type="checkbox" class="new-control-input inbox-chkbox"
                                                    wire:change="syncPermission($('#p{{$permission->id}}').is(':checked'),'{{$permission->name}}')"
                                                    id="p{{$permission->id}}" value="{{$permission->id}}"
                                                    {{$permission->checked == 1 ? 'checked' : ''}}>
                                                <span class="new-control-indicator"></span>>{{$permission->name}}
                                            </label>
                                        </div>
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

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('sync-error', Msg=>{
            noty(Msg)
        })
        window.livewire.on('permi', Msg=>{
            noty(Msg)
        })
        window.livewire.on('syncall', Msg=>{
            noty(Msg)
        })
        window.livewire.on('removeall', Msg=>{
            noty(Msg)
        })

    });


    function revoke()
    {
         Swal.fire({
          title: 'CONFIRMAR',
          text: "¿CONFIRMAS ELIMINAR EL REGISTRO?",
          showCancelButton: true,
          confirmButtonText: 'Aceptar',
          confirmButtonColor: '#3B3F5C',
          cancelButtonText: 'Cerrar',
          cancelButtonColor: '#ADADB0',
        }).then((result) => {
            console.log(result);
          if (result.value) {
                window.livewire.emit('DesyncAll');
                $("#theModal").modal('hide');
                Swal.close();
          }
        })
    }


</script>
