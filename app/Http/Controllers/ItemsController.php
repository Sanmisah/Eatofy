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
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['hotel_id', auth()->user()->id];
        }         
        // $items = Item::where($conditions)->orderBy('id', 'desc')->get();
        $items = Item::join('item_categories', 'item_categories.id', '=', 'items.item_category_id')  
            ->where('item_categories.hotel_id',auth()->user()->id)          
            ->select('items.*', 'item_categories.item_category_name')
            ->orderBy('items.id', 'desc')
            ->get();
        return view('items.index', ['items' => $items]);
    }

    public function create()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id');         
        $item_categories = ItemCategory::where('hotel_id', auth()->user()->id)->pluck('item_category_name', 'id');
        return view('items.create')->with(['hotels'=>$hotels, 'item_categories'=>$item_categories]);
    }

    public function store(Item $item, Request $request) 
    {
        $request->validate([
            'name' => 'required',          
            'item_category_id' => 'required',
            'unit' => 'required',
            'opening_qty' => 'required',
        ],
        [           
            'item_category_id.required' => 'Please select Category',
        ]); 
        $input = $request->all();      
        $item = Item::create($input); 
        $request->session()->flash('success', 'Item saved successfully!');
        return redirect()->route('items.index'); 
    }
  
    public function show(Item $item)
    {        
        return $item;  
    }

    public function edit(Item $item)
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id');              
        $item_categories = ItemCategory::where('hotel_id', auth()->user()->id)->pluck('item_category_name', 'id'); 
        return view('items.edit', ['item' => $item, 'hotels' => $hotels, 'item_categories' => $item_categories]);
    }

    public function update(Item $item, Request $request) 
    {

        $request->validate([
            'name' => 'required',
            'item_category_id' => 'required',
            'unit' => 'required',
            'opening_qty' => 'required',
        ],
        [           
            'item_category_id.required' => 'Please select Category',
        ]);          

        $closingQty = $item->getClosingQty($item->id);
        $request->merge(['closing_qty' => $closingQty]);
        
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
