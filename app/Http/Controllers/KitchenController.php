<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:kitchen');
	}

	public function home()
    {
    	return view('kitchen/index');
    }

    public function setpageonly($page)
    {
    	return view('kitchen/'.$page);
    }

    public function setpagedir($dir = NULL, $page)
    {
    	return view('kitchen/'.$dir.'/'.$page);
    }
}
