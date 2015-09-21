<?php namespace Chatty\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
	public function user($id)
	{
		return User::find($id);
	}
}