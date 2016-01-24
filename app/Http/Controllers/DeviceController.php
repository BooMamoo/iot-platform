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
    	$devices = Device::All();

    	return compact('devices');
    }

    public function device($device_id)
    {
    	$data = Device::with('mapping')->where('id', '=', $device_id)->get();

    	return $data;
    }
}
