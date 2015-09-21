@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-2" style="background-color: #fff; border-radius: 3px; border: 1px solid #BFE0EC; padding:0">
			<div class="list-group" style="margin:0">
			  <a href="#" class="list-group-item">Моя страница</a>
			  <a href="#" class="list-group-item"><span class="badge">2</span>Друзья</a>
			  <a href="{{ URL::route('chat.list') }}" class="list-group-item"><span class="badge"></span>Диалоги</a>
			  <a href="#" class="list-group-item"><span class="badge">1</span>Группы</a>
			  <a href="#" class="list-group-item"><span class="badge">14</span>Лента</a>
			</div>
		</div>
		<div class="col-lg-3">

				<div style="margin-bottom: 10px;">
					<img src="https://pp.vk.me/c622319/v622319731/1cc5f/lyML_nrf9VA.jpg" alt="" style="width:100%">
				</div>
				<div style="margin-bottom: 10px;">
				  <a href="#" class="btn btn-primary" style="width: 100%;">Редактировать страницу</a>
				</div>

				@if (Auth::user() && Auth::user()->hasFriendRequestPending($profile))
					<p>Waiting for {{ $profile->getNameOrUsername() }} to accept your request.</p>
				@elseif (Auth::user() && Auth::user()->hasFriendRequestReceived($profile))
					<a href="{{ route('friend.accept', ['username' => $profile->username]) }}" class="btn btn-primary">Accept friend request</a>
				@elseif (Auth::user() && Auth::user()->isFriendsWith($profile))
					<p>You and {{ $profile->getNameOrUsername() }} are friends.</p>
				@else
					@if (Auth::user() && $profile->id != Auth::user()->id)
						<a href="{{ route('friend.add', ['username' => $profile->username]) }}" class="btn btn-primary">Add as friend</a>
					@elseif (!Auth::user())
						<a href="{{ route('auth.signin') }}" class="btn btn-danger">Нужна авторизация</a>
					@endif
				@endif

				<div style="background-color: #fff; border-radius: 3px; border: 1px solid #BFE0EC;">
				  <div style="height:40px; margin-bottom: 20px; background-color: #E5F2F7;">
				  	<h3 style="text-align:center; margin: 0; padding: 0; font-size: 1.2em; color: #333; line-height: 2.2em;">Друзья</h3>
				  </div>
				  <div class="panel-body">
				    @if (!$profile->friends()->count())
				    	<p class="alert">No friends.</p>
				    @else
				    	@foreach($profile->friends() as $user)
				    		<div class="col-lg-4" style="word-wrap: break-word; text-align: center; padding: 0; height: 100px;">
				    			<a href="{{ route('profile.index', ['username' => $user->username]) }}">
									<img alt="{{ $user->getNameOrUsername() }}" src="{{ $user->getAvatarUrl() }}">
								</a>
								<div>
									<h4><a href="{{ route('profile.index', ['username' => $user->username]) }}">{{ $user->getNameOrUsername() }}</a></h4>
								</div>
				    		</div>
				    	@endforeach
				    @endif
				  </div>
				</div>
		</div>
		<div class="col-lg-7">
			<div class="row">
				<div class="col-lg-12" style="height:40px; margin-bottom: 20px; background-color: #E5F2F7; border-radius: 3px; border: 1px solid #BFE0EC;">
					<div class="navbar navbar">
						<h3 style="margin: 0; padding: 0; font-size: 1.2em; color: #333; line-height: 2.2em;">{{ $profile->getNameOrUsername() }}</h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12" style="padding:20px; background-color: #fff; border-radius: 3px; border: 1px solid #BFE0EC; margin-bottom: 20px;">
					<b>Адрес: </b>{{ $profile->location }}
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12" style="padding: 0;">

					@if (!$statuses->count())
						<p>There is nothing in your timeline yet.</p>
					@endif

					@if($isShowStatuses)
						@include('timeline/partials/statuses')
					@else
						<p>It is protected with privacy settings.</p>
					@endif

				</div>
			</div>
		</div>
	</div>

@stop