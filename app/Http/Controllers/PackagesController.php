<?php

namespace App\Http\Controllers;
use App\Models\Package;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('id', 'DESC')->get(); 
        return view('packages.index', ['packages' => $packages]);
    }

    public function create()
    {     
        return view('packages.create');
    }

    public function store(Request $request) 
    {
        $request->validate([
            'package_name' => 'required',
        ]); 
        $input = $request->all();      
        $package = Package::create($input); 
        $request->session()->flash('success', 'Package saved successfully!');
        return redirect()->route('packages.index'); 
    }
  
    public function show(Package $package)
    {
        return $package; 
    }

    public function edit(Package $package)
    {        
        return view('packages.edit', ['package' => $package]);
    }

    public function update(Package $package, Request $request) 
    {
        $request->validate([
            'package_name' => 'required',
        ]);         
        $package->update($request->all());
        $request->session()->flash('success', 'Package updated successfully!');
        return redirect()->route('packages.index');
    }
  
    public function destroy(Request $request, Package $package)
    {
        $package->delete();
        $request->session()->flash('success', 'Package deleted successfully!');
        return redirect()->route('packages.index');
    }    
}
