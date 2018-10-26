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



    }

   
    // public function create()
    // {
        
    // }

   
    // public function store(Request $request)
    // {
        
    // }

   
    // public function show(Domain $domain)
    // {
        
    // }

   
    // public function edit(Domain $domain)
    // {
        
    // }

    
    // public function update(Request $request, Domain $domain)
    // {
        
    // }

    
    // public function destroy(Domain $domain)
    // {
        
    // }
}
