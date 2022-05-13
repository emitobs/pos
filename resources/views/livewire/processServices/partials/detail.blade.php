<style>
    .inv-detail {
        min-height: 20vh;
        max-height: 20vh;
        overflow-y: auto;
    }
</style>
<div class="widget widget-account-invoice-one">
    <div class="widget-content">
        <div class="invoice-box">

            <div class="acc-total-info">
                <h5>Total</h5>
                <p class="acc-amount">${{$in->sum('unit_price')}}</p>
            </div>
            <div class="inv-detail">
                @foreach ($in as $key => $item)
                <div class="info-detail-1">
                    <a href="javascript:void(0)" wire:click.prevent="$emit('unselect_product', {{$key}})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </a>
                    <p>{{$item->product->name}}</p>
                    <p>$ {{$item->unit_price}}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
