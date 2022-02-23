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

class ReportsController extends Component
{
    public $totalSales,
        $totalCash,
        $groupBy,
        $day,
        $month,
        $year = "",
        $yearsWithActivity = [],
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
        $resultado_productos;

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
                        $this->grafica();
                    }
                    break;
                case 'month':
                    $this->year = '';
                    if (!empty($this->month)) {
                        $this->generate_report('month', $this->month);
                        $this->grafica();
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
                        $this->totalCash = $sales->where('status', 'Entregado')->sum('total');
                        $this->totalSales = $sales->where('status', 'Entregado')->count();
                        $this->products = DB::select($this->createQuery($this->year, 0, $category_query));
                        $this->saleByCategory = DB::select($this->createQueryByCategories($this->year));
                        //por cada venta guardo los detalles en detailsCollection
                        $this->createLabelsAndSeriesToApexCharts();
                    }
                    break;
            }
        }

        return view('livewire.reports')->extends('layouts.theme.app')
            ->section('content');;
    }

    public function generate_report($date_option = null, $date)
    {
        $payrolls = [];
        $this->total_sales = 0;
        $this->totalCash = 0;
        switch ($date_option) {
            case 'day':
                $payrolls = Payroll::whereDate('created_at', '=', $date)->get();
                break;
            case 'month':
                $month = explode('-', $this->month);
                $payrolls = Payroll::whereMonth('created_at', '=', $month[1])->whereYear('created_at', $month[0])->get();
                break;
            case 'year':
                $payrolls = Payroll::whereYear('created_at', '=', $date)->get();
                break;
        }

        $resultado_productos = new Collection();
        foreach ($payrolls as $payroll) {
            foreach ($payroll->sales as $sale) {
                $this->totalCash += $sale->total;
                $this->total_sales++;
                foreach ($sale->details as $detail) {
                    if ($resultado_productos->contains('id', $detail->product_id)) {
                        $product_in_collection = $resultado_productos->firstWhere('id', $detail->product_id);
                        $product_in_collection['amount'] += $detail->price;
                        $product_in_collection['quantity'] += $detail->quantity;
                    } else {
                        $product = Product::find($detail->product_id);
                        if ($product) {
                            $product_to_push = new Collection([
                                'id' => $detail->product_id,
                                'product_name' => $product->name,
                                'quantity' => $detail->quantity,
                                'amount' => $detail->price,
                                'product_unit' => $product->unitSale->unit,
                            ]);
                            $resultado_productos->push($product_to_push);
                        }
                    }
                }
            }
        }
        $this->resultado_productos = $resultado_productos->sortBy('quantity');
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

    public function grafica()
    {
        $this->labels = [];
        $this->series = [];
        $this->labelsByCategories = [];
        $this->seriesByCategories = [];
        //$this->total_sales = 0;
        if (count($this->resultado_productos) > 0) {
            foreach ($this->resultado_productos as $product) {
                array_push($this->labels, $product['product_name'] . ' ' . $product['quantity'] . ' ' .  $product['product_unit']);
                array_push($this->series, floatval($product['amount']));
                //$this->total_sales += intval($product['amount']);
            }

            if ($this->total_sales < 1) {
                $this->msgNoSales = 'No hay ventas de esta categoria.';
            }

            $this->emit('loadCharts', [$this->labels, $this->series, $this->labelsByCategories, $this->seriesByCategories]);
        }

        // if (count($this->salesByCategory) > 0) {
        //     foreach ($this->salesByCategory as $saleByCategory) {
        //         array_push($this->labelsByCategories, $saleByCategory->productcategory);
        //         array_push($this->seriesByCategories, intval($saleByCategory->total_quantity));
        //     }
        // }
    }

    public function resetUI()
    {
        $this->day = null;
        $this->month = null;
        $this->year = null;
    }
}
