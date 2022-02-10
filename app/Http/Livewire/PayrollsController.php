<?php

namespace App\Http\Livewire;

use App\Models\Delivery;
use App\Models\Payroll;
use App\Models\Sale;
use App\Models\ProcessingArea;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class PayrollsController extends Component
{
    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public $payroll_selected,
        $totalCashInHouse,
        $totalCash,
        $totalSales,
        $series,
        $labels,
        $deliveriesWorked,
        $totalHandy,
        $totalDebts,
        $cashier,
        $zone,
        $initialCash;

    protected $listeners = [
        'confirmClosed' => 'confirmClosed',
        'see' => 'see'
    ];

    public function mount()
    {
        $deliveriesWorked = null;
    }
    public function render()
    {
        $payrolls = Payroll::orderBy('created_at', 'desc')->paginate(10);
        $this->cashiers = User::whereHas("roles", function ($q) {
            $q->where("name", "Caja")->orWhere("name", 'Admin');
        })->get();
        $this->zones = ProcessingArea::all();
        return view('livewire.payrolls.component', [
            'payrolls' => $payrolls
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function createPayroll()
    {
        $this->cashiers = User::whereHas("roles", function ($q) {
            $q->where("name", "Caja");
        })->get();
        $this->zones = ProcessingArea::all();
        $this->emit('openCreatePayrollModal');
    }


    public function initPayroll()
    {
        if ($this->cashier > 0 && $this->zone > 0) {
            $payroll_open = Payroll::where('responsible', Auth()->user()->id)->where('isClosed', 0)->get();
            if ($payroll_open->count() > 0) {
                $this->emit('payroll-open', 'Existe una planilla sin cerrar, para el usuario seleccionado.');
            } else {
                $payroll = Payroll::create([
                    'responsible' => $this->cashier,
                    'zone' => $this->zone,
                    'initialCash' => $this->initialCash
                ]);
                $payroll->save();
            }
        }
    }

    public function newPayroll()
    {
        $payrolls = Payroll::where('isClosed', 0)->get();
        if ($payrolls->count() > 0) {
            $this->emit('payroll-open', 'Existe una planilla sin cerrar, ¿Seguro que deseas abrir una nueva?');
        } else {
            $payroll = Payroll::create([]);
            $payroll->save();
            $this->emit('payroll-opened', 'Planilla iniciada');
        }
    }

    public function closePayroll($id)
    {
        $this->emit('close-payroll', ['id' => $id, 'Msg' => '¿Seguro que deseas cerrar la planilla?']);
    }

    public function see(Payroll $payroll)
    {
        $this->totalSales = $payroll->totalSales;
        $this->emit('see-payroll', 'Show modal');
    }

    public function seepay(Payroll $payroll)
    {
        $xdeliveries = collect([]);
        $deliveriesWorked = DB::table('payrolls')
            ->join('sales', 'payrolls.id', '=', 'sales.payroll_id')
            ->select('sales.delivery_id')
            ->where('payrolls.id', $payroll->id)
            ->where('status', "=", 'Entregado')->distinct()
            ->where('delivery_id', "!=", null)
            ->where('delivery_id', '>', 1)
            ->get();
        foreach ($deliveriesWorked as $delivery) {
            $xDeliery = new DeliveryData();
            $xDeliery->deliveryId = $delivery->delivery_id;
            $xDeliery->deliveryName = Delivery::find($delivery->delivery_id)->name;
            $xDeliery->totalDeliveries = Sale::where('delivery_id', $delivery->delivery_id)
                ->where('payroll_id', $payroll->id)
                ->where('status', 'Entregado')
                ->count();
            $xDeliery->totalRaised = Sale::where('delivery_id', $delivery->delivery_id)
                ->where('payroll_id', $payroll->id)
                ->where('payinhouse', 0)
                ->where('paywithhandy', 0)
                ->where('status', 'Entregado')
                ->where('debt', 0)
                ->sum('total');
            $xdeliveries->push($xDeliery);
        }
        $this->deliveriesWorked = $xdeliveries;
        $this->totalSales = Sale::where('payroll_id', $payroll->id)->where('status', "!=", 'Cancelado')->count();
        $this->payroll_selected = $payroll;
        $this->totalDebts = Sale::where('debt', 1)->where('payroll_id', '=', $payroll->id)->where('paywithhandy', 0)->where('status', 'Entregado')->sum('total');
        $this->totalCashInHouse = Sale::where('payinhouse', 1)->where('payroll_id', '=', $payroll->id)->where('paywithhandy', 0)->where('status', 'Entregado')->sum('total');
        $this->totalCash = Sale::where('payinhouse', 0)->where('payroll_id', '=', $payroll->id)->where('status', 'Entregado')->sum('total');
        $this->totalHandy = Sale::where('paywithhandy', 1)->where('payroll_id', '=', $payroll->id)->where('status', 'Entregado')->sum('total');
        $this->emit('see-payroll', 'Show modal');
    }

    public function confirmClosed($id)
    {
        $payroll = Payroll::where('id', $id)->first();
        if ($payroll) {
            $payroll->dateClosed = date('Y-m-d H:i:s', time());
            $payroll->isClosed = 1;
            $payroll->save();
            $this->payroll_selected = null;
            $this->emit('payroll-closed', 'Planilla cerrada');
        }
    }

    public function resetUI()
    {
    }
}

class DeliveryData
{
    public $deliveryId;
    public $deliveryName;
    public $totalDeliveries;
    public $totalRaised;
}
