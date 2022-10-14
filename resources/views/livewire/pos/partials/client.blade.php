<div class="connect-sorting-content">
    <div class="card simple-normal-title-task ui-sorteable-handle">
        <div class="card-body">
            <div class="task-header">
                <div class="form-row">
                    <div class="col-12">
                        <div wire:ignore><select id="search_client" class="select-client" wire:model='searched_client' name=""
                                id=""></select></div>
                        <div class="form-group">
                            {{-- <input type="text" id="search_client" class="form-control"
                                placeholder="Ingresar cliente buscado..." wire:model='searched_client'>
                            @if(strlen($searched_client) > 0)
                            <div wire:loading class="rounded-t-none shadow-lg list-group">
                                <div class="list-item">Buscando...</div>
                            </div>
                            <ul class="list-group">
                                @foreach ($clients as $client)
                                <li class="list-group-item" style="font-size: 12px"
                                    wire:click.prevent="selectClient({{$client->id}})">
                                    {{$client->name}} | {{$client->telephone}} | {{$client->default_address}}
                                </li>
                                @endforeach
                            </ul>
                            @endif --}}

                            <div class="form mt-4">
                                <div class="form-group mb-4">
                                    <input type="number" class="form-control" wire:model="telephone" id="rtelephone"
                                        placeholder="Teléfono" required>
                                    @error('telephone') <span class="text-danger er">{{$message}}</span>@enderror
                                </div>
                                <div class="form-group mb-4">
                                    <input type="text" class="form-control" wire:model="client" id="rClientName"
                                        placeholder="Cliente" required>
                                    @error('client') <span class="text-danger er">{{$message}}</span>@enderror
                                </div>
                                <div class="form-group mb-4">
                                    <input type="text" class="form-control" wire:model="address" id="rAdress"
                                        placeholder="Dirección" required>
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
                                <div class="input-group mb-4">
                                    <textarea wire:model="clarifications" class="form-control"
                                        placeholder="Aclaraciones" aria-label="Aclaraciones"></textarea>
                                </div>
                            </div>
                            @if(!empty($client))
                            <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="reset"></div>
                            @endif
                            @error('client') <span class="text-danger er">{{$message}}</span>@enderror
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
    //$('#city').select2();
    $(".select-client").select2({
                placeholder: "Select client",
                minimumInputLength: 2,
                ajax: {
                    url: "{{ route('getClients') }}",
                    dataType: 'json',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(term) {
                        return {
                            term: term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                console.log(item);
                                return {
                                    text: item.text,
                                    id: item.id,
                                }
                            })
                        };
                    }
                }
            });
            
            $("#search_client").on('change',function(){
            Livewire.emit('selectClient',this.value);
        })

            })
</script>

@endpush