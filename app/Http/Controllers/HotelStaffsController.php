<?php

namespace App\Http\Controllers;
use App\Models\HotelStaff;
use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Http\Controllers\DB;

class HotelStaffsController extends Controller
{
    public function index()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'User'){                       
            $conditions[] = ['hotel_id', auth()->user()->id];
        } 
        $staffs = HotelStaff::where($conditions)->orderBy('id', 'desc')->get();
        return view('hotel_staffs.index', ['staffs' => $staffs]);
    }

    public function create()
    {       
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'User'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        return view('hotel_staffs.create')->with(['hotels' => $hotels]);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'staff_name' => 'required',
            'hotel_id' => 'required',
        ],
        [
            'hotel_id.required' => 'Please select Hotel',
        ]);
        $input = $request->all();
        HotelStaff::create($input);          
        $request->session()->flash('success', 'Staff saved successfully!');
        return redirect()->route('hotel_staffs.index');
    }
  
    public function edit(HotelStaff $hotel_staff)
    {        
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'User'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        return view('hotel_staffs.edit', ['hotel_staff' => $hotel_staff, 'hotels' => $hotels]); 
    }

    public function update(HotelStaff $hotel_staff, Request $request) 
    {
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
