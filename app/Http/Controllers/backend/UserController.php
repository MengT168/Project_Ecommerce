<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function Signin(){

        return view('backend.login');
    }

    public function SigninSubmit(Request $request){
        $name_email = $request->name_email;
        $password = $request->password;

        if(Auth::attempt((['name'=>$name_email,'password'=>$password]))){
            return redirect('/admin');
        }else if(Auth::attempt(['email'=>$name_email , 'password'=>$password])){
            return redirect('/admin');
        }else{
            return redirect('/signin')->with('message_fail','Incorrect Name , Email Or Password');
        }
    }


    
    public function Signup(){
        return view('backend.register');
    }

    public function SignupSubmit(Request $request)
{
    if($request->file('profile')){
       $file = $request->file('profile');
       $image = $this->uploadFile($file);
    } else {
        $image = "";
    }
    
    $name = $request->name;
    $email = $request->email;
    $password = Hash::make($request->password);

    $check = DB::table('users')->where('name', $name)->orWhere('email', $email)->get();
    if(count($check) == 0) {
        $userCount = DB::table('users')->count();
        $status = ($userCount == 0) ? 1 : 0;

        $signup = DB::table('users')->insert([
            'name'       => $name,
            'email'      => $email,
            'password'   => $password,
            'image'    => $image,
            'is_admin'     => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if($signup){
            return redirect('/signin');
        }
    } else {
        return redirect('/signup')->with('message', 'User already exists');
    }
}


}
