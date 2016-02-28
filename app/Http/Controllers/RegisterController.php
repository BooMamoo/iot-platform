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

        if($device == "" || $device == 'undefined' || $device == null || $location == "" || $location == 'undefined' || $location == null || $interval == "" || $interval == 'undefined' || $interval == null || !is_int($interval))
        {
            return "false";
        }

        $check = $this->check_type($types);

        if(!$check)
        {
            return "false";
        }

    	$new_device = new Device;
    	$new_device->name = $device;
    	$new_device->location = $location;
    	$new_device->interval = $interval;
    	$new_device->save();

        for($i = 0 ; $i < count($types) ; $i++)
        {
            $mapping = new Mapping;
            $mapping->device_id = $new_device->id;
            $mapping->type_id = $types[$i]['type_id'];
            $mapping->unit_id = $types[$i]['unit_id'];
            $mapping->min_threshold = $types[$i]['min_threshold'];
            $mapping->max_threshold = $types[$i]['max_threshold'];
            $mapping->formula = $types[$i]['formula'];
            $mapping->save();
        }

    	return "true";
    	// return "false";
    }

    public function edit(Request $request)
    {
        $device = $request->input('device');
        $types = $request->input('types');

        if(!is_array($device))
        {
            return "false";
        }
        else if(!key_exists('id', $device) || !key_exists('name', $device) || !key_exists('location', $device) || !key_exists('interval', $device))
        {   
            return "false";
        }
        else if($device['id'] == "" || $device['name'] == "" || $device['location'] == "" || $device['interval'] == "")
        {
            return "false";
        }
        else if($device['id'] == 'undefined' || $device['name'] == 'undefined' || $device['location'] == 'undefined' || $device['interval'] == 'undefined')
        {
            return "false";
        }
        else if($device['id'] == null || $device['name'] == null || $device['location'] == null || $device['interval'] == null)
        {
            return "false";
        }
        else if(!is_int($device['id']) || !is_int($device['interval']))
        {
            return "false";
        }

        $check = $this->check_type($types);

        if(!$check)
        {
            return "false";
        }

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
                            $edit_type->min_threshold = $types[$i]['min_threshold'];
                            $edit_type->max_threshold = $types[$i]['max_threshold'];
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
                            $new_type->min_threshold = $types[$i]['min_threshold'];
                            $new_type->max_threshold = $types[$i]['max_threshold'];
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

    public function check_type($types)
    {
        for($i = 0 ; $i < count($types) ; $i++)
        {
            if(!is_array($types[$i]))
            {
                return false;
            }
            else if(!key_exists('type_id', $types[$i]) || !key_exists('unit_id', $types[$i]) || !key_exists('min_threshold', $types[$i]) || !key_exists('max_threshold', $types[$i]) || !key_exists('formula', $types[$i]))
            {   
                return false;
            }
            else if($types[$i]['type_id'] == "" || $types[$i]['unit_id'] == "" || $types[$i]['min_threshold'] == "" || $types[$i]['max_threshold'] == "" || $types[$i]['formula'] == "")
            {
                return false;
            }
            else if($types[$i]['type_id'] == 'undefined' || $types[$i]['unit_id'] == 'undefined' || $types[$i]['min_threshold'] == 'undefined' || $types[$i]['max_threshold'] == 'undefined' || $types[$i]['formula'] == 'undefined')
            {
                return false;
            }
            else if($types[$i]['type_id'] == null || $types[$i]['unit_id'] == null || $types[$i]['min_threshold'] == null || $types[$i]['max_threshold'] == null || $types[$i]['formula'] == null)
            {
                return false;
            }
            else if(!is_int($types[$i]['min_threshold']) || !is_int($types[$i]['max_threshold']))
            {
                return false;
            }
        }

        return true;
    }
}
