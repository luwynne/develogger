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

        $to = "lwynne@originate.ie, dkennedy@originate.ie, matt@originate.ie";
        $subject = "New log created"; 
        $message = "A new log has been created by "+$log->user;
        $message += " on "+$log->domain_id;
        $message += ": "+$log->title;
    
        mail($to, $subject, $message);

        return response($log->jsonSerialize(),Response::HTTP_CREATED);

        
    }


    
    public function update($id, Request $request){

        $log = Log::find($request->id);
        $log->title = $request->logTitle;
        $log->type = $request->logType;
        $log->description = $request->logDescription;

        $log->save();

    }

    
    public function destroy($id){
        
        Log::where('id',$id)->delete();

    }
}
