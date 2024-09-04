<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function AddCate(){
        return view('backend.add-category');
    }

    public function AddCateSub(Request $request){
        $name = $request->name;
        if($name){
            $exist = $this->checkExistPost('category','name',$name);
            if($exist>0){
                return redirect('/admin/add-category')->with('message','Category Already Exist');
            }else{
                $slug = $this->slug($name);
                $date = date('Y-m-d h:i:s');
                $insert = DB::table('category')->insert([
                    'name'=>$name,
                    'slug'=>$slug,
                    'authorId'=>Auth::user()->id,
                    'created_at'=>$date,
                    'updated_at'=>$date
                ]);
                if($insert){
                    $lastId = $this->getLastPostId('category');
                    $this->logActivity('category',$name,$lastId,'insert');
                    return redirect('admin/list-category');
                }else{
                    return redirect('/admin/add-category')->with('message','Category Insert Fail');
                }
            }
        }
    }

    public function listCategory(){
       
        $DBCate = DB::table('category')->get();
        return view('backend.list-category',['cate'=>$DBCate ]);
    }
}
