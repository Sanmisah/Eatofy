<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Hotel;
use App\Models\HotelStaff;
use App\Models\Package;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HotelsController extends Controller
{
    public function index()
    {
        $hotels = Hotel::orderBy('id', 'DESC')->get();   
        return view('hotels.index', ['hotels' => $hotels]);
    }

    public function create()
    {
        return view('hotels.create');
    }

    public function store(Hotel $hotel, Request $request) 
    {        
        $request->validate([
            'hotel_name' => 'required',
            'contact_no' => 'required',
            'state' => 'required',
            'city' => 'required',
            'owner_name' => 'required',
            'owner_contact_no' => 'required',
            'email' => 'required',
            'new_password' => 'required',
        ]);     
         
        $input = $request->all();    
        
        $input['name'] = $request->owner_name;
        $input['email'] = $request->email;
        $input['password'] = Hash::make($request->new_password);
        $input['active'] = true;  
        $user = User::create($input);         
        $user->syncRoles('Owner');      

        $hotel = $user->Hotel()->create($input);    
        
        $input['staff_name'] = $request->owner_name;
        $input['contact_no'] = $request->contact_no;
        $input['address'] = $request->address;
        $input['hotel_id'] = $hotel->id;
        $input['role'] = 'Owner';
        $input['email'] = $request['email'];
        $hotelStaff = HotelStaff::create($input);
        $request->session()->flash('success', 'Form saved successfully!');
        return redirect()->route('hotels.index');         
    }
    
    public function show(HotelStaff $hotel_staff)
    {
       //
    }
  
    public function edit(Hotel $hotel)
    {
        $users = User::all();
        $staff = HotelStaff::where('hotel_id', $hotel->id)->get();
        // $subscription = Subscription::where('hotel_id', $hotel->id)->get();
        $subscription = Subscription::join('packages', 'packages.id', '=', 'subscriptions.package_id')  
            ->where('hotel_id', $hotel->id)       
            ->select('packages.package_name', 'packages.cost', 'subscriptions.*')
            ->orderBy('subscriptions.id', 'desc')
            ->get();
        return view('hotels.edit', ['hotel' => $hotel, 'users' => $users, 'staff' => $staff, 'subscription' => $subscription]);
    }

    public function update(Hotel $hotel, Request $request) 
    {
        $request->validate([
            'hotel_name' => 'required',
            'contact_no' => 'required',
            'state' => 'required',
            'city' => 'required',
            'owner_name' => 'required',
            'owner_contact_no' => 'required',
            'email' => 'required',
            'new_password' => 'required',
        ]);             
        $hotel->update($request->all());    
        $request->session()->flash('success', 'Hotel updated successfully!');
        return redirect()->route('hotels.index');
    }
  
    public function destroy(Request $request, Hotel $hotel)
    {
        $hotel->delete();
        $request->session()->flash('success', 'Hotel deleted successfully!');
        return redirect()->route('hotels.index');
    }

    public function subscription(Request $request, Hotel $hotel)
    {
        $packages = Package::pluck('package_name', 'id');  
        $subscription = Subscription::where('hotel_id', $hotel->id)->orderBy('subscription_date', 'desc')->first();
        return view('hotels.subscription', ['hotel' => $hotel, 'packages' => $packages, 'subscription' => $subscription]);
    }

    public function storeSubscription(Hotel $hotel, Request $request) 
    {
        $input = $request->all();

        if($input['payment_mode'] == 'UPI'){
            $request->validate([                
                'upi_no' => 'numeric',
            ]); 
        }elseif($input['payment_mode'] == "Card"){
            $request->validate([
                'reference_no' => 'numeric',
            ]); 
        }elseif($input['payment_mode'] == "Bank"){
            $request->validate([
                'cheque_no' => 'numeric',
            ]);
        }elseif($input['payment_mode'] == "Cash"){
            $request->validate([
                'package_id' => 'required',
                'payment_mode' => 'required',
                'payment_date' => 'required',
            ]);    
        }else{
            $request->validate([
                'package_id' => 'required',
                'subscription_date' => 'required',
                'payment_mode' => 'required',
                'payment_date' => 'required',
            ]);  
        }   
       
        $input['hotel_id'] = $hotel->id;
        Subscription::create($input); 

        $input['expiry_date'] = $request->expiry_date;
        $hotel->update($input);

        $request->session()->flash('success', 'Subscription Done successfully!');
        return redirect()->route('hotels.index');
    }
}
