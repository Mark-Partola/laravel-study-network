<?php namespace Chatty\Http\Controllers;

use Illuminate\Http\Request;
use Chatty\Models\User;
use Auth;

class ProfileController extends Controller
{

	public function getProfile($username) {
		$user = User::where('username', $username)->first();

		if(!$user) {
			abort(404);
		}

		$statuses = $user->statuses()
						->notReply()
						->orderBy('created_at', 'desc')
						->paginate(2);

		return view('profile.index')
			->with('profile', $user)
			->with('statuses', $statuses)
			->with('isShowStatuses', Auth::user()->id === $user->id || Auth::user()->isFriendsWith($user));
	}

	public function getEdit() {
		return view('profile.edit');
	}

	public function postEdit(Request $request) {
		$this->validate($request, [
			'first_name' => 'alpha|max:50',
			'last_name' => 'alpha|max:50',
			'location' => 'max:20',
		]);

		Auth::user()->update([
			'first_name' => $request->get('first_name'),
			'last_name' => $request->get('last_name'),
			'location' => $request->get('location'),
		]);

		return redirect()
				->route('profile.edit')
				->with('info', 'your profile has been updated');
	}

}