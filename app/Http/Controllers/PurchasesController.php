<?php

namespace App\Http\Controllers;
use App\Models\Hotel;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Item;
use App\Models\PurchaseDetail;
use App\Models\StockLedger;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function index()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $purchases = Purchase::with('Supplier')->where('hotel_id', auth()->user()->id)->orderBy('id', 'DESC')->get();   
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

        if($request->hasFile('attachment') && $request->file('attachment')->isValid()){
            $purchase->addMediaFromRequest('attachment')->toMediaCollection('attachment');
        }
        // $model_name = getModelByTablename('purchases');  
        $data = $request->collect('purchase_details');
        foreach($data as $record){
            PurchaseDetail::create([
                'purchase_id' => $purchase->id,
                'item' => $record['item'],
                'unit' => $record['unit'],
                'rate' => $record['rate'],
                'qty' => $record['qty'],
                'amount' => $record['amount'],
            ]);            
        }   

        $ledger_data = $request->collect('stock_ledgers');
        foreach($data as $record){
            StockLedger::create([
                'hotel_id' => $purchase->hotel_id,
                'item_id' => $record['item'],
                'received' => $record['qty'],
                'model' => 'Purchase',
                'foreign_key' => $purchase->id,
            ]);            
        }

        $request->session()->flash('success', 'Purchases saved successfully!');
        return redirect()->route('purchases.index');    
    }
    
    public function show(Purchase $purchase)
    {
       dd('hiiiiii'); exit;
    }
  
    public function edit(Purchase $purchase)
    {       
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        $suppliers = Supplier::where('hotel_id', auth()->user()->id)->pluck('supplier_name', 'id');
        $items = Item::where('hotel_id', auth()->user()->id)->pluck('name', 'id');
        return view('purchases.edit', ['purchase' => $purchase, 'hotels'=>$hotels, 'suppliers'=>$suppliers, 'items'=>$items]); 
    }

    public function update(Purchase $purchase, Request $request) 
    {
        $input = $request->all(); 
        $purchase->update($input);       
         
        $data = $request->collect('purchase_details');  

        foreach($data as $record){           
            PurchaseDetail::upsert([
                'id' => $record['id'] ?? null,
                'purchase_id' => $purchase->id,
                'item' => $record['item'],
                'unit' => $record['unit'],
                'rate' => $record['rate'],
                'qty' => $record['qty'],
                'amount' => $record['amount'],
            ],[
                'id'
            ]);
        }

        $stockLedgers = StockLedger::where('foreign_key', $purchase->id)->where('model', 'Purchase')->get();
        foreach($stockLedgers as $row) {
            $row->delete();
        }

        $ledger_data = $request->collect('stock_ledgers');
        foreach($data as $record){
            StockLedger::create([
                'hotel_id' => $purchase->hotel_id,
                'item_id' => $record['item'],
                'received' => $record['qty'],
                'model' => 'Purchase',
                'foreign_key' => $purchase->id,
            ]);            
        }       

        $request->session()->flash('success', 'Purchases updated successfully!');
        return redirect()->route('purchases.index');
    }
  
    public function destroy(Request $request, Purchase $purchase)
    {
        $stockLedgers = StockLedger::where('foreign_key', $purchase->id)->where('model', 'Purchase')->get();
        foreach($stockLedgers as $row) {
            $row->delete();
        }
        
        $purchase->delete();

        $request->session()->flash('success', 'Purchase deleted successfully!');
        return redirect()->route('purchases.index');
    }

}
