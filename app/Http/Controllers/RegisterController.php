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

    public function edit(Request $request)
    {
        $device = $request->input('device');
        $types = $request->input('types');

        $edit_device = Device::find($device['id']);
        $edit_device->name = $device['name'];
        $edit_device->location = $device['location'];
        $edit_device->interval = $device['interval'];
        $edit_device->save();
        $device = $edit_device;

        for($i = 0 ; $i < count($types) ; $i++)
        {
            switch ($types[$i]['item']) {
                case "old":
                    switch ($types[$i]['status']) {
                        case true:
                            $edit_type = Mapping::find($types[$i]['mapping_id']);
                            $edit_type->type_id = $types[$i]['type_id'];
                            $edit_type->unit_id = $types[$i]['unit_id'];
                            $edit_type->formula = $types[$i]['formula'];
                            $edit_type->save();
                            break;

                        case false:
                            $delete_type = Mapping::find($types[$i]['mapping_id']);
                            $delete_type->delete();
                            break;

                        default:
                            break;
                    }

                    break;

                case "new":
                    switch ($types[$i]['status']) {
                        case true:
                            $new_type = new Mapping;
                            $new_type->device_id = $device->id;
                            $new_type->type_id = $types[$i]['type_id'];
                            $new_type->unit_id = $types[$i]['unit_id'];
                            $new_type->formula = $types[$i]['formula'];
                            $new_type->save();
                            break;

                        default:
                            break;
                    }

                    break;

                default:
                    break;
            }
        }

        $mapping = Mapping::where('device_id', '=', $device->id)->get();
        $status = "true";

        return compact('device', 'mapping', 'status');
    } 

    public function delete(Request $request)
    {
        $device_id = $request->input('device_id');

        $delete_device = Device::find($device_id);
        $delete_device->delete();

        return "true";
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
