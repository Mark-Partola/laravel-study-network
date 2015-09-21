<?php namespace Chatty\Http\Controllers;

use Illuminate\Http\Request;
use Chatty\Models\User;
use Chatty\Models\Status;
use Auth;

class StatusController extends Controller
{
	public function postStatus(Request $request)
	{
		$this->validate($request, [
			'status' => 'required|max:1000'
		]);

		\Auth::user()->statuses()->create([
			'body' => $request->get('status')
		]);

		return redirect()
			->route('home')
			->with('info', 'Your status has been published.');

	}

	public function postReply(Request $request, $statusId)
	{
		$this->validate($request, [
			"body-{$statusId}" => 'required|max:1000'
		], [
			'required' => 'The reply body is required.'
		]);

		/*Только корневая*/
		$status = Status::notReply()->find($statusId);

		if (!$status) {
			return redirect()->route('home')->with('info', 'Комментировать можно только записи');
		}

		/*
		* Можно писать только другу или себе
		*/
		if (!Auth::user()->isFriendsWith($status->user) &&
			Auth::user()->id !== $status->user->id) {
			return redirect()->route('home')->with('info', 'Вы не можете писать этому пользователю. Добавьте его в друзья.');
		}

		$reply = Status::create([
			'body' => $request->input("body-{$statusId}")
		])->user()->associate(Auth::user());

		$status->replies()->save($reply);

		return redirect()->back()->with('info', 'Ваш комментарий опубликован.');
	}

	public function getLike($statusId)
	{
		$status = Status::find($statusId);
		
		if (!$status) {
			return redirect()->back();
		}

		if (!Auth::user()->isFriendsWith($status->user)) {
			return redirect()->back();
		}

		if (Auth::user()->hasLikedStatus($status)) {
			return redirect()->back()->with('info', '2');
		}

		$like = $status->likes()->create([]);

		Auth::user()->likes()->save($like);

		return redirect()->back();
	}
}