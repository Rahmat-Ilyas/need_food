<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Model\AuthLogin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Validator;

class AuthApiController extends Controller
{
	public $successStatus = 200;

	public function login()
	{
		$credential = [
			'username' => request('username'),
			'password' => request('password'),
		];

		if(Auth::attempt($credential)) {
			$auth = Auth::user();

			if ($auth->role == 'api_token') {
				$success['token'] =  $auth->createToken('nApp')->accessToken;
				$success['nama'] =  $auth->nama;
				return response()->json(['success' => $success], $this->successStatus);
			}
		}

		return response()->json(['error'=>'Unauthorised'], 401);
	}

	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'username' => 'required',
			'password' => 'required',
		]);

		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()], 401);            
		}

		try {
			$input = $request->all();
			$input['role'] = 'api_token';
			$input['password'] = bcrypt($input['password']);
			$auth = AuthLogin::create($input);
			$success['token'] =  $auth->createToken('nApp')->accessToken;
			$success['nama'] =  $auth->nama;

			return response()->json(['success'=>$success], $this->successStatus);
		} catch(QueryException $ex) {
			return response()->json([
				'error' => true,
				'message' => $ex->getMessage(),
			], 500);			
		}
	}

	public function getauth()
	{
		$auth = AuthLogin::all();
		$result = $auth;

		return response()->json([
			'success' => true,
			'message' => 'Success get data',
			'result'  => $result
		], $this->successStatus);
	}
}
