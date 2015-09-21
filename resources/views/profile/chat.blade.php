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
			@forelse($messages as $message)
				<p>{{ $message->body }}</p>
			@empty
				<p>Здесь будет выводиться история переписки.</p>
			@endforelse
		</div>
	</div>

@stop