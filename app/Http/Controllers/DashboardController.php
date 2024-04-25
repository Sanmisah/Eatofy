<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuCategory;

class DashboardController extends Controller
{
    public function index()
    {
        return view('table');
    }

    public function create()
    {
        
    }

    public function store(Request $request) 
    {        
            
    }
    
    public function show()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){
            $conditions[] = ['hotel_id', auth()->user()->id];
        }
        $menu_categories = MenuCategory::where($conditions)->orderBy('id', 'desc')->get();
        dd($menu_categories);
        return view('table', compact('menu_categories'));
    }
  
    public function edit()
    {
        
    }

    public function update(Request $request) 
    {
        
    }
  
    public function destroy(Request $request)
    {
        
    }
}
