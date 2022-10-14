<script>
    document.addEventListener('DOMContentLoaded',function(){
        $("#selected_product").select2({
                placeholder: "Search product",
                minimumInputLength: 2,
                ajax: {
                    url: "{{ route('getProducts') }}",
                    dataType: 'json',
                    type: "POST",
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
                        console.log(data);
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
            @this.set('select_product',this.value);
            Livewire.emit('select_product');
            $('#quantity').focus();
        })
    });
</script>