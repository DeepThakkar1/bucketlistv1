@extends('layouts.app')



@section('content')
	
	<div class="container my-4">
		<div class="card">
			<div class="card-body">
				<h3 class="font-weight-bold pb-3">Define your preferences</h3>
				<form action="/carts" method="POST">
					@csrf
					@foreach($categories as $category)

						<h4 class="font-weight-bold">{{ $category->name }}</h4>

						@foreach($category->attributes as $attribute)

							<h5 style="margin-top: 4px;">{{ $attribute->name }}</h5>

							@foreach($attribute->options as $option)
								
								<input id="option_{{$option->id}}" type="checkbox" value="{{ $option->id }}" name="options_{{$category->id}}[]">
								<label for="option_{{$option->id}}" style="margin-right: 20px;">{{ $option->name }}</label>
							@endforeach
						@endforeach
						<br><br>
					@endforeach

					<br>
					<button class="btn btn-primary" type="submit">Find Products</button>
					<br><br>
					<h3>Given Budget : Rs. {{ session('budget', 0) }}</h3>
				</form>
			</div>
		</div>
	</div>

@endsection