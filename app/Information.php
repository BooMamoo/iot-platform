<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
	protected $hidden = ['created_at', 'updated_at'];
	
    protected $table = 'informations';
}
