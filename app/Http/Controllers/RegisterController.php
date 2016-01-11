<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Device;
use App\Type;
use App\Unit;
use App\Mapping;
use App\Information;
use GuzzleHttp\Client;

class RegisterController extends Controller
{
    public function index()
    {
    	$types = Type::All();
    	$units = Unit::All();

    	return compact('types', 'units');
    }

    public function store(Request $request)
    {
    	$device = $request->input('device');
    	$location = $request->input('location');
    	$interval = $request->input('interval');
    	$type_id = $request->input('type_id');
    	$unit_id = $request->input('unit_id');
    	$formula = $request->input('formula');

    	$new_device = new Device;
    	$new_device->name = $device;
    	$new_device->location = $location;
    	$new_device->interval = $interval;
    	$new_device->save();

    	$mapping = new Mapping;
    	$mapping->device_id = $new_device->id;
    	$mapping->type_id = $type_id;
    	$mapping->unit_id = $unit_id;
    	$mapping->formula = $formula;
    	$mapping->save();

        $this->sendToServer($new_device, 'device');
        $this->sendToServer($mapping, 'mapping');

    	return "true";
    	// return "false";
    }

    public function sendToServer($data, $parameter)
    {
        $url = 'http://192.168.1.50/data/store';
        $client = new Client();
        $response = $client->request('POST', $url, [
            'json' => [
                'data' => $data, 
                'parameter' => $parameter, 
                'local' => 'Local A'
            ]
        ]);

        // print_r($response->getBody()->getContents());
    }
}
