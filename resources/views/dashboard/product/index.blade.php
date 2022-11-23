@extends('layouts.dashboard')
@section('content')
<div class="row">
  @include('dashboard.product.header')
  @foreach( $products as $product )
  <div class="col-sm-3 grid-margin stretch-card">
    <div class="card card-rounded">
      <div class="card-body">
      @if( $product->is_public == 1 )
        <label class="badge badge-success">Public</label>
      @else
        <label class="badge badge-danger">Un-Public</label>
      @endif
        <div class="row">
            <div class="d-flex justify-content-between align-items-center">
              <img class="img-xl rounded-circle" width="100%" src="/uploads/{{ $product->image }}" alt="Profile image">
            </div>
            <div class="col-12 text-center mt-5">
              <h4 class="rate-percentage">{{ $product->name }}</h4>
            </div>
            <div class="col-12">
              <h6 class="text-success text-center"><span>{{ $product->price }}đ</span></h6>
            </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection
