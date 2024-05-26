<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Ui\Presets\React;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoices = invoice::FindOrFail($id);
        $details = invoices_details::where("id_invoice", $id)->get();
        $attachment = invoices_attachments::where("invoice_id", $id)->get();

        return view('invoices.details', compact('invoices', 'details', 'attachment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request){
        // Retrieve the ID from the request
        $id = $request->id;

        // Find the invoices attachment by ID
        $invoices = invoices_attachments::find($id);

        // Check if $invoices is not null before attempting to delete
        if ($invoices) {
            // Delete the file from storage
            Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);

            // Delete the invoices_attachments record
            $invoices->delete();

            // Flash success message
            session()->flash('success', 'تم حذف المرفق بنجاح');
        } else {
            // Flash error message if $invoices is null
            session()->flash('success', 'خطأ: المرفق غير موجود');
        }

        // Redirect back to the previous page
        return back();
    }

    public function get_file($invoice_number, $file_name){
        $dir = "Attachments";
        $file = public_path($dir . '/' . $invoice_number . '/' . $file_name);
        return response()->download($file);
    }
    public function view_file($invoice_number, $file_name){
        $dir = "Attachments";
        $file = public_path($dir . '/' . $invoice_number . '/' . $file_name);
        return response()->file($file);
    }
}
