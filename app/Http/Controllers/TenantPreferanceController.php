<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TenantPreferance;
use App\User;
use Auth;
use DB;

class TenantPreferanceController extends Controller {
    
    public function index(){
        return view('pages/account/tenancy/preferences/index');
    }

    public function create(){
      
        $counties = DB::table('county')->get();
        $propertyType  = DB::table('property_type')->get();
        $specs  = DB::table('property_specs')->get();
        $user = Auth::user();

        return view('pages/account/tenancy/preferences/create', compact('counties', 'propertyType', 'specs', 'user'));
    }

    public function store(Request $request){
        $TenantPreferance = TenantPreferance::create([
            "county"      => $request->county,
            "type"        => $request->type,
            "rent"        => $request->rent,
            "bedrooms"    => $request->bedrooms,
            "bathrooms"   => $request->bathrooms,
            "user_name"   => Auth::user()->name,
            "user_id" => Auth::id(),
        ]);
        
        $id = $TenantPreferance->id;

        return redirect("/account/preferance/$id");
    }

    public function show($id){
        $user = Auth::user();
        $TenantPreferance = TenantPreferance::where('id', $id)->first();
        
        return view('pages/account/tenancy/preferences/show', compact('TenantPreferance', 'user'));
    }

    public function edit($id){
      
      $tenantPreferance = TenantPreferance::where('id', $id)->first();
      $counties = DB::table('county')->get();
      $specs    = DB::table('property_specs')->get();
      $types    = DB::table('property_type')->get();
      $user = Auth::user();

      return view ('pages/account/tenancy/preferences/edit', compact( 'counties', 'specs', 'tenantPreferance', 'types', 'user'));
    }

    public function update(Request $request, $id){
        $TenantPreferance = TenantPreferance::where('id', $id)->where('user_id', Auth::id())->update([
            "county"      => $request->county,
            "type"        => $request->type,
            "rent"        => $request->rent,
            "bedrooms"    => $request->bedrooms,
            "bathrooms"   => $request->bathrooms,
            "user_name"   => Auth::user()->name,
            "user_id" => Auth::id(),
        ]);
        
        return redirect("account/preferance/$id");
    }

    public function delete(){
        
    }
}