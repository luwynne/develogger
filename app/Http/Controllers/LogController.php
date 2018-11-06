<?php

namespace App\Http\Controllers;

use App\Log;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogController extends Controller
{
    
    public function index(){

        $log = Log::orderBy('id', 'DESC')->get();

        return response($log->jsonSerialize(), Response::HTTP_OK);
        
    }

    public function store(Request $request){

        $log = new Log();

        $log->domain_id = $request->domain_id;
        $log->user = Auth::user()->name;
        $log->title = $request->title;
        $log->type = $request->type;
        $log->description = $request->description;

        $log->save();

        return response($log->jsonSerialize(),Response::HTTP_CREATED);

        if($request->tell){
            sendNotification($log->user, $log->title);
        }

        

        
    }

    public function sendNotification($user, $title){

        $luiz = "lwynne@originate.ie";
        $david = "dkennedy@originate.ie";
        $matt = "matt@originate.ie";
        $subject = "New log created"; 
        $message = "A new log has been created by "+ $user;
        $message += ": "+ $title;
    
        mail($luiz, $subject, $message);
        mail($david, $subject, $message);
        mail($matt, $subject, $message);

    }

 

    public function edit($id){

        return Log::find($id);

    }

    


    
    public function update(Request $request, $id){

        $this->validate($request, [
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);

        $log = Log::find($id);

        if($log->count()){

            $log->update($request->all());

            return response()->json(['statur'=>'success','msg'=>'Post updated successfully']);

        } else {

            return response()->json(['statur'=>'error','msg'=>'error in updating post']);

        }

    }

    
    public function destroy($id){
        
        Log::where('id',$id)->delete();

    }
}
