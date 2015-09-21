@foreach ($statuses as $status)
	<div class="media" style="padding:20px; background-color: #fff; border-radius: 3px; border: 1px solid #BFE0EC;">
		<a href="{{ route('profile.index', ['username' => $status->user->username]) }}" class="pull-left">
			<img src="{{ $status->user->getAvatarUrl() }}" alt="" class="media-object">
		</a>
		<div class="media-body">
			<h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $status->user->username]) }}">{{ $status->user->getNameOrUsername() }}</a></h4>
			<p>{{ $status->body }}</p>
			<ul class="list-inline">
				<li>{{ $status->created_at->diffForHumans() }}</li>
				@if ($status->user->id !== Auth::user()->id)
					<li><a href="{{ route('status.like', ['statusId' => $status->id]) }}" class="btn btn-success" style="line-height:1em; padding: 3px 7px;">Like</a></li>
				@endif
				<li>{{ $status->likes->count() }} {{ str_plural('like', $status->likes->count()) }}</li>
			</ul>

			@foreach ($status->replies as $reply)
				<div class="media">
					<a href="{{ route('profile.index', ['username' => $reply->user->username]) }}" class="pull-left">
						<img src="{{ $reply->user->getAvatarUrl() }}" alt="" class="media-object">
					</a>
					<div class="media-body">
						<h5 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a></h5>
						<p>{{ $reply->body }}</p>
						<ul class="list-inline">
							<li>{{ $reply->created_at->diffForHumans() }}</li>
							@if ($reply->user->id !== Auth::user()->id)
								<li><a href="{{ route('status.like', ['statusId' => $reply->id]) }}" class="btn btn-success" style="line-height:1em; padding: 3px 7px;">Like</a></li>
							@endif
							<li>{{ $reply->likes->count() }} {{ str_plural('like', $reply->likes->count()) }}</li>
						</ul>
					</div>
				</div>
			@endforeach

			<form action="{{ route('status.reply', ['statusId' => $status->id]) }}" method="post">
				<div class="form-group {{ $errors->has("body-{$status->id}") ? 'has-error' : '' }}">
					<textarea name="body-{{$status->id}}" rows="2" class="form-control"></textarea>
					@if ($errors->has("body-{$status->id}"))
						<span class="help-block">{{ $errors->first("body-{$status->id}") }}</span>
					@endif
				</div>
				{!! csrf_field() !!}
				<input type="submit" value="Reply" class="btn btn-default">
			</form>

		</div>

	</div>
@endforeach
{!! $statuses->render() !!}