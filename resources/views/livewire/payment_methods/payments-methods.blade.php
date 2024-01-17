<div>

    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        Métodos de pago
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
                        <table class="table table-bordered table-striped  mt-1">
                            <thead class="text-white" style="background: #3b3f5c;">
                                <tr>
                                    <th class="table-th text-white text-center">Nº</th>
                                    <th class="table-th text-white text-center">Nombre</th>
                                    <th class="table-th text-white text-center">Desactivado</th>
                                    <th class="table-th text-white text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments_methods as $payment_method)
                                <tr>
                                    <td class="text-center">{{$payment_method->id}}</td>
                                    <td class="text-center">{{$payment_method->name}}</td>
                                    <td class="text-center">@if($payment_method->disabled) Si @else No @endif</td>
                                    <td class="d-flex justify-content-center">
                                        <button class="btn btn-primary"
                                            wire:click="Edit({{$payment_method->id}})">Editar</button>
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
    @include('livewire.payment_methods.form')
    @push('scripts')
    <script>
        Livewire.on('edit_paymentMethod',() => {
            $('#theModal').modal('show');
        });
        Livewire.on('paymentMethod_updated', msg =>{
            $('#theModal').modal('hide');
            noty(msg);
        });
    </script>

    @endpush
    <script>
        document.addEventListener('DOMContentLoaded', function()
        {
            window.livewire.on('show-modal', msg => {
                $('#theModal').modal('show');
            });
            window.livewire.on('notify', Msg => {
                noty(Msg);
            });
        });


            function Confirm(id, products){

                if(products > 0){
                    swal('NO SE PUEDE ELIMINAR CATEGORIA, POSEE PRODUCTOS')
                }

                swal({
                    title : 'CONFIRMAR',
                    text : '¿Confirmas eliminar el registro?',
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Cerrar',
                    cancelButtonColor: '#fff',
                    confirmButtonColor: '#3b3f5c',
                    confirmButtonText: 'Aceptar'
                }).then(function(result){
                    if(result.value){
                        window.livewire.emit('deleteRow',id);
                        swal.close();
                    }
                });
            }
    </script>
</div>
