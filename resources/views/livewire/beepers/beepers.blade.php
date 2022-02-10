<div>
    <div>
        <div class="row sales layout-top-spacing">
            <div class="col-sm-12">
                <div class="widget widget-chart-one">
                    <div class="widget-heading">
                        <h4 class="card-title">
                            <b>Beepers</b>
                        </h4>
                        <ul class="tabs tab-pills">
                            <li>
                                <a href="javascript:void(0)" wire:click.prevent="newBeeper()"
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
                                        <th class="table-th text-white">Id</th>
                                        <th class="table-th text-white text-center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($beepers as $beeper )
                                    <tr>
                                        <td>{{$beeper->id}}</td>
                                        <td>{{$beeper->inUse}}</td>
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
            window.livewire.on('showForm', Msg=>{
                $('#userForm').modal('show');
            });

        });
    </script>

</div>
