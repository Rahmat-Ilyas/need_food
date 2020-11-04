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
	public function loginMobile()
	{
		$credential = [
			'username' => request('username'),
			'password' => request('password'),
		];

		$login = false;

		if(Auth::guard('admin')->attempt($credential)) {
			$login = true;
			$data = Auth::guard('admin')->user();
			$role = $data->role;
		} else if(Auth::guard('driver')->attempt($credential)) {
			$login = true;
			$data = Auth::guard('driver')->user();
			$role = 'driver';	
		}

		if ($login) {
			return response()->json([
				'success' => true,
				'message' => 'Login Success',
				'id' => $data->id,
				'role' => $role,
			], 200);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'Unauthorised',
			], 401);
		}
	}

	public function getAdmin($params)
	{
		if ($params > 0) $data = AuthLogin::where('id', $params)->first();
		else $data = AuthLogin::where('username', $params)->first();

		if ($data && $data->role == 'admin') {
			unset($data['password']);
			return response()->json([
				'success' => true,
				'message' => 'Success Get Data',
				'result' => $data
			], 200);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'Tidak ada data ditemukan',
			], 404);
		}
	}

	public function getKitchen($params)
	{
		if ($params > 0) $data = AuthLogin::where('id', $params)->first();
		else $data = AuthLogin::where('username', $params)->first();

		if ($data && $data->role == 'kitchen') {
			unset($data['password']);
			return response()->json([
				'success' => true,
				'message' => 'Success Get Data',
				'result' => $data
			], 200);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'Tidak ada data ditemukan',
			], 404);
		}
	}

	public function getDriver($params)
	{
		if ($params > 0) $data = Driver::where('id', $params)->first();
		else $data = Driver::where('username', $params)->first();

		if ($data) {
			unset($data['password']);
			return response()->json([
				'success' => true,
				'message' => 'Success Get Data',
				'result' => $data
			], 200);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'Tidak ada data ditemukan',
			], 404);
		}
	}
}
