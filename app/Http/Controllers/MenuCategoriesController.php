<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MenuCategory;

class MenuCategoriesController extends Controller
{
    public function index()
    {
        $menu_categories = MenuCategory::orderBy('id', 'desc')->get();
        return view('menu_categories.index', ['menu_categories' => $menu_categories]);
    }

    public function create()
    {
        return view('menu_categories.create');
    }

    public function store(MenuCategory $menu_category, Request $request) 
    {
        $request->validate([
            'menu_category_name' => 'required|unique:menu_categories,menu_category_name,'.$menu_category->id,
        ]); 
        $input = $request->all();      
        $menu_category = MenuCategory::create($input); 
        $request->session()->flash('success', 'Category saved successfully!');
        return redirect()->route('menu_categories.index'); 
    }
  
    public function show(MenuCategory $menu_category)
    {
        //
    }

    public function edit(MenuCategory $menu_category)
    {
        return view('menu_categories.edit', ['menu_category' => $menu_category]);
    }

    public function update(MenuCategory $menu_category, Request $request) 
    {
        $request->validate([
            'menu_category_name' => 'required|unique:menu_categories,menu_category_name,'.$menu_category->id,
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
}
