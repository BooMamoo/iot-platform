<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Device;
use App\Mapping;

class DeviceController extends Controller
{
    public function index()
    {
    	$devices = Device::with('mapping')->get();

    	return compact('devices');
    }
}
