<?php

namespace App\Http\Controllers;

use App\Model\AuthLogin;

use Illuminate\Http\Request;

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

    public function home()
    {
    	return view('admin/index');
    }

    public function setpageonly($page)
    {
    	return view('admin/'.$page);
    }

    public function setpagedir($dir = NULL, $page)
    {
    	return view('admin/'.$dir.'/'.$page);
    }
}
