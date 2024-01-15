<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Hotel;

class TablesController extends Controller
{
    public function index()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['hotel_id', auth()->user()->id];
        } 
        $tables = Table::where($conditions)->orderBy('id', 'desc')->get();
        return view('tables.index', ['tables' => $tables]);
    }

    public function create()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id');
        return view('tables.create')->with(['hotels' => $hotels]);
    }

    public function store(Table $table, Request $request) 
    {
        $request->validate([
            'name' => 'required',
        ]); 
        $input = $request->all();      
        $table = Table::create($input); 
        $request->session()->flash('success', 'Table saved successfully!');
        return redirect()->route('tables.index'); 
    }
  
    public function show(Table $table)
    {
        //
    }

    public function edit(Table $table)
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        return view('tables.edit', ['table' => $table, 'hotels' => $hotels]);
    }

    public function update(Table $table, Request $request) 
    {
        $request->validate([
            'name' => 'required',            
        ]);         
        $table->update($request->all());
        $request->session()->flash('success', 'Table updated successfully!');
        return redirect()->route('tables.index');
    }
  
    public function destroy(Request $request, Table $table)
    {
        $table->delete();
        $request->session()->flash('success', 'Table deleted successfully!');
        return redirect()->route('tables.index');
    }    
}
