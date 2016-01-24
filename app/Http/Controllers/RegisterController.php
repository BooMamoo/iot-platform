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
        $types = $request->input('types');

    	$new_device = new Device;
    	$new_device->name = $device;
    	$new_device->location = $location;
    	$new_device->interval = $interval;
    	$new_device->save();

        $this->sendToServer($new_device, 'device');

        for($i = 0 ; $i < count($types) ; $i++)
        {
            $mapping = new Mapping;
            $mapping->device_id = $new_device->id;
            $mapping->type_id = $types[$i]['type_id'];
            $mapping->unit_id = $types[$i]['unit_id'];
            $mapping->formula = $types[$i]['formula'];
            $mapping->save();

            $this->sendToServer($mapping, 'mapping');
        }

    	return "true";
    	// return "false";
    }

    public function sendToServer($data, $parameter)
    {
        $ip = config('ip');
        $url = $ip . '/data/store';
        $client = new Client();
        $local = config('local');

        $response = $client->request('POST', $url, [
            'json' => [
                'data' => $data, 
                'parameter' => $parameter, 
                'local' => $local
            ]
        ]);

        // print_r($response->getBody()->getContents());
    }
}
