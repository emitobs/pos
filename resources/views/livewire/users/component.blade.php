<div>
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <b>Usuarios</b>
                    </h4>
                    <ul class="tabs tab-pills">
                        <li>
                            <a href="javascript:void(0)" wire:click.prevent="createUser()"
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
                                    <th class="table-th text-white text-center">Email</th>
                                    <th class="table-th text-white text-center">Cargo</th>
                                    <th class="table-th text-white text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td class="text-center">{{$user->roles->first()->name}}</td>
                                    <td class="text-center">
                                        <button class="btn btn-primary"
                                            wire:click.prevent="editUser({{$user->id}})">Editar</button>
                                        <button class="btn btn-danger"
                                            wire:click.prevent="deactivateUser()">Desactivar</button>
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
    @include('livewire.users.form')


    <script>
        document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', Msg=>{
            $('#userForm').modal('show');
        });
        window.livewire.on('user_added', Msg=>{
            $('#userForm').modal('hide');
            noty('Usuario registrado');
        });

        $('#userForm').on('hidden.bs.modal', function (e) {
            window.livewire.emit('resetUI');
        });
    });
    </script>
</div>
