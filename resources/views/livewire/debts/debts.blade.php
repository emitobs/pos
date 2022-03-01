<div>
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <b>Deudas de {{$selected_client->name}}</b>
                    </h4>
                    <ul class="tabs tab-pills">
                        <li>
                            <a href="javascript:void(0)" class="tabmenu bg-dark" wire:click='generatePDF'>Generar
                                PDF</a>
                            <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                                data-target="#theModal">Registrar entrega</a>
                        </li>
                    </ul>
                </div>

                <div class="widget-content">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <ul class="list-group list-group-horizontal">
                                <li class="list-group-item"><b>Debe:</b> ${{$selected_client->debts->sum('total')}}</li>
                                <li class="list-group-item"><b>Saldo:</b> ${{$selected_client->balance}}</li>
                                <li class="list-group-item"><b>Última entrega:</b> {{$last_payment}}</li>
                            </ul>
                        </div>
                    </div>

                    <table class="table table-bordered table striped mt-1">
                        <thead>
                            <tr>
                                <th class="table-th">&nbsp;</th>
                                <th class="table-th">Ticket</th>
                                <th class="table-th">Fecha</th>
                                <th class="table-th">Total</th>
                                <th class="table-th">Debe</th>
                                <th class="table-th">Haber</th>
                                <th class="table-th">Ultimo pago</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selected_client->debts as $xdebt )
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="">
                                </td>
                                <td class="text-center">
                                    {{$xdebt->id}}
                                </td>
                                <td class="text-center">
                                    {{\Carbon\Carbon::parse($xdebt->created_at)->format('d/m/Y h:m')}}
                                </td>
                                <td class="text-center">
                                    {{$xdebt->total}}
                                </td>
                                <td class="text-center">
                                    {{$xdebt->remaining}}
                                </td>
                                <td class="text-center">
                                    {{$xdebt->total - $xdebt->remaining}}
                                </td>
                                <td class="text-center">
                                    {{\Carbon\Carbon::parse($xdebt->created_at)->format('d/m/Y h:m')}}
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click.prevent="seeDetail({{$xdebt->id}})"
                                        class="btn btn-info tabmenu"><i class="far fa-eye"></i> Ver</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.debts.seeDetail')
</div>

<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Nueva entrega de:</b> {{$selected_client->name}}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text" id="amount"><i class="fas fa-dollar-sign"></i></div>
                    </div>
                    <input wire:model='amount' type="text" class="form-control" placeholder="1560" aria-label="1560"
                        aria-describedby="amount">

                </div>
                @error('amount') <span class="text-danger er">{{$message}}</span>@enderror
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="confirm_new_payment()" class="btn btn-dark">Agregar</button>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('confirm_new_payment', data =>{
                Confirm();
            });

            window.livewire.on('payment_added', data =>{
                $('#theModal').modal('hide');
                noty('Registro de pago exitoso');
            });

            window.livewire.on('see_debt_details', Msg=>{
            $('#debt_modal').modal('show');
        });
        });
        function Confirm(){
            swal({
                title : 'CONFIRMAR',
                text : '¿Confirmas entrega?',
                type: 'success',
                showCancelButton: true,
                cancelButtonText: 'Cerrar',
                cancelButtonColor: '#fff',
                confirmButtonColor: '#3b3f5c',
                confirmButtonText: 'Aceptar'
            }).then(function(result){
                if(result.value){
                    window.livewire.emit('save_payment');
                    swal.close();
                }
            });
}
</script>
</div>
