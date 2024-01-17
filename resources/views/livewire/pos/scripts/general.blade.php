<script>
    document.addEventListener('DOMContentLoaded',function(){
        $("#selected_product").select2({
                placeholder: "Buscar producto",
                minimumInputLength: 2,
                ajax: {
                    url: "{{ route('getProducts') }}",
                    dataType: 'json',
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(term) {
                        return {
                            term: term,
                            zone: "{{$payroll->zone}}"
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
        $("#selected_product").on('change',function(){
            if($("#selected_product").val() !== null){
            @this.set('select_product',this.value);
            Livewire.emit('select_product');
            $('#quantity').focus();
            }
        })
    });
    $("#addPayModal").on('shown.bs.modal', function(){
        $("#payment_method_selected").select2('open');
    })    
    $("#payment_method_selected").on('select2:close', function (e) {
        @this.set('payment_method_selected', $("#payment_method_selected").val());
        $("#amount").val(@this.total_result);
        @this.set('amount',@this.total_result);
        $("#amount").focus().select();
    });
</script>