<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogController extends Controller
{
    
    public function index(){

        return response(Log::all()->jsonSerialize(), Response::HTTP_OK);
        
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

        
    }

    
    public function show(Log $log)
    {
        
    }

    
    public function edit(Log $log)
    {
        
    }

    
    public function update(Request $request, Log $log)
    {
        
    }

    
    public function destroy(Log $log)
    {
        
    }
}
