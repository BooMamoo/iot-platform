<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    
    public function mapping()
    {
    	return $this->hasMany('\App\Mapping', 'device_id')->with(array('type', 'unit'));
    }

    protected static function boot() 
    {
        parent::boot();

        static::deleting(function($device) 
        { 
             $device->mapping()->delete();
        });
    }
}
