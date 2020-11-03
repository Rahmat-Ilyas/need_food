<?php

namespace App\Http\Controllers\Auth;

use App\Model\Driver;
use App\Model\AuthLogin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Validator;

class AuthMobileController extends Controller
{
	public function loginMobile(Request $request)
	{
		return response()->json([
			'success' => false,
			'message' => 'id not found'
		], 200); 
	}
}
