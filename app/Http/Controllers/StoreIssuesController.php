<?php

namespace App\Http\Controllers;
use App\Models\Hotel;
use App\Models\StoreIssue;
use App\Models\Item;
use App\Models\StoreIssueDetail;
use App\Models\StockLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreIssuesController extends Controller
{
    public function index()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $store_issues = StoreIssue::with('Hotel')->where('hotel_id', auth()->user()->id)->orderBy('id', 'DESC')->get();   
        return view('store_issues.index', ['store_issues' => $store_issues]);
    }

    public function create()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        $items = Item::where('hotel_id', auth()->user()->id)->pluck('name', 'id');
        return view('store_issues.create')->with(['hotels' => $hotels, 'items' => $items]);
    }

    public function store(StoreIssue $store_issue, Request $request) 
    {        
        $input = $request->all(); 
        $store_issue = StoreIssue::create($input);   
        // dd($store_issue); 
        $data = $request->collect('store_issue_details');        
        foreach($data as $record){
            StoreIssueDetail::create([
                'store_issue_id' => $store_issue->id,
                'item' => $record['item'],
                'qty' => $record['qty'],
            ]);            
        }   

        $ledger_data = $request->collect('stock_ledgers');
        foreach($data as $record){
            StockLedger::create([
                'hotel_id' => $store_issue->hotel_id,
                'item_id' => $record['item'],
                'issued' => $record['qty'],
                'model' => 'StoreIssue',
                'foreign_key' => $store_issue->id,
            ]);            
        }

        $request->session()->flash('success', 'Store Issues saved successfully!');
        return redirect()->route('store_issues.index');    
    }
    
    public function show(StoreIssue $store_issue)
    {
       //
    }
  
    public function edit(StoreIssue $store_issue)
    {       
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id');        
        $items = Item::where('hotel_id', auth()->user()->id)->pluck('name', 'id');
        return view('store_issues.edit', ['store_issue' => $store_issue, 'hotels'=>$hotels, 'items'=>$items]); 
    }

    public function update(StoreIssue $store_issue, Request $request) 
    {
        $input = $request->all(); 
        
        $store_issue->update($input);        
        $data = $request->collect('store_issue_details');  
        foreach($data as $record){           
            StoreIssueDetail::upsert([
                'id' => $record['id'] ?? null,
                'store_issue_id' => $store_issue->id,
                'item' => $record['item'],
                'qty' => $record['qty'],
            ],[
                'id'
            ]);
        }

        $stockLedgers = StockLedger::where('foreign_key', $store_issue->id)->where('model', 'StoreIssue')->get();
        foreach($stockLedgers as $row) {
            $row->delete();
        }

        // StockLedger::where('foreign_key', $store_issue->id)->where('model', 'StoreIssue')->delete();    
        $ledger_data = $request->collect('stock_ledgers');
        foreach($data as $record){
            StockLedger::create([
                'hotel_id' => $store_issue->hotel_id,
                'item_id' => $record['item'],
                'issued' => $record['qty'],
                'model' => 'StoreIssue',
                'foreign_key' => $store_issue->id,
            ]);            
        }        

        $request->session()->flash('success', 'Store Issues updated successfully!');
        return redirect()->route('store_issues.index');
    }
  
    public function destroy(Request $request, StoreIssue $store_issue)
    {
        $store_issue->delete();
        $request->session()->flash('success', 'Store Issue deleted successfully!');
        return redirect()->route('store_issues.index');
    }
}
