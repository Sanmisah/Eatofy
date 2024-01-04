<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;
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
        dd($input);
        $input['name'] = $request->owner_name;
        $input['password'] = Hash::make($request->new_password);
        $input['active'] = true;      
        $input['role'] = 'User';   
        $user = User::create($input); 
        $hotel = $user->Hotel()->create($input);
        $request->session()->flash('success', 'Form saved successfully!');
        return redirect()->route('hotels.index');         
    }
  
    public function edit(Hotel $hotel)
    {
        $users = User::all();
        return view('hotels.edit', ['hotel' => $hotel, 'users' => $users]);
    }

    public function update(Hotel $hotel, Request $request) 
    {
        $input = $request->all();
        $user = User::find($hotel->id);
        $hotel->update($request->all());        
        $new_password = Hash::make($request->new_password);
        if ($user === null)
        {
            $user = new User;
            $user->name = $request->owner_name;
            $user->email = $request->email;
            if($new_password){
                $user->password = $new_password;
            }
            $user->active = true;
            $employee->users()->save($user);
        }
        else
        {
            $user->update([
                'name' => $request->owner_name,
                'email' => $request->email,
                'password' => ($new_password ? $new_password : ''),
                'active' => true,
            ]);
        }
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
