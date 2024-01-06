<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemCategory;
use App\Models\Hotel;

class ItemCategoriesController extends Controller
{
    public function index()
    {
        $item_categories = ItemCategory::orderBy('id', 'desc')->get();
        return view('item_categories.index', ['item_categories' => $item_categories]);
    }

    public function create()
    {
        $hotels = Hotel::pluck('hotel_name', 'id');  
        return view('item_categories.create')->with(['hotels' => $hotels]);
    }

    public function store(ItemCategory $item_category, Request $request) 
    {
        $request->validate([
            'item_category_name' => 'required',
            'hotel_id' => 'required',
        ],
        [
            'hotel_id.required' => 'Please select Hotel',
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
        $hotels = Hotel::pluck('hotel_name', 'id'); 
        return view('item_categories.edit', ['item_category' => $item_category, 'hotels' => $hotels]);
    }

    public function update(ItemCategory $item_category, Request $request) 
    {
        $request->validate([
            'item_category_name' => 'required',
            'hotel_id' => 'required',
        ],
        [
            'hotel_id.required' => 'Please select Hotel',
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
