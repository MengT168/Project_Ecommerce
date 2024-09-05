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

    public function updateCategory($id){
        $DbCate = DB::table('category')->where('id',$id)->first();
        return view('backend.update-category',['cate'=>$DbCate ]);
    }

    public function updateCategorySubmit(Request $request){
        $name = $request->name;
        $id = $request->id;
        if($name){
            $exist = $this->checkExistPost('category','name',$name);
            if($exist){
                return redirect('/admin/list-category')->with('message','Category already exist');
            }else{
                $slug = $this->slug($name);
                $update = DB::table('category')->where('id',$id)->update([
                    'name' => $name,
                    'slug' =>$slug,
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
                if($update){
                    $lastId = $this->getLastPostId('category');
                    $this->logActivity('category',$name,$lastId,'Update');
                    return redirect('/admin/list-category')->with('message','Update Successful');
                }else{
                    return redirect('/admin/list-category')->with('message','Update Fail');
                }
            }
        }
        else{
            return redirect('/admin/list-category')->with('message','Invalid Input');
        }
    }

    public function removeCategorySubmit(Request $request){
        $id = $request->id;
        $Delete = DB::table('category')->where('id',$id)->delete();
        if($Delete){
            return redirect('/admin/list-category')->with('message','Delete Successful');
        }else{
            return redirect('/admin/list-category')->with('message','Delete Fail');
        }
    }
}
