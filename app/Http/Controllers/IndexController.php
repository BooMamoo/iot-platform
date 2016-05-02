<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Information;
use App\Device;
use App\Type;
use App\Mapping;

class Indexcontroller extends Controller
{
    public function index()
    {
    	return view('index');
    }

    public function recieveData(Request $request)
    {
    	$device = $request->input('device');
    	$type = $request->input('type');
    	$value = $request->input('value');
    	$date = $request->input('date');

    	$device_id = Device::select('id')->where('name', '=', $device)->get();
    	$type_id = Type::select('id')->where('type', '=', $type)->get();
    	$mapping = Mapping::where('device_id', '=', $device_id[0]->id)->where('type_id', '=', $type_id[0]->id)->get();
    	$value = $this->convert($mapping[0]->formula, $value);

    	$information = new Information;
    	$information->mapping_id = $mapping[0]->id;
    	$information->value = $value;
    	$information->timestamp = $date;
    	$information->save();

        $result = shell_exec('python /var/www/html/iot-platform/publish.py /regis/data/' . config('local') . ' ' . escapeshellarg(json_encode($information)));
        
    	return "true";
    }

    public function convert($formula, $value)
    {
        $substitute = str_replace("x", $value, $formula);
        $calculate = eval('return ' . $substitute . ';');

        return $calculate;
    }
}
