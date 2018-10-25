<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model{

    protected $fillable = [
        'domain_id',
        'user',
        'title',
        'type',
        'description'
    ];

    public function domain(){
        return $this->belongsTo('App\Domain');
    }
    
}
