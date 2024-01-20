<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MenuCategory;
use App\Models\Hotel;
use App\Models\Menu;

class MenuCategoriesController extends Controller
{
    public function index()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['hotel_id', auth()->user()->id];
        } 
        $menu_categories = MenuCategory::where($conditions)->orderBy('id', 'desc')->get();
        // dd($menu_categories);
        return view('menu_categories.index', ['menu_categories' => $menu_categories]);
    }

    public function create()
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id');
        return view('menu_categories.create')->with(['hotels' => $hotels]);
    }

    public function store(MenuCategory $menu_category, Request $request) 
    {
        $request->validate([
            'menu_category_name' => 'required',
            'gst_rate' => 'required',
        ]); 
        $input = $request->all();      
        $menu_category = MenuCategory::create($input); 
        $request->session()->flash('success', 'Category saved successfully!');
        return redirect()->route('menu_categories.index'); 
    }
  
    public function show(MenuCategory $menu_category)
    {
        return $menu_category; 
    }

    public function edit(MenuCategory $menu_category)
    {
        $authUser = auth()->user()->roles->pluck('name')->first();
        $conditions = [];
        if($authUser == 'Owner'){                       
            $conditions[] = ['id', auth()->user()->id];
        } 
        $hotels = Hotel::where($conditions)->pluck('hotel_name', 'id');
        return view('menu_categories.edit', ['menu_category' => $menu_category, 'hotels' => $hotels]);
    }

    public function update(MenuCategory $menu_category, Request $request) 
    {
        $request->validate([
            'menu_category_name' => 'required',
            'gst_rate' => 'required',
        ]);         
        $menu_category->update($request->all());
        $request->session()->flash('success', 'Category updated successfully!');
        return redirect()->route('menu_categories.index');
    }
  
    public function destroy(Request $request, MenuCategory $menu_category)
    {
        $menu_category->delete();
        $request->session()->flash('success', 'Category deleted successfully!');
        return redirect()->route('menu_categories.index');
    }    

    public function getMenuData(MenuCategory $menu_category, $id)
    {       
        $menu = Menu::select('id', 'item_name', 'rate')->where('menu_category_id', $id)->get();
        return $menu;
    }
}
