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
        //user table
        $input['name'] = $request->owner_name;
        $input['email'] = $request->email;
        $input['password'] = Hash::make($request->new_password);
        $input['active'] = true;  
        $user = User::create($input);         
        $user->syncRoles('Owner');  
        //hotel table
        $hotel = $user->Hotel()->create($input);    
        //staff table
        $input['staff_name'] = $request->owner_name;
        $input['contact_no'] = $request->contact_no;
        $input['address'] = $request->address;
        $input['hotel_id'] = $hotel->id;
        $input['role'] = 'Owner';
        $input['email'] = $request['email'];
        $hotelStaff = HotelStaff::create($input);
        // if partner detail add
        if(!empty($request->partner_name) && !empty($request->partner_email) && !empty($request->partner_password)){
            $input['name'] = $request->partner_name;
            $input['email'] = $request->partner_email;
            $input['password'] = Hash::make($request->partner_password);
            $input['active'] = true;  
            $user = User::create($input);         
            $user->syncRoles('Co-owner'); 

            $input['staff_name'] = $request->partner_name;
            $input['contact_no'] = $request->partner_contact_no;
            $input['hotel_id'] = $hotel->id;
            $input['role'] = 'Co-owner';
            $input['email'] = $request['partner_email'];
            $hotelStaff = HotelStaff::create($input);
        }

        $request->session()->flash('success', 'Form saved successfully!');
        return redirect()->route('hotels.index');         
    }
    
    public function show()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        }     
        $hotel = Hotel::where($conditions)->first();

        $users = User::all();
        $staff = HotelStaff::where('hotel_id', $hotel->id)->get();
        $subscription = Subscription::join('packages', 'packages.id', '=', 'subscriptions.package_id')  
            ->where('hotel_id', $hotel->id)       
            ->select('packages.package_name', 'packages.cost', 'subscriptions.*')
            ->orderBy('subscriptions.id', 'desc')
            ->get();
        return view('hotels.show', ['hotel' => $hotel, 'users' => $users, 'staff' => $staff, 'subscription' => $subscription]);
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

    public function updateTagLine(Hotel $hotel, Request $request) 
    {          
        $hotel->update($request->all());    
        $request->session()->flash('success', 'Tagline updated successfully!');
        return redirect()->route('dashboard');
    }
    
}
