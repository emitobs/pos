<div class="connect-sorting-content">
    <div class="card simple-normal-title-task ui-sorteable-handle">
        <div class="card-body">
            <div class="task-header">
                <div class="form-row">
                    <div class="col-12">
                        <div wire:ignore>
                            <select id="search_client" class="select-client" wire:model='searched_client'
                                name=""></select>
                        </div>
                        @if ($selected_client)
                        <div class="form-group">
                            <div class="form mt-4">
                                <div class="form-group row mb-4 align-items-center">
                                    <label for="rtelephone" class="col-3">Teléfono</label>
                                    <input type="number" class="form-control col-8" wire:model="telephone"
                                        id="rtelephone" placeholder="Teléfono" required>
                                    @error('telephone') <span class="text-danger er">{{$message}}</span>@enderror
                                </div>
                            </div>
                            @if(!empty($client))
                            <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="reset"></div>
                            @endif
                            @error('client') <span class="text-danger er">{{$message}}</span>@enderror
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $(".select-client").select2({
            language: "es",
                placeholder: "Buscar cliente",
                minimumInputLength: 2,
                ajax: {
                    url: "{{ route('getClients') }}",
                    dataType: 'json',
                    type: "GET",
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
            let select_val = $("#search_client").val();
                if( select_val != null){
                    Livewire.emit('selectClient',this.value);
                }
        })
    })
</script>

@endpush
