<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Server;
use App\Models\Hotel;

class ServersController extends Controller
{
    public function index()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['hotel_id', auth()->user()->id];
        } 
        $servers = Server::where($conditions)->orderBy('id', 'desc')->get();
        return view('servers.index', ['servers' => $servers]);
    }

    public function create()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id');
        return view('servers.create')->with(['hotels' => $hotels]);
    }

    public function store(Server $server, Request $request) 
    {
        $request->validate([
            'name' => 'required',
        ]); 
        $input = $request->all();      
        $server = Server::create($input); 
        $request->session()->flash('success', 'Server saved successfully!');
        return redirect()->route('servers.index'); 
    }
  
    public function show(Server $server)
    {
        //
    }

    public function edit(Server $server)
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        return view('servers.edit', ['Server' => $server, 'hotels' => $hotels]);
    }

    public function update(Server $server, Request $request) 
    {
        $request->validate([
            'name' => 'required',            
        ]);         
        $server->update($request->all());
        $request->session()->flash('success', 'Server updated successfully!');
        return redirect()->route('servers.index');
    }
  
    public function destroy(Request $request, Server $server)
    {
        $server->delete();
        $request->session()->flash('success', 'Server deleted successfully!');
        return redirect()->route('servers.index');
    }    
}
