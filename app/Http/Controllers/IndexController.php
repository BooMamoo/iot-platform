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
    	// $test = $this->convert("(x*(9/50))+32", 789); //"(x*(9/50))+32"

    	$information = new Information;
    	$information->mapping_id = $mapping[0]->id;
    	$information->value = $value;
    	$information->timestamp = $date;
    	$information->save();

    	return "true";
    }

    public function convert($formula, $value)
    {
    	$tmp = [];
    	$convert = 0;
    	$count = 0;
    	$symbols = ['+', '-', '*', '/', '^'];

    	for($i = 0 ; $i < strlen($formula) ; $i++)
    	{
    		if($formula[$i] != ')')
    		{
    			array_push($tmp, $formula[$i]);
    		}

    		if($i == (strlen($formula) - 1) || $formula[$i] == ')')
    		{
    			$num = "";
    			$cal = 0;
    			$sym = "";

    			for($j = (count($tmp) - 1) ; $j >= 0 ; $j--)
    			{	
    				$pop = array_pop($tmp);

					if($pop == '(' || $j == 0)
					{
						if($pop != '(')
						{
							$num = $num . $pop;
						}

						if($num == 'x')
						{
							$convert = $this->calculate($sym, (float)$value, $cal);
						}
						else if(in_array($pop, $symbols))
						{
							if($num == 'x')
							{
								$cal = (float)$value;
							}
							else if($num == "")
							{
								$cal = $convert;
							}
							else
							{
								$cal = (float)strrev($num);
							}
							
							$num = "";
							$sym = $pop;

							$convert = $this->calculate($sym, $convert, $cal);
						}
						else
						{
							$convert = $this->calculate($sym, (float)strrev($num), $cal);
						}

						break;
					}
					else if(in_array($pop, $symbols))
					{
						if($num == 'x')
						{
							$cal = (float)$value;
						}
						else if($num == "")
						{
							$cal = $convert;
						}
						else
						{
							$cal = (float)strrev($num);
						}
						
						$num = "";
						$sym = $pop;
						continue;
					}

					$num = $num . $pop;
    			}
    		}
    	}

	   	return $convert;
    }

    public function calculate($symbol, $valA, $valB)
    {
    	if($symbol == '+')
    	{
    		$cal = $valA + $valB;
    	}
    	else if($symbol == '-')
    	{
    		$cal = $valA - $valB;
    	}
    	else if($symbol == '*')
    	{
    		$cal = $valA * $valB;
    	}
    	else if($symbol == '/')
    	{
    		$cal = $valA / $valB;
    	}
    	else if($symbol == '^')
    	{
    		$cal = $valA ^ $valB;
    	}

    	return $cal;
    }
}
