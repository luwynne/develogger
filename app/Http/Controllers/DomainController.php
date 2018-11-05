<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Log;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    
    public function index(){

        return response(Domain::all()->jsonSerialize(), Response::HTTP_OK);
        
    }

    public function addNewDomainLog(Request $request){

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

   
    public function getLogsDomain($id){

        $log = new Log();
        $logs = $log::where('domain_id', $id)->orderBy('id', 'DESC')->get();
        return response($logs->jsonSerialize(),Response::HTTP_CREATED);
    }
}
