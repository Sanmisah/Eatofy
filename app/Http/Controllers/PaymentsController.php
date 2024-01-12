<?php

namespace App\Http\Controllers;
use App\Models\Hotel;
use App\Models\Purchase;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $payments = Payment::orderBy('id', 'DESC')->get();   
        return view('payments.index', ['payments' => $payments]);
    }

    public function create(Payment $payment, Request $request)
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        $suppliers = Supplier::where('hotel_id', auth()->user()->id)->pluck('supplier_name', 'id'); 
        // $purchase = Purchase::with(['Supplier'])->where('hotel_id', auth()->user()->id)->get(); 
        // dd($purchase);
        return view('payments.create')->with(['hotels' => $hotels, 'suppliers' => $suppliers]);        
    }

    public function store(Payment $payment, Request $request) 
    {        
        $input = $request->all(); 
        $payment = Payment::create($input); 
        
        $data = $request->collect('payment_details');
        foreach($data as $record){
            PaymentDetail::create([
                'payment_id' => $payment->id,
                'purchase_id' => $record['purchase_id'],
                'paid_amount' => $record['paid_amount'],
            ]);            
        }   
        $request->session()->flash('success', 'Payments saved successfully!');
        return redirect()->route('payments.index');    
    }
    
    public function show(Payment $payment)
    {
       //
    }
  
    public function edit(Payment $payment)
    {       
        //
    }

    public function update(Payment $payment, Request $request) 
    {
        //
    }
  
    public function destroy(Request $request, Payment $payment)
    {      
        $payment->delete();
        $request->session()->flash('success', 'Payment deleted successfully!');
        return redirect()->route('payments.index');
    }

}
