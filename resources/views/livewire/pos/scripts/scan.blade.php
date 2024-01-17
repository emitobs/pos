<script>
    try {
    onScan.attachTo(document,{
        suffixKeyCodes:[13],
        onScan: function(barcode){
            window.livewire.emit('scan-code',barcode);
        },
        onScanError: function(e){
            console.log(e);
        }
    });
} catch (e) {

}
</script>
