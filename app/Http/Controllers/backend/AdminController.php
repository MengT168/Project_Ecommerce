<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){
        return view('backend.master');
    }

    public function signOut(){
        Auth::logout();
        return redirect('/signin');
    }

    public function addLogo() {
        
        return view('backend.add-logo');
    }

    public function addLogoSubmit(Request $request)
    {
        if($request->file('thumbnail')){
            $file = $request->file('thumbnail');
            $thumbnail = $this->uploadFile($file);
            $submit = DB::table('logo')->insert([
                'thumbnail' => $thumbnail,
                'authorId'    => Auth::user()->id,
                'created_at'    => date('Y-m-d h:i:s'),
                'updated_at'    => date('Y-m-d h:i:s'),
            ]);
            if($submit){
                $lastId = $this->getLastPostId('logo');
                $this->logActivity('logo',$thumbnail,$lastId,'Insert');
                return redirect('/admin/list-logo');
            }else{
                return redirect('/admin/add-logo')->with('message','add thumbnail fail');
            }
        }else{
            return redirect('/admin/add-logo')->with('message','Invalid File');
        }
    }
    public function listLogo(){
        $Dblogo = DB::table('logo')
        ->leftJoin('users','users.id','logo.authorId')
        ->select('users.name','logo.*')
        ->orderBy('logo.id')
        ->get();
        return view('backend.list-logo',['logo'=>$Dblogo]);
    }

    public function updateLogo($id){
       
        $Dblogo = DB::table('logo')->where('id',$id)->first();
        return view('backend.update-logo',['logo'=>$Dblogo ]);
    }

    public function updateLogoSubmit(Request $request){
        $id = $request->id;
        if($request->file('thumbnail')){
            $file = $request->file('thumbnail');
            $thumbnail = $this->uploadFile($file);
            $update = DB::table('logo')->where('id',$id)->update([
                'thumbnail' => $thumbnail,
                'updated_at'    => date('Y-m-d h:i:s')
            ]);
            if($update){
                $lastId = $this->getLastPostId('logo');
                $this->logActivity('logo',$thumbnail,$lastId,'Update');
                return redirect('/admin/list-logo');
            }else{
                return redirect('/admin/update-logo/'.$id)->with('message','Update Fail');
            }
        }else{
            return redirect('/admin/update-logo/'.$id)->with('message','Invalid File');
        }
    }

    public function removeLogoSubmit(Request $request){
        $id = $request->id;
        $Dblogo = DB::table('logo')->where('id',$id)->delete();
        if($Dblogo){
            return redirect('/admin/list-logo')->with('message','Delete Success');
        }else{
            return redirect('/admin/list-logo')->with('message','Delete Fail');
        }
    }

    public function listLogActivity(){
        
        $Dblog = DB::table('log_activity')
        ->leftJoin('users','users.id','log_activity.authorId')
        ->select('users.name','log_activity.*')
        ->get();
        return view('backend.list-log',['log'=>$Dblog]);
    }
    public function logDetail($post,$id,$ids){
        $order = DB::table('subscribe')->where('status', 'pending')->count();
        // $id = $request->id;
        $Dblog = DB::table('log_activity')
        ->leftJoin('users','users.id','log_activity.authorId')
        ->select('users.name','log_activity.*')
        ->where('log_activity.id',$ids)
        ->get();
        return view('backend.log-detail',['log'=>$Dblog , 'orderRow'=>$order ]);
    }
}
