@extends('layouts.app')



@section('content')
	
	<div class="container my-4">
		<div class="card">
			<div class="card-body">
				<h3 class="font-weight-bold pb-3">Orders History</h3>
				<hr>

				@foreach($orders as $index => $order)
				<div style="margin-bottom: 25px;">
					<h4>Order #{{$order->id}}</h4>
					<table class="table table-stripped" style="font-size: 18px;">
						<thead class="thead-dark">
							<tr>
								<th>Name</th>
								<th style="text-align: right;">Price</th>
							</tr>
							@foreach($order->products as $product)
								<tr>
									<td>{{ $product->name }}</td>
									<td style="text-align: right;">&#8377; {{ $product->price }}</td>
								</tr>
							@endforeach
							<tr>
								<td></td>
								<td style="text-align: right;font-weight: bold;">
									Total : &#8377; {{ $order->total }}
								</td>
							</tr>

							<tr>
								<td style="font-weight: bold;">You Saved : &#8377; {{ $order->savings }}</td>
								<td style="text-align: right;">
									<a class="btn btn-danger" href="/carts/reorder/{{$order->id}}">Reorder This</a>
								</td>
							</tr>
						</thead>
					</table>
				</div>
				@endforeach


			</div>
		</div>
	</div>

@endsection