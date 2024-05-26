<?php

namespace App\Http\Controllers;

use App\Models\invoices_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class InvoicesAttachmentsController extends Controller
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
        $this->validate($request,[
        'file_name'=>'mimes:png,jpg,pdf,jpeg',
        ],[
            'file_name.mimes'=>'الملف يجب ان يكون من نوع pdf او jpg او png او jpeg',
        ]);

        // Get the uploaded image file
        $image = $request->file('file_name');

        // Generate a timestamp-based file name
        $timestamp = time(); // Current timestamp
        $rand_name = Str::random(10); // Create Random name
        $extension = $image->getClientOriginalExtension(); // Get the original file extension
        $file_name = $timestamp.'_'.$rand_name . '.' . $extension; // Construct the new file name

        $invoice_number = $request->invoice_number;
        $invoice_id = $request->invoice_id;

        // $attachment = new invoices_attachments;
        // $attachment->invoice_number = $invoice_number;
        // $attachment->file_name = $file_name;
        // $attachment->save();
        // $image->move(public_path('uploads/invoices_attachments'), $file_name);
        // return redirect()->back()->with('success','تم اضافة المرفق بنجاح');

        // Create a new invoices_attachments record
        $attachments = new invoices_attachments();
        $attachments->file_name = $file_name;
        $attachments->invoice_number = $invoice_number;
        $attachments->Created_by = Auth::user()->name;
        $attachments->invoice_id = $invoice_id;
        $attachments->save();

        // Move the uploaded image to the attachments folder
        $image->move(public_path('Attachments/' . $invoice_number), $file_name);

        session()->flash('success', "تم إضافة المرفق بنجاح");
        return back();

    }

    /**
     * Display the specified resource.
     */
    public function show(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoices_attachments $invoices_attachments)
    {
        //
    }
}
