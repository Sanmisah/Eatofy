<?php

namespace App\Http\Controllers;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\Table;
use App\Models\Menu;
use App\Models\OrderDetail;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrdersController extends Controller
{
    public function index()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $orders = Order::where('hotel_id', auth()->user()->id)->orderBy('id', 'DESC')->get();   
        return view('orders.index', ['orders' => $orders]);
    }

    public function create()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        $tables = Table::where('hotel_id', auth()->user()->id)->pluck('name', 'id');
        $servers = Server::where('hotel_id', auth()->user()->id)->pluck('name', 'id');
        $menus = Menu::where('hotel_id', auth()->user()->id)->pluck('item_name', 'id');
        return view('orders.create')->with(['hotels' => $hotels, 'tables' => $tables, 'menus' => $menus, 'servers' => $servers]);
    }

    public function store(Order $order, Request $request) 
    {        
        $request->validate([
            'table_id' => 'required',
            'server_id' => 'required',
        ]);
        
        $input = $request->all();
        $order = Order::create($input); 
         
        $data = $request->collect('order_details');
        foreach($data as $record){
            OrderDetail::create([
                'order_id' => $order->id,
                'menu_id' => $record['menu_id'],
                'rate' => $record['rate'],
                'qty' => $record['qty'],
                'instruction' => $record['instruction'],
                'amount' => $record['amount'],
            ]);            
        }   

        $request->session()->flash('success', 'Orders saved successfully!');
        return redirect()->route('orders.index');    
    }
    
    public function show(Order $order)
    {
        //
    }
  
    public function edit(Order $order)
    {       
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        $tables = Table::where('hotel_id', auth()->user()->id)->pluck('name', 'id');
        $servers = Server::where('hotel_id', auth()->user()->id)->pluck('name', 'id');
        $menus = Menu::where('hotel_id', auth()->user()->id)->pluck('item_name', 'id');
        return view('orders.edit', ['order' => $order, 'hotels' => $hotels, 'tables' => $tables, 'menus' => $menus, 'servers' => $servers]); 
    }

    public function update(Order $order, Request $request) 
    {
        $request->validate([
            'table_id' => 'required',
            'server_id' => 'required',
        ]);

        $input = $request->all(); 
        $order->update($input);       
         
        $data = $request->collect('order_details');  

        foreach($data as $record){           
            OrderDetail::upsert([
                'id' => $record['id'] ?? null,
                'order_id' => $order->id,
                'menu_id' => $record['menu_id'],
                'rate' => $record['rate'],
                'qty' => $record['qty'],
                'instruction' => $record['instruction'],
                'amount' => $record['amount'],
            ],[
                'id'
            ]);
        }
        $request->session()->flash('success', 'Order updated successfully!');
        return redirect()->route('orders.index');
    }
  
    public function destroy(Request $request, Order $order)
    {
        $order->delete();
        $request->session()->flash('success', 'Order deleted successfully!');
        return redirect()->route('orders.index');
    }

    public function bill(Order $order)
    {               
        // dd($order->OrderDetails[0]->Menu);
        return view('orders.bill', ['order' => $order]); 
    }

    public function updatePaymentData(Order $order, Request $request) 
    {
        $input = $request->all();
        $input['closed'] = "1";
        $order->update($input);           
        $request->session()->flash('success', 'Payment paid successfully!');
        return redirect()->route('orders.index');
    }

}
