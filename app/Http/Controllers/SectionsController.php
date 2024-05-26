<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections::all();
        return view('sections.section')->with('sections',$sections);
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
        //validation
        $data = $request->validate([
            'section_name'=>"required|unique:sections,section_name|string|max:500",
            'description'=>"required",
         ]
        ,[
            "section_name.required"=>'يرجى ادخال اسم القسم',
            "section_name.unique"=>'هذا الاسم موجود بالفعل',
            "description.required"=>'يرجى ادخال الوصف'
        ]
    );


            sections::create([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'Created_by'=>(Auth::user()->name),
            ]);
        session()->flash("success","تم إضافة القسم");
        return redirect("/sections");
    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request -> id;
        $data= $request->validate([
            "section_name"=>"required|max:500|unique:sections,section_name,".$id,
            "description"=>"required",
        ],
        [
            "section_name.required"=>'يرجى ادخال اسم القسم',
            "description.required"=>'يرجى ادخال الوصف'
        ]);

        $section = sections::findorfail($id);
        $section->update($data);
        session()->flash("success","تم تعديل القسم");
        return redirect("/sections");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $sections = sections::findorfail($id);
        $sections->delete();
        session()->flash("success","تم حذف القسم");
        return redirect('/sections');
    }
}
