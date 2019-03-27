@extends('layouts.app')



@section('content')
	
	<div class="container my-4">
		<div class="card">
			<div class="card-body">
				<h3 class="font-weight-bold pb-3">Shopping Cart Choices</h3>
				<hr>

				@foreach($carts as $index => $cart)
				<div style="margin-bottom: 25px;">
					<table class="table table-stripped" style="font-size: 20px;">
						<thead class="thead-dark">
							<tr>
								<th>Name</th>
								<th style="text-align: right;">Price</th>
							</tr>
							@foreach($cart['items'] as $product)
								<tr>
									<td>{{ $product->name }}<br><a href="#{{$index}}-product-{{$product->id}}" data-toggle="modal">View Details</a></td>
									<td style="text-align: right;">&#8377; {{ $product->price }}</td>
								</tr>
							@endforeach
							<tr>
								<td></td>
								<td style="text-align: right;font-weight: bold;">
									Total : &#8377; {{ $cart['total'] }}
								</td>
							</tr>

							<tr>
								<td style="font-weight: bold;">You Save : &#8377; {{ session('budget') - $cart['total'] }}</td>
								<td style="text-align: right;">
									<a class="btn btn-warning" href="/carts/choose/{{$index}}">Choose This Cart</a>
								</td>
							</tr>
						</thead>
					</table>
				</div>

				@foreach($cart['items'] as $product)

					<div id="{{$index}}-product-{{$product->id}}" class="modal" tabindex="-1" role="dialog">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title">{{ $product->name }}</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">

					     	<div class="row">
						        <div class="col-md-6">
						        	{!! $product->description !!}
						        </div>

						        <div class="col-md-6">
						        	<img src="{{ url($product->main_image) }}" style="width: 100%;height: 270px;">
						        </div>
					        </div>
						
							<hr>
								<p>
								@foreach($product->options as $option)
									{{ $option->nameWithAttr }} | 
								@endforeach
								</p>
							<hr>
						
							<h4><b>&#8377; {{ $product->price }}</b></h4>
					    
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>
								
				@endforeach

				@endforeach


			</div>
		</div>
	</div>


@endsection