<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function store(Request $request) 
    {
        
        $request->validate([
            'hotel_name' => 'required',
        ]);     
         
        $input = $request->all();    
        dd($input);
        $input['name'] = $request->owner_name;
        $input['password'] = Hash::make($request->new_password);
        $input['active'] = true;      
        $input['role'] = 'User';   
        $user = User::create($input); 
        $user->Hotel()->create($input);
        $request->session()->flash('success', 'Form saved successfully!');
        return redirect()->route('hotels.index');         
    }
  
    public function edit(Hotel $hotel)
    {
        
    }

    public function update(Hotel $hotel, Request $request) 
    {
        
    }
  
    public function destroy(Request $request, Hotel $hotel)
    {
       
    }
}
