<?php namespace Chatty\Http\Controllers;

use Illuminate\Http\Request;
use Chatty\Models\User;
use Auth;

class AuthController extends Controller
{
	public function getSignup()
	{
		return view('auth.signup');
	}

	public function postSignup(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|unique:users|email|max:255',
			'username' => 'required|unique:users|alpha_dash|max:20',
			'password' => 'required|min:6'
		]);

		User::create([
			'email' => $request->input('email'), // or ->get('email')
			'username' => $request->input('username'),
			'password' => bcrypt($request->input('password')),
		]);

		return redirect()
				->route('home')
				->with('info', 'Yout account has been created!');
	}

	public function getSignin()
	{
		return view('auth.signin');
	}

	public function postSignin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required',
			'password' => 'required',
		]);

		if(!Auth::attempt($request->only(['email', 'password']), $request->has('remember'))) {
			return redirect()->back()->with('info', 'Could nit sing you in with those details.');
		}

		return redirect()->route('home')->with('info', 'You are sign in');

	}

	public function getSignout()
	{
		Auth::logout();

		return redirect()->route('home');
	}

	public function loginGithub($provider)
	{
		$user = \Socialite::driver($provider)->user();

		$nUser = new \Chatty\Models\User;
		$nUser->email = $user->email;

		Auth::login($nUser);

		if (Auth::check()) {
			echo 'You are authorized!';
			return redirect()->route('home')->with('info', 'You have been login through '. $provider);
		}
	}

}