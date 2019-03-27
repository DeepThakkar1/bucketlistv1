@extends('layouts.app')



@section('content')
    
<section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Welcome to BucketList</h1>
          <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
          <p>
            <a href="/budget/set" class="btn btn-success my-2">Create My Bucket</a>
          </p>
        </div>
      </section>


      <div class="container d-block text-center pt-5">
        <h3 class="font-weight-bold">A Huge Range of Products</h3>
    </div>

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">

            
          @foreach(App\Models\Category::orderBy('name', 'ASC')->get() as $category)
                <div class="col-md-4">
                  <div class="card mb-4 box-shadow">
                    <div class="card-body">
                      <h4 class="font-weight-bold">{{ $category->name }}</h4>
                      <p class="card-text">{!! $category->description !!}</p>
                     
                    </div>
                  </div>
                </div>
           @endforeach 
         
          </div>
        </div>
@endsection