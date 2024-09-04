<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use Illuminate\Http\Request;

class InvoicesReportController extends Controller
{
    public function index()
    {
        return view('reports.invoices_reports');
    }

    public function search(Request $request)
    {
        $radio = $request->radio;

        // في حالة البحث بنوع الفاتورة
        if ($radio == 1) {
            // في حالة عدم تحديد تاريخ
            if ($request->type && $request->start_at == "" && $request->end_at == "") {
                $invoices = invoice::select('*')->where('Status', '=', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices_reports', compact('type'))->withDetails($invoices);
            }
            // في حالة تحديد تاريخ
            else {
                $start_at = date($request->strat_at);
                $end_at = date($request->end_at);
                $type = $request->type;

                $invoices = invoice::whereBetween('invoice_Date', [$start_at, $end_at])->where('Status', '=', $type)->get();
                return view('reports.invoices_reports', compact('type', 'start_at', 'end_at'))->withDetails($invoices);
            }
        }

        // في البحث برقم الفاتورة
        else {
            $invoices = invoice::select('*')->where('invoice_number', $request->invoice_number)->get();
            return view('reports.invoices_reports')->withDetails($invoices);
        }
    }
}
