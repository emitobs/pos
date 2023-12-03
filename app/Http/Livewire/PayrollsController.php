<?php

namespace App\Http\Livewire;

use App\Models\Delivery;
use App\Models\Payroll;
use App\Models\Sale;
use App\Models\ProcessingArea;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    $initialCash,
    $totals,
    $cashiers,
    $zones,
    $reportesDeDeliveries,
    $chargers,
    $orders_delivered;

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
        if ($this->cashier > 0) {
            $payroll_open = Payroll::where('responsible', $this->cashier)->where('isClosed', 0)->get();
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

    public function viewPayroll(Payroll $payroll)
    {
        $this->payroll_selected = $payroll;

        $deliveriesQueTrabajaron = DB::table('payrolls')
            ->join('sales', 'payrolls.id', '=', 'sales.payroll_id')
            ->select('sales.delivery_id')
            ->where('payrolls.id', $payroll->id)
            ->where('status', "=", 'Entregado')->distinct()
            ->where('delivery_id', "!=", null)
            ->get();

        $reportesDeLosDeliveriesQueTrabajaron = [];
        foreach ($deliveriesQueTrabajaron as $deliveryQueTrabajo) {
            $infoBD_delivery = Delivery::find($deliveryQueTrabajo->delivery_id);
            $cobrosDelDelivery = $infoBD_delivery->payments_in->where('payroll_id', $this->payroll_selected->id);

            $metodosDePagosUtilizadosEnLosCobros = [];
            foreach ($cobrosDelDelivery as $cobroDelDelivery) {
                if (isset($metodosDePagosUtilizadosEnLosCobros[$cobroDelDelivery->payment_method_id])) {
                    $metodosDePagosUtilizadosEnLosCobros[$cobroDelDelivery->payment_method_id]['total'] += $cobroDelDelivery->amount;
                    $metodosDePagosUtilizadosEnLosCobros[$cobroDelDelivery->payment_method_id]['chargers']++;
                } else {
                    $metodosDePagosUtilizadosEnLosCobros[$cobroDelDelivery->payment_method_id] = ['name' => $cobroDelDelivery->payment_method->name, 'total' => $cobroDelDelivery->amount, 'chargers' => 1];
                }
            }
            $reportesDeLosDeliveriesQueTrabajaron[$infoBD_delivery->id] = [
                'delivery_name' => $infoBD_delivery->name,
                'reportes' => $metodosDePagosUtilizadosEnLosCobros,
                'orders_delivered' => $infoBD_delivery->sales->where('payroll_id', $payroll->id)->where('status', 'Entregado')->count()
            ];
        }
        $this->reportesDeDeliveries = $reportesDeLosDeliveriesQueTrabajaron;
        $this->totals = DB::table('payment_methods')
            ->join('payments_in', 'payments_in.payment_method_id', '=', 'payment_methods.id')
            ->select('payment_methods.name', DB::raw('SUM(payments_in.amount) AS Total'), DB::raw('COUNT(payments_in.id) AS NumberOfPayments'))
            ->where('payments_in.payroll_id', $payroll->id)
            ->groupBy('payment_methods.name')
            ->get();

        $this->chargers = $payroll->payments_in->count();
        $this->orders_delivered = $payroll->sales->where('status', 'Entregado')->count();
        $this->emit('see-payroll', 'Show modal');
    }

    public function confirmClosed($id)
    {
        $payroll = Payroll::where('id', $id)->first();
        if ($payroll) {
            if ($payroll->sales->where('status', '!=', 'Cancelado')->where('status', '!=', 'Entregado')->count() > 0) {
                $this->emit('error', 'Aun hay pedidos sin finalizar.');
            } else {
                $payroll->dateClosed = date('Y-m-d H:i:s', time());
                $payroll->isClosed = 1;
                $payroll->save();
                $this->payroll_selected = null;
                $this->emit('payroll-closed', 'Planilla cerrada');
            }
        }
    }

    public function resetUI()
    {
    }
}
