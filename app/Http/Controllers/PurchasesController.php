<?php

namespace App\Http\Controllers;
use App\Models\Hotel;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Item;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function index()
    {
        $purchases = Purchase::orderBy('id', 'DESC')->get();   
        return view('purchases.index', ['purchases' => $purchases]);
    }

    public function create()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        $suppliers = Supplier::where('hotel_id', auth()->user()->id)->pluck('supplier_name', 'id');
        $items = Item::where('hotel_id', auth()->user()->id)->pluck('name', 'id');
        // dd($items);
        return view('purchases.create')->with(['hotels' => $hotels, 'suppliers' => $suppliers, 'items' => $items]);
    }

    public function store(Purchase $purchase, Request $request) 
    {        
        $input = $request->all();       
        $purchase = Purchase::create($input); 
        $data = $request->collect('purchase_details'); 
        foreach($data as $record){            
            PurchaseDetail::create([
                'purchase_id' => $purchase->id,
                'item' => $record['item'],
                'unit' => $record['unit'],
                'qty' => $record['qty'],
                'rate' => $record['rate'],
                'amount' => $record['amount'],
            ]);            
        }   
        $request->session()->flash('success', 'Purchase saved successfully!');
        return redirect()->route('purchases.index');
    }
    
    public function show(Purchase $purchase)
    {
       //
    }
  
    public function edit(Purchase $purchase)
    {
        //
    }

    public function update(Purchase $purchase, Request $request) 
    {
        //
    }
  
    public function destroy(Request $request, Purchase $purchase)
    {
        $purchase->delete();
        $request->session()->flash('success', 'Purchase deleted successfully!');
        return redirect()->route('purchases.index');
    }
}
