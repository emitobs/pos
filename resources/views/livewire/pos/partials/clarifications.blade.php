<div>
    <div class="form-group mb-4">
        <input type="number" class="form-control" wire:model="telephone" id="rtelephone" placeholder="Teléfono" required>
        @error('telephone') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <div class="form-group mb-4">
        <input type="text" class="form-control" wire:model="client" id="rClientName" placeholder="Cliente" required>
        @error('client') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <div class="form-group mb-4">
        <input type="text" class="form-control" wire:model="address" id="rAdress" placeholder="Dirección" required>
        @error('address') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <div class="form-group mb-4">
        <input type="time" class="form-control" wire:model="deliveryTime" id="rDeliveryTime"
            placeholder="Hora de entrega" required>
        @error('deliveryTime') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    @if (use_beepers())
    <div class="form-group mb-4">
        <select class="form-control" wire:model.lazy='beeper'>
            <option value="default">Selecciona beeper</option>
            @foreach ($beepers as $beeper )
            <option value="{{$beeper->id}}">{{$beeper->id}}</option>
            @endforeach
        </select>
        @error('bipper') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    @endif

    <div class="input-group mb-4">
        <textarea wire:model="clarifications" class="form-control" placeholder="Aclaraciones"
            aria-label="Aclaraciones"></textarea>
    </div>
    {{-- ESTO ES CULPA DE EMITO --}}
        <style>
            .widget-table-one .transactions-list .t-item .t-icon .icon-blue{
                position: relative;
                display: inline-block;
                padding: 10px;
                background-color: #236ed1c2;
                border-radius: 50%;
                color: white;
            }
            .widget-table-one .transactions-list .t-item .t-icon .icon--orange{
                position: relative;
                display: inline-block;
                padding: 10px;
                background-color: #dda84dcc;
                border-radius: 50%;
                color: white;
            }
            .widget-table-one .transactions-list .t-item .t-icon .icon-purple{
                position: relative;
                display: inline-block;
                padding: 10px;
                background-color: #712ab4c0;
                border-radius: 50%;
                color: white;
            }
            .widget-table-one .transactions-list .t-item .t-icon .icon-skyblue{
                position: relative;
                display: inline-block;
                padding: 10px;
                background-color: #367896cc;
                border-radius: 50%;
                color: white;
            }
            .widget-table-one .transactions-list .t-item .t-icon .icon-green{
                position: relative;
                display: inline-block;
                padding: 10px;
                background-color: #389e4eab;
                border-radius: 50%;
                color: white;
            }
            .widget-table-one .transactions-list .t-item .t-icon .icon-red{
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

    {{-- pedidos activos --}}
    <div class="">
        <div class="widget widget-table-one">
            <div class="widget-heading">
                <h5 class="ml-2 mt-2">Pedidos</h5>
            </div>

            <div class="widget-content" style="max-height: 37vh; overflow: scroll; overflow-x: hidden;">
                @foreach ($sales as $xsale)
                    <div class="widget-content" wire:click="loadSale({{$xsale->id}})">
                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-icon">
                                            @if($xsale->status == 'En espera')<div class="icon-blue"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pause-circle"><circle cx="12" cy="12" r="10"></circle><line x1="10" y1="15" x2="10" y2="9"></line><line x1="14" y1="15" x2="14" y2="9"></line></svg></div>
                                            @elseif($xsale->status == 'En cocina')<div class="icon--orange"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-command"><path d="M18 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3H6a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3V6a3 3 0 0 0-3-3 3 3 0 0 0-3 3 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 3 3 0 0 0-3-3z"></path></svg></div>
                                            @elseif($xsale->status == 'En preparación')<div class="icon-purple"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div>
                                            @elseif($xsale->status == 'Esperando delivery')<div class="icon-skyblue"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg></div>
                                            @elseif($xsale->status == 'Entregado')<div class="icon-green"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></div>
                                            @elseif($xsale->status == 'Cancelado')<div class="icon-red"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></div>
                                            @endif
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
        </div>
    </div>
</div>
