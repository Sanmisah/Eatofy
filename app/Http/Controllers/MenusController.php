<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\MenuCategory;
use App\Models\Menu;
use App\Http\Controllers\DB;

use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function index()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['hotel_id', auth()->user()->id];
        }  
        $menus = Menu::join('menu_categories', 'menu_categories.id', '=', 'menus.menu_category_id')  
            ->where('menu_categories.hotel_id',auth()->user()->id)          
            ->select('menus.*', 'menu_categories.*')
            ->orderBy('menus.id', 'desc')
            ->get();
        
        return view('menus.index', ['menus' => $menus]);
    }

    public function create()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        $menu_categories = MenuCategory::where('hotel_id', auth()->user()->id)->pluck('menu_category_name', 'id');       
        return view('menus.create')->with(['hotels'=>$hotels, 'menu_categories'=>$menu_categories]);
    }

    public function store(Menu $menu, Request $request) 
    {
        $request->validate([
            'item_name' => 'required|unique:menus,item_name,'.$menu->id,
            'menu_category_id' => 'required',
        ],
        [
            'menu_category_id.required' => 'Please select Category',
        ]); 
        $input = $request->all();      
        $menu = Menu::create($input); 
        $request->session()->flash('success', 'Menu saved successfully!');
        return redirect()->route('menus.index'); 
    }
  
    public function show(Menu $menu)
    {
        //
    }

    public function edit(Menu $menu)
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id'); 
        $menu_categories = MenuCategory::where('hotel_id', auth()->user()->id)->pluck('menu_category_name', 'id'); 
        return view('menus.edit', ['menu' => $menu, 'hotels' => $hotels, 'menu_categories' => $menu_categories]);
    }

    public function update(Menu $menu, Request $request) 
    {
        $request->validate([
            'item_name' => 'required|unique:menus,item_name,'.$menu->id,
            'menu_category_id' => 'required',
        ],
        [
            'menu_category_id.required' => 'Please select Category',
        ]);         
        $menu->update($request->all());
        $request->session()->flash('success', 'Menu updated successfully!');
        return redirect()->route('menus.index');
    }
  
    public function destroy(Request $request, Menu $menu)
    {
        $menu->delete();
        $request->session()->flash('success', 'Category deleted successfully!');
        return redirect()->route('menus.index');
    }    
}
