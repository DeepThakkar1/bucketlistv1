@extends('layouts.app')


@section('content')


	<div class="container py-4">
		<div class="card">
			<div class="card-body">
				<h2>Choose product categories you need</h2>

				<br>

				<form action="/categories/filters" method="POST">
					@csrf
					<div>
						@foreach($categories as $category)

							<input id="cat-{{$category->id}}" type="checkbox" value="{{ $category->id }}" name="categories[]">
							<label for="cat-{{$category->id}}" style="margin-right: 20px;">{{ $category->name }}</label>
						@endforeach
						<br><br>
						<button type="submit" class="btn btn-primary">Choose Categories and Set Filters</button>
					</div>
				</form>
				<br>
				<h3>Given Budget : Rs. {{ session('budget', 0) }}</h3>
			</div>
		</div>
	</div>
	

@endsection