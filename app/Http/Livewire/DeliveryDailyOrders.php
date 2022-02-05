<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Payroll;
use Livewire\WithPagination;

class DeliveryDailyOrders extends Component
{

    use WithPagination;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public $orders, $selected_delivery;

    public function render()
    {
        $daily_payroll = Payroll::where('isClosed', 0)->first();
        $orders = Sale::where('payroll_id', $daily_payroll->id)->where('delivery_id', $this->selected_delivery)->get();

        return view('livewire.delivery-daily-orders', ['orders' => $orders]);
    }
}
