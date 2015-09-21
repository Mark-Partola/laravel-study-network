<?php namespace Chatty\Http\Controllers;

use Illuminate\Http\Request;
use Chatty\Models\User;
use Auth;

class FriendController extends Controller
{
	public function getIndex()
	{
		$friends = \Auth::user()->friends();
		$requests = \Auth::user()->friendRequests();

		return view('friends.index')
				->with('friends', $friends)
				->with('requests', $requests);
	}

	public function getAdd($username)
	{
		$user = User::where('username', $username)->first();

		if (!$user) {
			return redirect()
					->route('home')
					->with('info', 'That user not found.');
		}

		if (Auth::user()->id === $user->id) {
			return redirect()
				->route('profile.index', ['username' => Auth::user()->username])
				->with('info', 'You can not to add yourself.');
		}

		if (Auth::user()->hasFriendRequestPending($user) ||
			$user->hasFriendRequestPending(Auth::user())) {
			return redirect()
					->route('profile.index', ['username' => $user->username])
					->with('info', 'Friend request already pending');
		}

		if (Auth::user()->isFriendsWith($user)) {
			return redirect()
					->route('profile.index', ['username' => $user->username])
					->with('info', 'You and '. $user->username . ' already friends.');
		}

		Auth::user()->addFriend($user);

		return redirect()
			->route('profile.index', ['username' => $username])
			->with('info', 'Friend request sent.');
	}

	public function getAccept($username)
	{
		$user = User::where('username', $username)->first();

		if (!$user) {
			return redirect()
					->route('home')
					->with('info', 'That user not found.');
		}

		if (!Auth::user()->hasFriendRequestReceived($user)) {
			return redirect()->route('home');
		}

		Auth::user()->acceptFriendRequest($user);

		return redirect()
			->route('profile.index', ['username' => $user->username])
			->with('info', 'Request to friends has been accepted.');
	}
}