<?php namespace Chatty\Http\Controllers;

use Illuminate\Http\Request;
use Chatty\Models\User;
use Chatty\Models\Conversation;
use Chatty\Models\Message;
use Auth;

class MessageController extends Controller
{
	public function getConversations()
	{
		$conversation = Conversation::where('user_one', '=', Auth::user()->id)
			->orWhere('user_two', '=', Auth::user()->id)
			->get();

		foreach ($conversation as $key => $val) {
			$reply = ($val->user_one === Auth::user()->id) ?
											$val->user_two :
											$val->user_one;
			$conversation[$key]['replyId'] = $reply;
		}


		return \View::make('profile.conversations')
			->with('conversations', $conversation);
	}

	public function getChat($id)
	{
		$messages = Message::where('conversation_id', $id)->get();
		return view('profile.chat')
			->with('messages', $messages);
	}
}