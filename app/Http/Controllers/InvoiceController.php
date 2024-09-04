<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\invoice;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use App\Models\sections;
use App\Models\User;
use App\Notifications\AddNewInvoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = invoice::with(['section' => function ($data) {
            $data->withTrashed();
        }])->get();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = sections::all();
        return view('invoices.add_invoices', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation logic remains the same
        $data = $request->validate([
            'invoice_number' => 'required|string',
            'invoice_Date' => 'required|date',
            'Due_date' => 'required|date',
            'product' => 'required',
            'section_id' => 'required',
            'Amount_collection' => "required|numeric",
            'Amount_Commission' => 'required|numeric',
            'Discount' => 'nullable|numeric',
            'Value_VAT' => 'required|numeric',
            'Total' => 'required|numeric',
            "note" => "string",
            "pic" => "mimes:pdf,jpeg,jpg,png"
        ]);

        // Add default values
        $data['Status'] = "غير مدفوعة";
        $data['Value_Status'] = 2;
        $data['Rate_VAT'] = $request->Rate_VAT;

        // Insert in Invoice Table
        $invoice = invoice::create($data);

        // Notify the user only once after the invoice is created
        $user = Auth::user(); // Assuming you want to notify the currently logged-in user
        $user->notify(new AddNewInvoices($invoice, "New Invoice Added By: "));
        // Continue with details table logic
        $details_validated = $request->validate([
            'invoice_number' => 'required|string',
            'product' => 'required',
            "note" => "string|required",
        ]);

        $details_validated['id_Invoice'] = $invoice->id;
        $details_validated['Status'] = "غير مدفوعة";
        $details_validated['Value_Status'] = 2;
        $details_validated['Section'] = $request->section_id;
        $details_validated["user"] = Auth::user()->name;

        invoices_details::create($details_validated);

        // Handle the file upload
        if ($request->hasFile('pic')) {
            $image = $request->file('pic');
            $timestamp = time();
            $rand_name = Str::random(10);
            $extension = $image->getClientOriginalExtension();
            $file_name = $timestamp . '_' . $rand_name . '.' . $extension;

            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice->id;
            $attachments->save();

            $image->move(public_path('Attachments/' . $invoice_number), $file_name);
        }

        session()->flash('success', "تم إضافة الفاتورة بنجاح");
        return redirect(url("invoices"));
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoices = invoice::FindOrFail($id);
        $sections = sections::all();

        return view("invoices.status_update", compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = invoice::find($id);
        $sections = sections::all();

        return view("invoices.edit_invoices", compact('sections', 'invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // Define Validation
        $data = $request->validate([
            'invoice_number' => 'required|string',
            'invoice_Date' => 'required|date',
            'Due_date' => 'required|date',
            'product' => 'required',
            'section_id' => 'required',
            'Amount_collection' => "required|numeric",
            'Amount_Commission' => 'required|numeric',
            'Discount' => 'nullable|numeric',
            'Value_VAT' => 'required|numeric',
            'Total' => 'required|numeric',
            "note" => "string",
            "pic" => "mimes:pdf,jpeg,jpg,png"
        ], [
            'invoice_number.required' => 'يرجى ادخال رقم الفاتورة',
            'invoice_Date.required' => 'يرجى ادخال تاريخ الفاتورة',
            'Due_date.required' => 'يرجى ادخال تاريخ الاستحقاق',
            'section_id.required' => 'يرجى اختيار القسم',
            'product.required' => 'يرجى اختيار المنتج',
            'Amount_collection.required' => 'يرجى ادخال ملبغ التحصيل',
            'Amount_collection.numeric' => 'يرجى ادخال ملبغ العمولة بطريقة صحيحة',
            'Amount_Commission.required' => 'يرجى ادخال ملبغ العمولة',
            'Amount_Commission.numeric' => 'يرجى ادخال ملبغ العمولة بطريقة صحيحة',
            'Discount.numeric' => 'يرجى ادخال الخصم بطريقة صحيحة',
        ]);

        // Add default values
        $data['Status'] = "غير مدفوعة";
        $data['Value_Status'] = 2;
        $data['Rate_VAT'] = $request->Rate_VAT;

        // check
        $invoice = invoice::findorFail($id);

        // update in Invoice Table
        $invoice->update($data);

        // Notify the user only once after the invoice is created
        $user = Auth::user(); // Assuming you want to notify the currently logged-in user
        $user->notify(new AddNewInvoices($invoice, "Invoice Updated By:"));

        session()->flash('success', "تم تعديل الفاتورة بنجاح");
        return redirect(url("InvoicesDetails/$id"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $invoice = invoice::findOrFail($id);
        $details = invoices_attachments::where("invoice_id", $id)->first();

        if (!$request->id_page == 2) {

            if (!empty($details->invoice_number)) {
                // Delete the file from storage
                Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
            }
            // Delete the invoices record
            $invoice->forceDelete();
            // Notify the user only once after the invoice is created
            $user = Auth::user(); // Assuming you want to notify the currently logged-in user
            $user->notify(new AddNewInvoices($invoice, "Invoice Deleted By:"));
            session()->flash('success', 'تم حذف الفاتورة بنجاح');
            return redirect()->back();
        } else {

            // Archive the invoices record
            $invoice->delete();
            // Notify the user only once after the invoice is created
            $user = Auth::user(); // Assuming you want to notify the currently logged-in user
            $user->notify(new AddNewInvoices($invoice, "Invoice Archived By:"));
            // Flash success message
            session()->flash('success', 'تم ارشفة الفاتورة بنجاح');
            return redirect('Archive_invoices');
        }
    }


    public function getproducts($id)
    {
        $product = DB::table('products')->where('section_id', $id)->pluck("Product_name", "id");
        return json_encode($product);
    }

    public function status_update($id, Request $request)
    {
        // check id
        $invoice = invoice::findorFail($id);

        // Status is Paied
        if ($request->Status == "مدفوعة") {
            $invoice->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                "Payment_Date" => $request->Payment_Date,
            ]);
            invoices_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        } else {
            $invoice->update([
                'Status' => $request->Status,
                'Value_Status' => 3,
                "Payment_Date" => $request->Payment_Date,
            ]);
            invoices_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        // Notify the user only once after the invoice is created
        $user = Auth::user(); // Assuming you want to notify the currently logged-in user
        $user->notify(new AddNewInvoices($invoice, "Invoice Status updated By:"));


        session()->flash('success', 'تم تحديث حالة الدفع');
        return redirect(url("InvoicesDetails/$id"));
    }

    public function InvoicesPaid()
    {
        $invoices = invoice::where('Value_Status', 1)->get();
        return view('Invoices.invoice_Paid', compact('invoices'));
    }

    public function InvoicesUnPaid()
    {
        $invoices = invoice::where('Value_Status', 2)->get();
        return view('Invoices.Invoice_UnPaid', compact('invoices'));
    }

    public function Invoice_Partial()
    {
        $invoices = invoice::where('Value_Status', 3)->get();
        return view('Invoices.Invoice_Partial', compact('invoices'));
    }

    public function Print_Invoices($id)
    {
        $invoices = invoice::find($id);
        return view("invoices.print_invoices", compact('invoices'));
    }

    public function Excel()
    {
        return Excel::download(new InvoicesExport, 'Invoices.xlsx');
    }

    public function Make_All_Read()
    {
        $notificationsunread = auth()->user()->unreadnotifications;
        if ($notificationsunread) {
            $notificationsunread->markAsRead();
            return back();
        }
    }


}
