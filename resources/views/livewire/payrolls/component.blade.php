<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Planillas</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" wire:click.prevent="newPayroll()" title="Iniciar planilla">Nueva
                            +</a>
                    </li>
                </ul>
            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c;">
                            <tr>
                                <th class="table-th text-white">Nº</th>
                                <th class="table-th text-white text-center">Pedidos</th>
                                <th class="table-th text-white text-center">Recaudo</th>
                                <th class="table-th text-white text-center">Se inició</th>
                                <th class="table-th text-white text-center">Se cerró</th>
                                <th class="table-th text-white text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payrolls as $payroll )
                            <tr>
                                <td>
                                    <h6>{{$payroll->id}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{$payroll->totalSales}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>${{$payroll->totalCash}}</h6>
                                </td>
                                <td class="text-center">
                                    <h6>{{$payroll->created_at}}</h6>
                                </td>
                                <td class="text-center">
                                    @if($payroll->dateClosed != null)
                                    <h6>{{$payroll->dateClosed}}</h6>
                                    @else
                                    <h6>Planilla sin cerrar</h6>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click.prevent="seepay({{$payroll->id}})"
                                        class="btn btn-primary mtmobile" title="Ver planilla"><i class="fas fa-chart-bar"></i> Ver reportes</a>
                                        <a href="/pedidos?payroll={{$payroll->id}}"
                                            class="btn btn-secondary mtmobile" title="Ver pedidos"><i class="fas fa-eye"></i> Ver pedidos</a>
                                    @if(!$payroll->isClosed)
                                    <a href="javascript:void(0)" wire:click.prevent="closePayroll({{$payroll->id}})"
                                        class="btn btn-danger">Cerrar</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{$payrolls->links()}}
            </div>
        </div>
    </div>
    @if($payroll_selected != null)
    @include('livewire.payrolls.seePayrolls')
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
