<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

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
        ]);     
         
        $input = $request->all();    
        
        $input['name'] = $request->owner_name;
        $input['email'] = $request->email;
        $input['password'] = Hash::make($request->new_password);
        $input['active'] = true;  
        $user = User::create($input); 
        $user->syncRoles('Owner');
        // dd($user);
        $hotel = $user->Hotel()->create($input);
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
        return view('hotels.edit', ['hotel' => $hotel, 'users' => $users]);
    }

    public function update(Hotel $hotel, Request $request) 
    {
        $request->validate([
            'hotel_name' => 'required',
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
}
