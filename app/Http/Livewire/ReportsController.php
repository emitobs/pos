<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Payroll;
use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleDetails;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Services\ReportService;

class ReportsController extends Component
{
    public
    $totals,
    $totalSales,
    $totalCash,
    $total_handy,
    $total_cash,
    $total_debts = 0,
    $debts,
    $groupBy,
    $day,
    $month,
    $year = "",
    $yearsWithActivity = [],
    $range = [],
    $start_date,
    $end_date,
    $products = [],
    $labels = [],
    $series = [],
    $labelsByCategories = [],
    $seriesByCategories = [],
    $categories = [],
    $category_selected,
    $msgNoSales,
    $total_sales = 0,
    $salesByCategory = [],
    $resultado_productos,
    $delivery_totals = [],
    $products_sold = [],
    $totalDebt,
    $countDebt;


    protected $reportService;

    public function __construct()
    {
        $this->reportService = new ReportService();
    }

    public function mount()
    {
        $this->groupBy = "day";
        $this->category_selected = "all";
        $this->year = '';
    }
    public function render()
    {
        $this->categories = Category::all();

        $category_query = null;
        if ($this->category_selected != '' && $this->category_selected != "all")
            $category_query = $this->category_selected;

        if ($this->groupBy != null) {
            switch ($this->groupBy) {
                case 'day':
                    if (!empty($this->day)) {
                        $this->generate_report('day', $this->day);
                        //$this->grafica();
                    }
                    break;
                case 'month':
                    $this->year = '';
                    if (!empty($this->month)) {
                        $this->generate_report('month', $this->month);
                        //$this->grafica();
                    }
                    break;
                case 'year':
                    $this->month = '';
                    $datesWithActivity = DB::table('sales')->select('created_at')->get();
                    $this->yearsWithActivity = [];
                    foreach ($datesWithActivity as $date) {
                        $date = Carbon::parse($date->created_at);
                        if (!in_array($date->year, $this->yearsWithActivity)) {
                            array_push($this->yearsWithActivity, $date->year);
                        }
                    }
                    if (!empty($this->year)) {
                        //obtengo las ventas del año
                        $sales = Sale::whereYear('created_at', $this->year)->where('status', 'Entregado')->get();
                        $this->totalCash = $sales->where('status', 'Entregado')->where('debt', 0)->sum('total');
                        $this->totalSales = $sales->where('status', 'Entregado')->count();
                        $this->products = DB::select($this->createQuery($this->year, 0, $category_query));
                        //$this->saleByCategory = DB::select($this->createQueryByCategories($this->year));
                        //por cada venta guardo los detalles en detailsCollection
                        //$this->createLabelsAndSeriesToApexCharts();

                        $this->generate_report('year', $this->year);
                    }
                    break;
                case 'range':
                    if (!empty($this->start_date) && !empty($this->end_date)) {
                        $this->range = array($this->start_date, $this->end_date);
                        $this->generate_report('range', $this->range);
                    }
                    break;

            }
        }

        return view('livewire.reports')->extends('layouts.theme.app')
            ->section('content');
        ;
    }

    public function generate_report($date_option = null, $date)
    {
        $this->total_sales = 0;
        $this->totalCash = 0;
        $start_date = null;
        $end_date = null;
        switch ($date_option) {
            case 'day':
                $start_date = $this->day;
                break;
            case 'month':
                $month = explode('-', $this->month);
                $start_date = $month;
                break;
            case 'year':
                $start_date = $this->year;
                break;
            case 'range':
                $start_date = $this->range[0];
                $end_date = $this->range[1];
        }

        $this->delivery_totals = $this->reportService->deliveryTotals($date_option, $start_date, $end_date);
        $this->totals = $this->reportService->totals($date_option, $start_date, $end_date);
        $this->products_sold = $this->reportService->productsSolds($date_option, $start_date, $end_date);
        $this->salesDue($this->reportService->getTotalAdeudadoAndCantidadVentas($date_option, $start_date, $end_date));
    }

    public function createQuery($year, $month = 0, $day = 0, $category = null)
    {
        $query = "
                    SELECT h.name AS 'productcategory', pr.id, pr.name, RESULT.total_quantity FROM products pr JOIN categories h ON h.id = pr.category_id LEFT JOIN
                    (SELECT SUM(sd.quantity) AS 'total_quantity', sd.product_id FROM sale_details sd
                                                JOIN sales s ON sd.sale_id = s.id
                                                WHERE YEAR(s.created_at) = " . $year . "
                ";

        if ($month > 0)
            $query .= "
            AND MONTH(s.created_at) = " . $month;

        if ($day > 0)
            $query .= "
        AND DAY(s.created_at) = " . $day;

        $query .= "
                                                AND s.status = 'Entregado'
                                                GROUP BY sd.product_id) AS RESULT ON pr.id = RESULT.product_id
        ";

        if (!empty($category)) {
            $query .= " WHERE h.name = '" . $category . "'";
        } else {
            $query .= " WHERE h.name <> 'INGREDIENTES'";
        }

        return $query;
    }

    public function createQueryByCategories($year, $month = 0, $day = 0)
    {
        $query = "
        SELECT productcategory, sum(total_quantity) as total_quantity FROM (SELECT h.name AS 'productcategory', pr.id, pr.name, RESULT.total_quantity FROM products pr JOIN categories h ON h.id = pr.category_id LEFT JOIN
        (SELECT SUM(sd.quantity) AS 'total_quantity', sd.product_id FROM sale_details sd
                                    JOIN sales s ON sd.sale_id = s.id
                                    WHERE YEAR(s.created_at) = " . $year . " ";

        if ($month > 0)
            $query .= "
            AND MONTH(s.created_at) = " . $month;

        if ($day > 0)
            $query .= "
            AND DAY(s.created_at) = " . $day;

        $query .= "
         AND s.status = 'Entregado'
        GROUP BY sd.product_id) AS RESULT ON pr.id = RESULT.product_id WHERE h.name <> 'INGREDIENTES') AS a GROUP BY productcategory";

        return $query;
    }

    public function createLabelsAndSeriesToApexCharts2()
    {
        $this->labels = [];
        $this->series = [];
        $this->labelsByCategories = [];
        $this->seriesByCategories = [];
        //$this->total_sales = 0;
        if (count($this->products) > 0) {
            foreach ($this->products as $product) {
                array_push($this->labels, $product->name);
                array_push($this->series, intval($product->total_quantity));
                //$this->total_sales += $product->total_quantity;
            }

            if ($this->total_sales < 1) {
                $this->msgNoSales = 'No hay ventas de esta categoria.';
            }

            $this->emit('loadCharts', [$this->labels, $this->series, $this->labelsByCategories, $this->seriesByCategories]);
        }

        if (count($this->salesByCategory) > 0) {
            foreach ($this->salesByCategory as $saleByCategory) {
                array_push($this->labelsByCategories, $saleByCategory->productcategory);
                array_push($this->seriesByCategories, intval($saleByCategory->total_quantity));
            }
        }
    }

    // public function grafica()
    // {
    //     $this->labels = [];
    //     $this->series = [];
    //     $this->labelsByCategories = [];
    //     $this->seriesByCategories = [];
    //     //$this->total_sales = 0;
    //     if (count($this->resultado_productos) > 0) {
    //         foreach ($this->resultado_productos as $product) {
    //             array_push($this->labels, $product['product_name'] . ' ' . $product['quantity'] . ' ' . $product['product_unit']);
    //             array_push($this->series, floatval($product['amount']));
    //             //$this->total_sales += intval($product['amount']);
    //         }

    //         if ($this->total_sales < 1) {
    //             $this->msgNoSales = 'No hay ventas de esta categoria.';
    //         }

    //         $this->emit('loadCharts', [$this->labels, $this->series, $this->labelsByCategories, $this->seriesByCategories]);
    //     }

    //     // if (count($this->salesByCategory) > 0) {
    //     //     foreach ($this->salesByCategory as $saleByCategory) {
    //     //         array_push($this->labelsByCategories, $saleByCategory->productcategory);
    //     //         array_push($this->seriesByCategories, intval($saleByCategory->total_quantity));
    //     //     }
    //     // }
    // }


    public function resetUI()
    {
        $this->day = null;
        $this->month = null;
        $this->year = null;
        $this->delivery_totals = null;
        $this->totals = null;
        $this->products_sold = null;
    }

    public function getTotales($date_init, $date_end = null, $report_type)
    {
        switch ($report_type) {
            case 'day':
                $this->totals = DB::table('payment_methods')
                    ->join('payments_in', 'payments_in.payment_method_id', '=', 'payment_methods.id')
                    ->select(
                        'payment_methods.name',
                        DB::raw('SUM(payments_in.amount) AS Total'),
                        DB::raw('COUNT(payments_in.id) AS PaymentCount')
                    )
                    ->where('payments_in.created_at', $date_init)
                    ->groupBy('payment_methods.name')
                    ->get();
                break;
            case 'range':
                $this->totals = DB::table('payment_methods')
                    ->join('payments_in', 'payments_in.payment_method_id', '=', 'payment_methods.id')
                    ->select(
                        'payment_methods.name',
                        DB::raw('SUM(payments_in.amount) AS Total'),
                        DB::raw('COUNT(payments_in.id) AS PaymentCount')
                    )
                    ->whereBetween('payments_in.created_at', [$date_init, $date_end])
                    ->groupBy('payment_methods.name')
                    ->get();
                break;
            default:
                $this->totals = DB::table('payment_methods')
                    ->join('payments_in', 'payments_in.payment_method_id', '=', 'payment_methods.id')
                    ->select(
                        'payment_methods.name',
                        DB::raw('SUM(payments_in.amount) AS Total'),
                        DB::raw('COUNT(payments_in.id) AS PaymentCount')
                    )
                    ->whereBetween('payments_in.created_at', [$date_init, $date_end])
                    ->groupBy('payment_methods.name')
                    ->get();
                break;
        }
    }

    public function deliveryTotals()
    {
        $query = DB::table('payments_in')
            ->join('payrolls', 'payments_in.payroll_id', '=', 'payrolls.id')
            ->join('deliveries', 'payments_in.delivery_id', '=', 'deliveries.id')
            ->join('payment_methods', 'payments_in.payment_method_id', '=', 'payment_methods.id')
            ->selectRaw('SUM(payments_in.amount) AS total_amount,
         payments_in.delivery_id,
         deliveries.name AS delivery_name,
         payments_in.payment_method_id,
         payment_methods.name AS payment_method_name,
         COUNT(*) AS total_count');

        if ($this->groupBy == 'day') {
            $query->whereDate('payrolls.created_at', $this->day);
        } elseif ($this->groupBy == 'month') {
            $query->whereMonth('payrolls.created_at', $this->month);
        } elseif ($this->groupBy == 'year') {
            $query->whereYear('payrolls.created_at', $this->year);
        } elseif ($this->groupBy == 'range') {
            $query->whereBetween('payrolls.created_at', [$startDate, $endDate]);
        }

        $this->delivery_totals = $query->groupBy('payments_in.delivery_id', 'payments_in.payment_method_id')
            ->get();
    }

    public function totals()
    {
        $query = DB::table('payments_in')
            ->join('payrolls', 'payments_in.payroll_id', '=', 'payrolls.id')
            ->join('payment_methods', 'payments_in.payment_method_id', '=', 'payment_methods.id')
            ->selectRaw('CAST (SUM(payments_in.amount) AS DECIMAL(10,2)) AS total_amount,
         payments_in.payment_method_id,
         payment_methods.name AS payment_method_name,
         COUNT(*) AS total_count');

        if ($this->groupBy == 'day') {
            $query->whereDate('payrolls.created_at', $this->day);
        } elseif ($this->groupBy == 'month') {
            $query->whereMonth('payrolls.created_at', $this->month);
        } elseif ($this->groupBy == 'year') {
            $query->whereYear('payrolls.created_at', $this->year);
        } elseif ($this->groupBy == 'range') {
            $query->whereBetween('payrolls.created_at', [$startDate, $endDate]);
        }

        $this->totals = $query->groupBy('payments_in.payment_method_id')
            ->get();
    }

    public function prodcutsSold()
    {

        $this->products_sold = DB::table('payrolls')
            ->join('sales', 'payrolls.id', '=', 'sales.payroll_id')
            ->join('sale_details as sd', 'sales.id', '=', 'sd.sale_id')
            ->join('products as p', 'sd.product_id', '=', 'p.id')
            ->select('sd.product_id', 'p.name as product_name', DB::raw('SUM(sd.quantity) as total_quantity'))
            ->whereBetween('payrolls.created_at', ['2024-02-11 00:00:00', '2024-02-11 23:59:59'])
            ->groupBy('sd.product_id', 'p.name')
            ->orderByDesc('total_quantity')
            ->get();
    }

    public function salesDue($debts)
    {
        $this->totalDebt = $debts->totalDebt;
        $this->countDebt = $debts->countDebt;

    }
}
