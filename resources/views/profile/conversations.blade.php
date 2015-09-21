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
		<div class="col-lg-10">
			@forelse($conversations as $chat)
				<div class="col-lg-12" style="height:80px; background-color: #E5F2F7; border-radius: 3px; border: 1px solid #BFE0EC; border-bottom: none;">
					<div class="col-lg-1" style="padding: 11px 0;">
						<a href="{{ route('profile.index', ['username' => $chat->user($chat->replyId)->username]) }}">
							<img src="https://pp.vk.me/c606219/v606219797/5b92/hkCTLtNnB-o.jpg" height="56">
						</a>
					</div>
					<div class="col-lg-2" style="padding: 10px 0;">
						<a href="{{ route('chat', ['id' => $chat->replyId]) }}">
							<div>{{ $chat->user($chat->replyId)->getNameOrUsername() }}</div>
						</a>
						<div style="color:#999; margin: 1px 0;">Online</div>
						<div style="color:#999;">{{ $chat->user($chat->replyId)->created_at->diffForHumans() }}</div>
					</div>
					<div class="col-lg-8" style="padding: 10px 0;">
						<a href="{{ route('chat', ['id' => $chat->replyId]) }}">
							<div class="col-lg-12" style="padding:20px; background-color: #fff; border-radius: 3px; border: 1px solid #BFE0EC; margin-bottom: 20px;">
								<p style="margin: 0; line-height: 1em; color: #67829E">Lorem ipsum donsecteti veniam mollitia a. Quasi, minus.</p>
							</div>
						</a>
					</div>
				</div>
			@empty
				<p>Нет диалогов.</p>
			@endforelse
		</div>
	</div>

@stop