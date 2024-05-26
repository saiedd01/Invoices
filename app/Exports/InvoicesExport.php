<?php

namespace App\Exports;

use App\Models\invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoicesExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return invoice::with('section')->get()->map(function($invoice) {
            return [
                'id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'invoice_Date' => $invoice->invoice_Date,
                'Due_date' => $invoice->Due_date,
                'product' => $invoice->product,
                'section_name' => $invoice->section->section_name,
                'Amount_collection' => $invoice->Amount_collection,
                'Amount_Commission' => $invoice->Amount_Commission,
                'Discount' => $invoice->Discount,
                'Value_VAT' => $invoice->Value_VAT,
                'Rate_VAT' => $invoice->Rate_VAT,
                'Total' => $invoice->Total,
                'Status' => $invoice->Status,
                'note' => $invoice->note,
                'Payment_Date' => $invoice->Payment_Date,
            ];
        });

    }

    public function headings(): array
    {
        return [
            'ID',
            'invoice_number',
            'invoice_Date',
            'Due_date',
            'product',
            'section',
            'Amount_collection',
            'Amount_Commission',
            'Discount',
            'Value_VAT',
            'Rate_VAT',
            'Total',
            'Status',
            'note',
            'Payment_Date'
        ];
    }
}
