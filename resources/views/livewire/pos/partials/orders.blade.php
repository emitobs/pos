{{-- ESTO ES CULPA DE EMITO --}}
@push('style')
<style>
    .widget-table-one .transactions-list .t-item .t-icon .icon-blue {
        position: relative;
        display: inline-block;
        padding: 10px;
        background-color: #236ed1c2;
        border-radius: 50%;
        color: white;
    }

    .widget-table-one .transactions-list .t-item .t-icon .icon--orange {
        position: relative;
        display: inline-block;
        padding: 10px;
        background-color: #dda84dcc;
        border-radius: 50%;
        color: white;
    }

    .widget-table-one .transactions-list .t-item .t-icon .icon-purple {
        position: relative;
        display: inline-block;
        padding: 10px;
        background-color: #712ab4c0;
        border-radius: 50%;
        color: white;
    }

    .widget-table-one .transactions-list .t-item .t-icon .icon-skyblue {
        position: relative;
        display: inline-block;
        padding: 10px;
        background-color: #367896cc;
        border-radius: 50%;
        color: white;
    }

    .widget-table-one .transactions-list .t-item .t-icon .icon-green {
        position: relative;
        display: inline-block;
        padding: 10px;
        background-color: #389e4eab;
        border-radius: 50%;
        color: white;
    }

    .widget-table-one .transactions-list .t-item .t-icon .icon-red {
        position: relative;
        display: inline-block;
        padding: 10px;
        background-color: #9e3939cb;
        border-radius: 50%;
        color: white;
    }

    /* width */
    ::-webkit-scrollbar {
        width: 12px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #047439;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #047439;
    }
</style>
{{-- ESTO ES CULPA DE EMITOFIN --}}
@endpush

{{-- pedidos activos --}}
<div class="mt-3 col-12">
    <div class="widget widget-table-one">
        <div class="widget-heading">
            <h5 class="ml-2 mt-2">Pedidos</h5>
        </div>

        <div id="ordersContainer" class="widget-content d-flex flex-wrap"
            style="max-height: 37vh; overflow: scroll; overflow-x: hidden;">
            @foreach ($sales->sortByDesc('created_at') as $xsale)
            <div class="widget-content col-3" wire:click="loadSale({{$xsale->id}})">
                <div class="transactions-list mb-2" data-item-id="{{$xsale->id}}" style="min-height: 85px">
                    <div class="t-item">
                        <div class="t-company-name">
                            <div class="t-icon">
                                @switch($xsale->status)
                                @case('En espera')
                                <div class="icon-blue">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-pause-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="10" y1="15" x2="10" y2="9"></line>
                                        <line x1="14" y1="15" x2="14" y2="9"></line>
                                    </svg>
                                </div>
                                @break
                                @case('En cocina')
                                <div class="icon--orange">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-command">
                                        <path
                                            d="M18 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3H6a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3V6a3 3 0 0 0-3-3 3 3 0 0 0-3 3 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 3 3 0 0 0-3-3z">
                                        </path>
                                    </svg>
                                </div>
                                @break
                                @case('En preparación')
                                <div class="icon-purple">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-clock">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </div>
                                @break
                                @case('Esperando delivery')
                                <div class="icon-skyblue">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-truck">
                                        <rect x="1" y="3" width="15" height="13"></rect>
                                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                    </svg>
                                </div>
                                @break
                                @case('Entregado')
                                <div class="icon-green">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-check-circle">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </div>
                                @break
                                @case('Cancelado')
                                <div class="icon-red">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-x-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                    </svg>
                                </div>
                                @break
                                @endswitch
                            </div>
                            <div class="t-name">
                                <h4>{{$xsale->client->name}}</h4>
                                <p class="meta-date">{{$xsale->address}}</p>
                            </div>

                        </div>
                        <div class="t-rate text-warning">
                            <p><span>#{{$xsale->id}}</span></p>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div id="context-menu" class="context-menu">
            <ul>
                <li><a href="#" data-status="En espera">En espera</a></li>
                <li><a href="#" data-status="En preparación">En preparación</a></li>
                <li><a href="#" data-status="Esperando delivery">Esperando delivery</a></li>
                <li><a href="#" data-status="Entregado">Entregado</a></li>
                <li><a href="#" data-status="Cancelado">Cancelado</a></li>
            </ul>
        </div>
    </div>
    @include('livewire.orders.selectDelivery')
    <style>
        .context-menu {
            display: none;
            position: fixed;
            /* Cambio aquí */
            z-index: 1000;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, .5);
        }

        .context-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .context-menu li {
            padding: 5px 10px;
            cursor: pointer;
        }

        .context-menu li:hover {
            background-color: #ddd;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('show-selectDelivery', msg => {
            $('#theModalSelectDelivery').modal('show');
        });
            window.livewire.on('hide-selectDelivery', msg => {
            $('#theModalSelectDelivery').modal('hide');
        });
    let contextMenu = document.getElementById('context-menu');
    let transactionsListDivs = document.querySelectorAll('.transactions-list');

    transactionsListDivs.forEach(function(transactionDiv) {
        transactionDiv.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            let saleId = e.currentTarget.getAttribute('data-item-id');
            contextMenu.setAttribute('data-item-id', saleId);

            contextMenu.style.display = 'block';

            let x = e.clientX;
            let y = e.clientY;

            // Comprueba si el menú cabe en la parte inferior del punto de clic
            if (y + contextMenu.offsetHeight > window.innerHeight) {
                // Si no cabe, muestra el menú por encima del punto de clic
                y = y - contextMenu.offsetHeight;
            }

            // Comprueba si el menú cabe a la derecha del punto de clic
            if (x + contextMenu.offsetWidth > window.innerWidth) {
                // Si no cabe, muestra el menú a la izquierda del punto de clic
                x = x - contextMenu.offsetWidth;
            }

            contextMenu.style.left = x + 'px';
            contextMenu.style.top = y + 'px';
        });
    });

    document.addEventListener('click', function(e) {
        if (e.button === 0) {
            contextMenu.style.display = 'none';
        }
    });

    contextMenu.addEventListener('click', function(e) {
        if (e.target.tagName === 'A') {
            e.preventDefault();
            let saleId = contextMenu.getAttribute('data-item-id');
            let status = e.target.getAttribute('data-status');
            if(status === 'Entregado'){
                Livewire.emit('selectDeliveryToOrder',saleId);
            }else{
                Livewire.emit('updateOrderStatus',saleId,status);
            }

        }
    });
});
    </script>
</div>
