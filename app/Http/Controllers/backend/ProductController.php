<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function AddProduct()
    {
        $DbCate = DB::table('category')->get();
        return view('backend.add-product',['cate'=>$DbCate]);
    }

    public function addProductSubmit(Request $request){
        $request->validate([
            'name' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'category' => 'required',
            'thumbnail' => 'required|image',
            'description' => 'required',
        ]);
    
        $name = $request->name;
        $regular_price = $request->regular_price;
        $sale_price = $request->sale_price;
        $category = $request->category;
        
        // Handle thumbnail upload
        if($request->file('thumbnail')){
            $file = $request->file('thumbnail');
            $thumbnail = $this->uploadFile($file);
        } else {
            $thumbnail = "";
        }
    
        // Handle audio file upload
        if($request->file('audio_file')){
            $audioFile = $request->file('audio_file');
            $audioFilePath = $this->uploadFileAudio($audioFile);
        } else {
            $audioFilePath = "";
        }
    
        $description = $request->description;
    
        if($name){
            $product = DB::table('product')->insert([
                'name'=> $name,
                'slug' => $this->slug($name),
                'regular_price' => $regular_price,
                'sale_price'=> $sale_price,
                'category'  => $category,
                'thumbnail' => $thumbnail,
                'audio_file' => $audioFilePath, // Store audio file path
                'viewer'    => 0,
                'authorId'    => Auth::user()->id,
                'description'   => $description,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]); 
    
            if($product){
                $lastId = $this->getLastPostId('product');
                $this->logActivity('product', $name, $lastId, 'insert');
                return redirect('/admin/list-product')->with('message', 'Insert Product Successful');
            } else {
                return redirect('/admin/add-product')->with('message', 'Insert Product Fail');
            }
        }
    }
    public function listProduct(Request $request){
        $limitPage = 2;
        $currentPage = $request->input('page', 1);
      
        $offset = ($currentPage - 1) * $limitPage;

        $products = DB::table('product')
        ->leftJoin('users','users.id','product.authorId')
        ->leftJoin('category','category.id','product.category')
        ->select('category.name as cateName','users.name as authorname','product.*')
        ->orderByDesc('product.id')
        ->limit($limitPage)
        ->offset($offset)
        ->get();

        $productsCount = DB::table('product')->count();
        $totalPage = ceil($productsCount / $limitPage);


        return view('backend.list-product',['product'=>$products , 'totalPage'=>$totalPage , 'currentPage'=>$currentPage]);
    }

    public function updateProduct($id){
        $DbProduct = DB::table('product')
        ->find($id);
        $DbCate = DB::table('category')->get();
        return view('backend.update-product',['product'=>$DbProduct , 'cate'=>$DbCate , ]);
    }

    public function updateProductSubmit(Request $request){
        $DBProduct = DB::table('product')->where('id',$request->id)->first();
        $name = $request->name;
        $qty = $request->qty;
        $regular_price = $request->regular_price;
        $sale_price = $request->sale_price;
       
        
        $category = $request->category;
        if($request->file('thumbnail')){
            $file = $request->file('thumbnail');
            $thumbnail = $this->uploadFile($file);
        }else{
            $thumbnail = $DBProduct->thumbnail;
        }

        if($request->file('audio_file')){
            $file = $request->file('audio_file');
            $audio_file = $this->uploadFileAudio($file);
        }else{
            $audio_file = $DBProduct->audio_file;
        }
        $description = $request->description;
        if($name){
            
                $product = DB::table('product')->where('id',$request->id)->update([
                    'name'=> $name,
                    'slug' => $this->slug($name),
                    'quantity' => $qty,
                    'regular_price' => $regular_price,
                    'sale_price'=> $sale_price,
                    'category'  => $category,
                    'thumbnail' => $thumbnail,
                    'audio_file' => $audio_file,
                    'viewer'    => 0,
                    'author'    => Auth::user()->id,
                    'description'   => $description,
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]); 
                if($product){
                    $lastId = $this->getLastPostId('product');
                    $this->logActivity('product',$name,$lastId,'Update');
                    return redirect('/admin/list-product')->with('message','Update Product Successful');
                }
                else{
                    return redirect('/admin/add-product')->with('message','Update Product Fail');
                }            
        }
    }

    public function removeProductSubmit(Request $request){
        $id = $request->remove_id;
        $Delete = DB::table('product')->where('id',$id)->delete();
        if($Delete){
            return redirect('/admin/list-product')->with('message','Delete Successful');
        }else{
            return redirect('/admin/list-product')->with('message','Delete Fail');
        }
    }

    public function detailProduct(){
        $products = DB::table('product')
        ->leftJoin('users','users.id','product.authorId')
        ->leftJoin('category','category.id','product.category')
        ->select('category.name as cateName','users.name as authorname','product.*')
        ->get();
        return view('backend.detail-product',['product'=>$products ]);
    }
    
}
