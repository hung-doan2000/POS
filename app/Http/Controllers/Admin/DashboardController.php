<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getSale()
    {
        $sales = DB::table('sales')->select(DB::raw('sum(money) as totalmoney, month,year'))
            ->groupByRaw('month,year')
            ->orderByRaw('year DESC, month DESC')->take(12)->get();
        $sales1 = DB::table('sales')->select(DB::raw('sum(money) as totalmoney'))
            ->where('store', '=', '1')
            ->groupByRaw('month,year')
            ->orderByRaw('year DESC, month DESC')->take(12)->get();
        $sales2 = DB::table('sales')->select(DB::raw('sum(money) as totalmoney'))
            ->where('store', '=', '2')
            ->groupByRaw('month,year')
            ->orderByRaw('year DESC, month DESC')->take(12)->get();
        $months = [];
        $total_money = [];
        $total_money1 = [];
        $total_money2 = [];
        foreach ($sales as $sale) {
            $money = $sale->totalmoney;
            $month = $sale->month . '/' . $sale->year;
            array_unshift($total_money, $money);
            array_unshift($months, $month);
        }
        foreach ($sales1 as $sale) {
            $money = $sale->totalmoney;
            array_unshift($total_money1, $money);
        }
        foreach ($sales2 as $sale) {
            $money = $sale->totalmoney;
            array_unshift($total_money2, $money);
        }
        return [$months, $total_money, $total_money1, $total_money2];
    }

    public function getMonthYear()
    {
        $select_months = DB::table('sales')->select(DB::raw('month,year'))
            ->groupByRaw('month,year')
            ->orderByRaw('year DESC, month DESC')
            ->get();
        $months = [];
        foreach ($select_months as $month) {
            $a = $month->month . '/' . $month->year;
            array_push($months, $a);
        }
        $select_years = DB::table('sales')->select('year')
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
        $years = [];
        foreach ($select_years as $year) {
            $a = $year->year;
            array_push($years, $a);
        }
        return [$months, $years];
    }

    public function getProductMonth(Request $request)
    {
        if ($request->get('month')) {
            $val = $request->get('month');
            $val1 = explode("/", $val);
            $month = $val1[0];
            $year = $val1[1];
        } else {
            $month = date('m');
            $year = date('Y');
        };
        $products_m = Sale::select(DB::raw('product_id,sold_quantity'))
            ->where(
                [
                    ['month', '=', $month],
                    ['year', '=', $year]
                ]
            )
            ->orderBy('sold_quantity', 'DESC')
            ->take(5)->with(['product'])->get();
        $label_chart = [];
        $data_chart = [];
        foreach ($products_m as $product) {
            $a1 = $product->product->name;
            $a2 = $product->sold_quantity;
            array_push($label_chart, $a1);
            array_push($data_chart, $a2);
        }
        return [$label_chart, $data_chart];
    }

    public function getProductYear(Request $request)
    {
        if ($request->get('year')) {
            $year = $request->get('year');;
        } else {
            $year = date('Y');
        };
        $products_y = DB::table('sales')->select(DB::raw('product_id,sum(sold_quantity) as total_quantity'))
            ->where('year', '=', $year)
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'DESC')

            ->take(5)->get();
        $label_chart = [];
        $data_chart = [];
        foreach ($products_y as $product) {
            $a1 = Product::find($product->product_id);
            $a2 = $product->total_quantity;
            array_push($label_chart, $a1->name);
            array_push($data_chart, $a2);
        }
        return [$label_chart, $data_chart];
    }
}
