<?php

namespace App\Http\Controllers\Auth;

use App\Model\AuthLogin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthKitchenController extends Controller
{
    public function __construct()
	{
		$this->middleware('guest:kitchen')->except('logout');
	}

	public function showLoginForm()
	{
		return view('kitchen/login');
	}

	public function login(Request $request)
	{
		$this->validate($request, [
			'username' => 'required',
			'password' => 'required|min:3'
		]);

		$credential = [
			'username' => $request->username,
			'password' => $request->password,
		];

		if (Auth::attempt($credential)) {
			$auth = Auth::user();
			if ($auth->role == 'kitchen') {
				Auth::guard('kitchen')->attempt($credential, $request->filled('remember'));
				return redirect()->intended(route('kitchen.home'));
			}
		}

        //return redirect()->back()->withInput($request->only('username', 'password'));

		return $this->sendFailedLoginResponse($request);
	}

	protected function sendFailedLoginResponse(Request $request)
	{
		throw ValidationException::withMessages([
			'username' => [trans('auth.failed')],
		]);
	}

	public function logout(Request $request)
	{
		Auth::guard('kitchen')->logout();

		$request->session()->invalidate();

		return redirect('/kitchen');
	}
}
