<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Hotel;

class SectionsController extends Controller
{
     public function index()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['hotel_id', auth()->user()->id];
        } 
        $sections = Section::where($conditions)->orderBy('id', 'desc')->get();
        return view('sections.index', ['sections' => $sections]);
    }

    public function create()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id');
        return view('sections.create')->with(['hotels' => $hotels]);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'section_name' => 'required',
        ]); 
        $input = $request->all();      
        Section::create($input); 
        $request->session()->flash('success', 'Section saved successfully!');
        return redirect()->route('sections.index'); 
    }
  
    public function show(Section $section)
    {
        //
    }

    public function edit(Section $section)
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        return view('sections.edit', ['section' => $section, 'hotels' => $hotels]);
    }

    public function update(Section $section, Request $request) 
    {
        $request->validate([
            'section_name' => 'required',            
        ]);         
        $section->update($request->all());
        $request->session()->flash('success', 'Section updated successfully!');
        return redirect()->route('sections.index');
    }
  
    public function destroy(Request $request, Section $section)
    {
        $section->delete();
        $request->session()->flash('success', 'Section deleted successfully!');
        return redirect()->route('sections.index');
    }    
}
