<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Hotel;

class SuppliersController extends Controller
{
    public function index()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['hotel_id', auth()->user()->id];  
        }
        $suppliers = Supplier::where($conditions)->orderBy('id', 'DESC')->get();
        return view('suppliers.index', ['suppliers' => $suppliers]);
    }

    public function create()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id');  
        return view('suppliers.create')->with(['hotels' => $hotels]);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'supplier_name' => 'required',
            'supplier_contact_no' => 'required',
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
        ]);         
        $input = $request->all();
        Supplier::create($input);
        $request->session()->flash('success', 'Supplier saved successfully!');
        return redirect()->route('suppliers.index');         
    }
  
    public function edit(Supplier $supplier)
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id');
        return view('suppliers.edit', ['hotels' => $hotels, 'supplier' => $supplier]);
    }

    public function update(Supplier $supplier, Request $request) 
    {
        $request->validate([
            'supplier_name' => 'required',
            'supplier_contact_no' => 'required',
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
        ]); 
        $supplier->update($request->all());    
        $request->session()->flash('success', 'Supplier updated successfully!');
        return redirect()->route('suppliers.index');
    }
  
    public function destroy(Request $request, Supplier $supplier)
    {
        $supplier->delete();
        $request->session()->flash('success', 'Supplier deleted successfully!');
        return redirect()->route('suppliers.index');
    }
}