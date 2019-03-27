@extends('layouts.app')


@section('content')

	
	<div class="container py-4">
		<div class="card">
			<div class="card-body">
				<h2>Enter your budget</h2>
				<form action="/budget/set" method="POST">
					@csrf
					<input type="number" name="budget" class="form-control">
					<br>
					<button class="btn btn-success" type="submit">Set Budget</button>
				</form>
			</div>
		</div>
	</div>


@endsection