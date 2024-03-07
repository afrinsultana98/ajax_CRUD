<?php

namespace App\Http\Controllers;
use App\Models\Test;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    public function showAllUsers(){
        $all_users = Test::all();
        return view('all-users',compact('all_users'));
    }
    public function addUser(Request $request){
        $validator = Validator::make($request->all(),[
'name' =>'required',
'email' => 'required', 
        ]);
        if($validator->fails()){
            return response()->json(['msg'=>$validator->errors()->toArray()]);
        }else{
            try{
                $addUser = new Test;
                $addUser->name = $request->name;
                $addUser->email = $request->email;
                $addUser->save();
                return response()->json(['success'=> true,'msg'=> 'User added successfully']);

            }catch(\Exception $e){
return response()->json(['success'=> false,'msg'=> $e->getMessage()]);
            }
        }
    }
    public function deleteUser($id){
try{
$delete_user = Test::where('id',$id)->delete();
return response()->json(['success'=> true,'msg'=> 'User Deleted Successfully']);
}catch(\Exception $e){
    return response()->json(['success'=> false,'msg'=> $e->getMessage()]);
}
    }
    public function editUser(Request $request){
        $validator = Validator::make($request->all(),[
            'name' =>'required',
            'email' => 'required', 
                    ]); 
                    if($validator->fails()){
                        return response()->json(['msg'=>$validator->errors()->toArray()]);
                    }else{
                        try{
                            Test::where('id',$request->user_id)->update([
                                'name'=>$request->name,
                                'email'=>$request->email,
                                                            ]); 
                                                            return response()->json(['success'=> true,'msg'=> 'User Updated successfully']);
                        }catch(\Exception $e){
                            return response()->json(['success'=> false,'msg'=> $e->getMessage()]); 
                        }
                        
                    }
    }
}
