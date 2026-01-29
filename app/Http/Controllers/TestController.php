<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class TestController extends Controller
{
   public function index()
   {
    $staffs = Staff::all();
    return view('test',[
        'staffs' => $staffs
    ]);

   }
   public function store(Request $request){
    $user = Staff::create([
    'name' => $request->name,
    'email'=> $request->email,
    'password'=>$request->password
    ] );
    return back();
   }
   public function edit(Staff $staff){
    return view('edit',[
        'staff'=> $staff
    ]);
   }
   public function update(Staff $staff,Request $request){
    $staff->update([
        'name' => $request->name,
        'email'=> $request->email,
    ]);
    return redirect()->route('test.index');
   }
   
   public function destroy(Staff $staff){
    $staff->delete();
    return back();
}
}

