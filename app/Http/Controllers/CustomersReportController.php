<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomersReportController extends Controller
{
    public function index()
    {
        $sections = sections::all();
        return view('reports.customers_reports', compact("sections"));
    }

    public function getproducts($id)
    {
        $product = DB::table('products')->where('section_id', $id)->pluck("Product_name", "id");
        return json_encode($product);
    }

    public function search(Request $request)
    {
        $sections = sections::all();
        $product = $request->product;

        // في حالة عدم تحديد تاريخ
        if ($product && $request->start_at == "" && $request->end_at == "") {
            $invoices = invoice::select('*')->where('product', '=', $product)->get();
            $product = $request->product;
            return view('reports.customers_reports', compact('product',"sections"))->withDetails($invoices);
        }

        // في حالة تحديد تاريخ
        else {
            $start_at = date($request->strat_at);
            $end_at = date($request->end_at);
            $product = $request->product;

            $invoices = invoice::whereBetween('invoice_Date', [$start_at, $end_at])->where('product', '=', $product)->get();
            return view('reports.customers_reports', compact('product', 'start_at', 'end_at','sections'))->withDetails($invoices);
        }
    }
}
