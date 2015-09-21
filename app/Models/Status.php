<?php namespace Chatty\Models;

use Illuminate\Database\Eloquent\Model;
use Chatty\Models\User;

class Status extends Model
{
	protected $table = 'statuses';

	protected $fillable = [
		'body'
	];

	public function user() {
		return $this->belongsTo('Chatty\Models\User');
	}

	public function scopeNotReply($query)
	{
		return $query->where('parent_id', '=', 0);
	}

	public function replies()
	{
		return $this->hasMany('Chatty\Models\Status', 'parent_id');
	}

	public function likes()
	{
		return $this->morphMany('Chatty\Models\Like', 'likeable');
	}

}