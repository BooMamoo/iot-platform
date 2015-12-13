<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public function mapping()
    {
    	return $this->hasMany('\App\Mapping', 'device_id')->with(array('type', 'unit'));
    }
}
