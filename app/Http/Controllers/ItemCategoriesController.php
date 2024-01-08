<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemCategory;
use App\Models\Hotel;

class ItemCategoriesController extends Controller
{
    public function index()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['hotel_id', auth()->user()->id];
        } 
        $item_categories = ItemCategory::where($conditions)->orderBy('id', 'desc')->get();
        return view('item_categories.index', ['item_categories' => $item_categories]);
    }

    public function create()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id');
        return view('item_categories.create')->with(['hotels' => $hotels]);
    }

    public function store(ItemCategory $item_category, Request $request) 
    {
        $request->validate([
            'item_category_name' => 'required',
        ]); 
        $input = $request->all();      
        $item_category = ItemCategory::create($input); 
        $request->session()->flash('success', 'Category saved successfully!');
        return redirect()->route('item_categories.index'); 
    }
  
    public function show(ItemCategory $item_category)
    {
        //
    }

    public function edit(ItemCategory $item_category)
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        return view('item_categories.edit', ['item_category' => $item_category, 'hotels' => $hotels]);
    }

    public function update(ItemCategory $item_category, Request $request) 
    {
        $request->validate([
            'item_category_name' => 'required',            
        ]);         
        $item_category->update($request->all());
        $request->session()->flash('success', 'Category updated successfully!');
        return redirect()->route('item_categories.index');
    }
  
    public function destroy(Request $request, ItemCategory $item_category)
    {
        $item_category->delete();
        $request->session()->flash('success', 'Category deleted successfully!');
        return redirect()->route('item_categories.index');
    }    
}
