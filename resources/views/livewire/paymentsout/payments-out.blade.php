<div>
    <div class="row sales layout-top-spacing">
        <div class="col-sm-12">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4 class="card-title">
                        <b>Gastos</b>
                    </h4>
                    <ul class="tabs tab-pills">
                        <li>
                            <a href="javascript:void(0)" wire:click.prevent="openModalNewPaymentOut()"
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
                                    <th class="table-th text-white">Descripcion</th>
                                    <th class="table-th text-white text-center">Monto</th>
                                    <th class="table-th text-white text-center">Fecha</th>
                                    <th class="table-th text-white text-center">Caja</th>
                                    <th class="table-th text-white text-center">Comprobante</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paymentOuts as $paymentOut)

                                <tr>
                                    <td class="col-4">{{$paymentOut->reason}}</td>
                                    <td class="col-1">$ {{$paymentOut->amount}}</td>
                                    <td class="col-1">{{$paymentOut->date}}</td>
                                    <td class="col-2">@if($paymentOut->payroll)
                                        Planilla #{{$paymentOut->payroll->id}} - Cajero:
                                        {{$paymentOut->payroll->cashier->name }}
                                        @endif</td>
                                    <td class="col-2 text-center">
                                        @if (empty($paymentOut->receipt))
                                        Sin comprobante
                                        @else
                                        <button class="btn btn-primary"
                                            wire:click.prevent="openModalReceiptViewer('{{$paymentOut->receipt}}')">Ver
                                            comprobante</button>
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
    @include('livewire.paymentsOut.modals.form-paymentOut')
    @include('livewire.paymentsOut.modals.receiptViewer')
    @push('scripts')
    <script>
        Livewire.on('openModalNewPaymentOut',data => {
                $('#theModal').modal('show');
            });

            Livewire.on('xopenModalReceiptViewer',imageUrl => {
                console.log(imageUrl);
                $('#receiptViewer img').attr('src', imageUrl);
            $('#receiptViewer').modal('show');
            });
    </script>
    @endpush
</div>
