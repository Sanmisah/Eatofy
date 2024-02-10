<?php

namespace App\Http\Controllers;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TeamsController extends Controller
{
    public function index()
    {       
        $teams = Team::orderBy('id', 'desc')->get();
        return view('teams.index', ['teams' => $teams]);
    }

    public function create()
    {       
        return view('teams.create');
    }

    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required',
            'contact_no' => 'required',
            'role' => 'required',            
            'address' => 'required',
            'email' => 'required',
            'new_password' => 'required',
        ]); 

        $input = $request->all();
        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $input['password'] = Hash::make($request->new_password);
        $input['active'] = true;  

        $user = User::create($input); 
        $user->syncRoles($request->role);
        $user->Team()->create($input);       
        $request->session()->flash('success', 'Team saved successfully!');
        return redirect()->route('teams.index');
    }
  
    public function edit(Team $team)
    {  
        return view('teams.edit', ['team' => $team]); 
    }

    public function update(Team $team, Request $request) 
    {        
        $request->validate([
            'name' => 'required',
            'contact_no' => 'required',
            'role' => 'required',           
        ]);         
        $team->update($request->all());
        $request->session()->flash('success', 'Team updated successfully!');
        return redirect()->route('teams.index');
    }
  
    public function destroy(Request $request, Team $team)
    {
        $team->delete();
        $request->session()->flash('success', 'Team deleted successfully!');
        return redirect()->route('teams.index');
    }
}
