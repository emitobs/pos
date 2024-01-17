<div>
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <b>Planillas</b>
                    </h4>
                    <ul class="tabs tab-pills">
                        <li>
                            <a href="javascript:void(0)" wire:click.prevent="createPayroll()"
                                title="Iniciar planilla">Nueva
                                +</a>
                        </li>
                    </ul>
                </div>

                <div class="widget-content">
                    {{-- TABLA GENERICA INICIO // RECAUDOS TOTALES --}}

                    <div class="col-12">
                        <div class="card ">
                            <div class="card-body bgPayrollModalInfoContainerColor shadow-lg">
                                <h5 class="mb-3 payrollModalInfoContainerTextColor">Planilla</h5>
                                <div class="row ">
                                    <div class="col-12">
                                        <div class="card payrollModalInfoContainerbodyColor">
                                            <div class="card-body">
                                                <table class="table payrollModalInfoContainerTextTableColor">
                                                    <tr>
                                                        <th class="table-th tableHeadTextColor ">Nº</th>
                                                        <th class="table-th tableHeadTextColor text-center">Responsable
                                                        </th>
                                                        <th class="table-th tableHeadTextColor text-center">Pedidos</th>
                                                        <th class="table-th tableHeadTextColor text-center">Recaudo</th>
                                                        <th class="table-th tableHeadTextColor text-center">Se inició
                                                        </th>
                                                        <th class="table-th tableHeadTextColor text-center">Se cerró
                                                        </th>
                                                        <th class="table-th tableHeadTextColor text-center">Actions</th>
                                                    </tr>
                                                    <tbody>
                                                        @foreach ($payrolls as $payroll )
                                                        <tr>
                                                            <td>
                                                                <h6 class="">{{$payroll->id}}</h6>
                                                            </td>
                                                            <td>
                                                                <h6 class="">{{$payroll->cashier->name}}
                                                                </h6>
                                                            </td>
                                                            <td class="text-center">
                                                                <h6 class="">{{$payroll->total_orders}}
                                                                </h6>
                                                            </td>
                                                            <td class="text-center">
                                                                <h6 class="">${{$payroll->total}}</h6>
                                                            </td>
                                                            <td class="text-center">
                                                                <h6 class="">{{$payroll->created_at}}</h6>
                                                            </td>
                                                            <td class="text-center">
                                                                @if($payroll->dateClosed != null)
                                                                <h6>{{$payroll->dateClosed}}</h6>
                                                                @else
                                                                <h6>Planilla sin cerrar</h6>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <button wire:click="viewPayroll({{$payroll->id}})"
                                                                    class="btn btn-primary mtmobile"
                                                                    title="Ver planilla"><i
                                                                        class="fas fa-chart-bar"></i> Ver
                                                                    reportes</button>
                                                                <a href="/pedidos?payroll={{$payroll->id}}"
                                                                    class="btn btn-secondary mtmobile"
                                                                    title="Ver pedidos"><i class="fas fa-eye"></i> Ver
                                                                    pedidos</a>
                                                                @if(!$payroll->isClosed)
                                                                <a href="javascript:void(0)"
                                                                    wire:click.prevent="closePayroll({{$payroll->id}})"
                                                                    class="btn btn-danger">Cerrar</a>
                                                                @endif
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
                    </div>
                    {{-- TABLA GENERICA FIN --}}


                    {{$payrolls->links()}}
                </div>
            </div>
        </div>
        @if($payroll_selected)
        @include('livewire.payrolls.seePayrolls')
        @endif
        @include('livewire.payrolls.form')
    </div>

    @push('scripts')
    <script>
        livewire.on('error', msg => {
            noty(msg,2);
        })

        window.livewire.on('payroll-opened', Msg => {
            noty(Msg);
        });
        window.livewire.on('payroll-closed', Msg=>{
            noty(Msg)
        });
        window.livewire.on('payroll-open', Msg => {
            noty(Msg);
        });
        window.livewire.on('close-payroll', Msg=>{
            confirm(Msg);
        });
        window.livewire.on('see-payroll', Msg=>{
            $('#theModal').modal('show');
        });
        window.livewire.on('openCreatePayrollModal', Msg=>{
            $('#payrollForm').modal('show');
        });


    function confirm(id, Msg){
    swal({
    title : 'CONFIRMAR',
    text : Msg,
    type: 'warning',
    showCancelButton: true,
    cancelButtonText: 'Cerrar',
    cancelButtonColor: '#fff',
    confirmButtonColor: '#3b3f5c',
    confirmButtonText: 'Aceptar'
}).then(function(result){
    if(result.value){
        window.livewire.emit('confirmClosed',id);
        swal.close();
    }
});
}
    </script>
    @endpush

</div>
