@extends('templates.default')

@section('content')

	<div class="row">
		<div class="col-lg-6">
			<form action="{{ route('status.post') }}" method="post">
				<div class="form-group {{ $errors->has('status') ? 'has-error': '' }}">
					<textarea  name="status" class="form-control" cols="30" rows="2" placeholder="What's up {{ Auth::user()->getFirstNameOrUsername() }}?"></textarea>
					<span  class="help-block">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>
				</div>
				{!! csrf_field() !!}
				<button type="submit" class="btn btn-default">Update status</button>
			</form>
			<hr>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-5">
			@if (!$statuses->count())
				<p>There is nothing in your timeline yet.</p>
			@endif

			@include('timeline.partials.statuses')

		</div>
	</div>

@stop