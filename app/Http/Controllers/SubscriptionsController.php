<?php

namespace App\Http\Controllers;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\Hotel;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {     
        //return view('subscriptions.create');
    }

    public function store(Request $request) 
    {
       //
    }
  
    public function show(Subscription $subscription)
    {
        //
    }

    public function edit(Subscription $subscription)
    {               
        return view('subscriptions.edit', ['subscription' => $subscription]);
    }

    public function update(Subscription $subscription, Request $request) 
    {
        //
    }
  
    public function destroy(Request $request, Subscription $subscription)
    {
        //
    }    
}
