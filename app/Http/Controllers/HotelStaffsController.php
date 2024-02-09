<?php

namespace App\Http\Controllers;
use App\Models\HotelStaff;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class HotelStaffsController extends Controller
{
    public function index()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['hotel_id', auth()->user()->id];
        } 
        $staffs = HotelStaff::where($conditions)->orderBy('id', 'desc')->get();
        return view('hotel_staffs.index', ['staffs' => $staffs]);
    }

    public function create()
    {       
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        return view('hotel_staffs.create')->with(['hotels' => $hotels]);
    }

    public function store(HotelStaff $hotel_staff, Request $request) 
    {
        $request->validate([
            'staff_name' => 'required',
            'contact_no' => 'required',
            'role' => 'required',            
            'address' => 'required',
            'email' => 'required',
            'new_password' => 'required',
        ]);         
        $request->validate(['staff_name' => 'required']);
        $input = $request->all();
        $input['name'] = $request->staff_name;
        $input['email'] = $request->email;
        $input['password'] = Hash::make($request->new_password);
        $input['active'] = true;  
        $user = User::create($input); 
        $user->syncRoles($request->role);
        $hotel_staff = $user->HotelStaff()->create($input);       
        $request->session()->flash('success', 'Staff saved successfully!');
        return redirect()->route('hotel_staffs.index');
    }
  
    public function edit(HotelStaff $hotel_staff)
    {        
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        return view('hotel_staffs.edit', ['hotel_staff' => $hotel_staff, 'hotels' => $hotels]); 
    }

    public function update(HotelStaff $hotel_staff, Request $request) 
    {
        
        $request->validate([
            'staff_name' => 'required',
            'contact_no' => 'required',
            'role' => 'required',            
            'address' => 'required',
           
        ]);         
        $hotel_staff->update($request->all());
        $request->session()->flash('success', 'Staff updated successfully!');
        return redirect()->route('hotel_staffs.index');
    }
  
    public function destroy(Request $request, HotelStaff $hotel_staff)
    {
        $hotel_staff->delete();
        $request->session()->flash('success', 'User deleted successfully!');
        return redirect()->route('hotel_staffs.index');
    }
}
