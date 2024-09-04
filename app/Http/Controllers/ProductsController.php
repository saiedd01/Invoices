<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections::all();
        $products = Products::with(['section' => function($data) {
            $data->withTrashed();
        }])->get();
        return view('products.products',compact('sections','products'));
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
        $data = $request->validate([
            "Product_name"=>"required|max:255|string",
            'description'=>'required|string',
            'section_id'=>'required|exists:sections,id',
        ],[
            'Product_name.required'=>'يرجى ادخال اسم المنتج',
            'section_id.exists'=>'هذا القسم غير موجود ',
        ]);
        Products::create($data);
        session()->flash('success','تم اضافة المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $pro_id = $request -> pro_id;
        $data= $request->validate([
            "Product_name"=>"required|max:500",
            "description"=>"string",
            // "section_id"=>$section_id
        ],
        [
            "Product_name.required"=>'يرجى ادخال اسم القسم',
            "description.required"=>'يرجى ادخال الوصف',
        ]);

        $section = sections::where('section_name', $request->section_name)->first();
        $section_id = $section ? $section->id : null;

        $data['section_id'] = $section_id;

        $products = Products::findorfail($pro_id);
        $products->update($data);
        session()->flash("success","تم تعديل المنتج");
        return redirect('/products');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $pro_id = $request->pro_id;
        $products = Products::findorfail($pro_id);
        $products->delete();
        session()->flash("success","تم حذف القسم");
        return redirect('/products');
    }
}
