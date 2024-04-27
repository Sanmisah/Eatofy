<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuCategory;
use App\Models\Table;

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
        // $tables = Table::where($conditions)->orderBy('id', 'desc')->get();
        $tables = Table::join('sections', 'sections.id', '=', 'tables.section_id')  
                        ->where('tables.hotel_id',auth()->user()->id)          
                        ->select('tables.*', 'sections.section_name')
                        ->orderBy('tables.id', 'desc')
                        ->get();
        // dd($tables);
        return view('dashboard', ['tables' => $tables]);
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
