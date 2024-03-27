<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportService
{
    /**
     * Obtiene los totales de entrega según el tipo de reporte y el rango de fechas.
     *
     * @param string $reportType Tipo de reporte: 'day', 'month', 'year', 'range'.
     * @param mixed $startDate Fecha de inicio, el formato depende del tipo de reporte.
     * @param mixed $endDate Fecha de fin, requerido solo para reporte de tipo 'range'.
     * @return \Illuminate\Support\Collection
     */
    public function deliveryTotals($reportType, $startDate, $endDate = null)
    {
        $query = DB::table('payments_in')
            ->join('payrolls', 'payments_in.payroll_id', '=', 'payrolls.id')
            ->join('deliveries', 'payments_in.delivery_id', '=', 'deliveries.id')
            ->join('payment_methods', 'payments_in.payment_method_id', '=', 'payment_methods.id')
            ->selectRaw(
                'SUM(payments_in.amount) AS total_amount,
                payments_in.delivery_id,
                deliveries.name AS delivery_name,
                payments_in.payment_method_id,
                payment_methods.name AS payment_method_name,
                COUNT(*) AS total_count'
            );

        $this->applyDateFilter($query, $reportType, $startDate, $endDate);

        $query->groupBy('payments_in.delivery_id', 'payments_in.payment_method_id')->get();
        return $query->groupBy('payments_in.delivery_id', 'payments_in.payment_method_id')->get();
    }

    /**
     * Obtiene los totales de pagos según el tipo de reporte y el rango de fechas.
     *
     * @param string $reportType Tipo de reporte: 'day', 'month', 'year', 'range'.
     * @param mixed $startDate Fecha de inicio, el formato depende del tipo de reporte.
     * @param mixed $endDate Fecha de fin, requerido solo para reporte de tipo 'range'.
     * @return \Illuminate\Support\Collection
     */
    public function totals($reportType, $startDate, $endDate = null)
    {
        $query = DB::table('payments_in')
            ->join('payrolls', 'payments_in.payroll_id', '=', 'payrolls.id')
            ->join('payment_methods', 'payments_in.payment_method_id', '=', 'payment_methods.id')
            ->selectRaw(
                'SUM(payments_in.amount) AS total_amount,
                payments_in.payment_method_id,
                payment_methods.name AS payment_method_name,
                COUNT(*) AS total_count'
            );

        $this->applyDateFilter($query, $reportType, $startDate, $endDate);

        return $query->groupBy('payments_in.payment_method_id')->get();
    }

    /**
     * Aplica filtros de fecha a la consulta basada en el tipo de reporte.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string $reportType
     * @param mixed $startDate
     * @param mixed $endDate
     */
    protected function applyDateFilter(&$query, $reportType, $startDate, $endDate = null)
    {
        switch ($reportType) {
            case 'day':
                $query->whereDate('payrolls.created_at', Carbon::parse($startDate));
                break;
            case 'month':
                $query->whereYear('payrolls.created_at', $startDate[0])
                    ->whereMonth('payrolls.created_at', $startDate[1]);
                break;
            case 'year':
                $query->whereYear('payrolls.created_at', $startDate);
                break;
            case 'range':
                $query->whereBetween('payrolls.created_at', [Carbon::parse($startDate), Carbon::parse($endDate)]);
                break;
        }

        return $query;
    }

    public function getTotalAdeudadoAndCantidadVentas($reportType, $startDate, $endDate = null)
    {
        $queryTotalDebt = DB::table('payrolls')
            ->join('sales', 'payrolls.id', '=', 'sales.payroll_id');
            $this->applyDateFilter($queryTotalDebt, $reportType, $startDate, $endDate);
            $queryTotalDebt->where('sales.debt', 1)
            ->where('sales.remaining', '>', 0);

        // Aquí se corrige: asignamos el resultado de sum() a $totalDebt
        $totalDebt = $queryTotalDebt->sum('sales.remaining');

        $queryCountDebt = DB::table('payrolls')
            ->join('sales', 'payrolls.id', '=', 'sales.payroll_id')
            ->where('sales.debt', 1)
            ->where('sales.remaining', '>', 0);
        $this->applyDateFilter($queryCountDebt, $reportType, $startDate, $endDate);
        $countDebt = $queryCountDebt->count();

        return (object) [
            'totalDebt' => $totalDebt,
            'countDebt' => $countDebt,
        ];
    }

    public function productsSolds($reportType, $startDate, $endDate = null)
    {
        $query = DB::table('payrolls')
            ->join('sales', 'payrolls.id', '=', 'sales.payroll_id')
            ->join('sale_details as sd', 'sales.id', '=', 'sd.sale_id')
            ->join('products as p', 'sd.product_id', '=', 'p.id')
            ->select('sd.product_id', 'p.name as product_name', DB::raw('SUM(sd.quantity) as total_quantity'));
        $this->applyDateFilter($query, $reportType, $startDate, $endDate);

        return $query->groupBy('sd.product_id', 'p.name')
            ->orderByDesc('total_quantity')
            ->get();
    }
}
