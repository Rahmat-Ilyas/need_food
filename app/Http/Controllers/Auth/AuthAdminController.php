<?php

namespace App\Http\Controllers\Auth;

use App\Model\AuthLogin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthAdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest:admin')->except('logout');
	}

	public function showLoginForm()
	{
		return view('admin/login');
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
			if ($auth->role == 'admin') {
				Auth::guard('admin')->attempt($credential, $request->filled('remember'));
				return redirect()->intended(route('admin.home'));
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
		Auth::guard('admin')->logout();

		$request->session()->invalidate();

		return redirect('/admin');
	}
}
