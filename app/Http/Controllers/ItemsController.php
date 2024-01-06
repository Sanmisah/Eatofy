<?php

namespace App\Http\Controllers;
use App\Models\Hotel;
use App\Models\ItemCategory;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index()
    {
        $items = Item::orderBy('id', 'desc')->get();
        return view('items.index', ['items' => $items]);
    }

    public function create()
    {
        $hotels = Hotel::pluck('hotel_name', 'id');        
        $item_categories = ItemCategory::pluck('item_category_name', 'id');       
        return view('items.create')->with(['hotels'=>$hotels, 'item_categories'=>$item_categories]);
    }

    public function store(Item $item, Request $request) 
    {
        $request->validate([
            'name' => 'required|unique:items,name,'.$item->id,
            'hotel_id' => 'required',
            'item_category_id' => 'required',
        ],
        [
            'hotel_id.required' => 'Please select Hotel',
            'item_category_id.required' => 'Please select Category',
        ]); 
        $input = $request->all();      
        $item = Item::create($input); 
        $request->session()->flash('success', 'Item saved successfully!');
        return redirect()->route('items.index'); 
    }
  
    public function show(Item $item)
    {
        //
    }

    public function edit(Item $item)
    {
        $hotels = Hotel::pluck('hotel_name', 'id');        
        $item_categories = ItemCategory::pluck('item_category_name', 'id'); 
        return view('items.edit', ['item' => $item, 'hotels' => $hotels, 'item_categories' => $item_categories]);
    }

    public function update(Item $item, Request $request) 
    {
        $request->validate([
            'name' => 'required|unique:items,name,'.$item->id,
            'hotel_id' => 'required',
            'item_category_id' => 'required',
        ],
        [
            'hotel_id.required' => 'Please select Hotel',
            'item_category_id.required' => 'Please select Category',
        ]);          
        $item->update($request->all());
        $request->session()->flash('success', 'Item updated successfully!');
        return redirect()->route('items.index');
    }
  
    public function destroy(Request $request, Item $item)
    {
        $item->delete();
        $request->session()->flash('success', 'Item deleted successfully!');
        return redirect()->route('items.index');
    }    
}
