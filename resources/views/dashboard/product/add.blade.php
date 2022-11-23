@extends('layouts.dashboard')
@section('content')
<div class="row">
  @include('dashboard.product.header')
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      @if(Session::has('success'))
          <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">×</button>
              {{Session::get('success')}}
          </div>
      @elseif(Session::has('failed'))
          <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">×</button>
              {{Session::get('failed')}}
          </div>
      @endif
      <div class="card-body">
        <h4 class="card-title">Upload product</h4>
        <p class="card-description">
          Fill and select
        </p>
        <form class="forms-sample" action="{{ route('dashboard.product.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="exampleInputName1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name" class="form-control @error('name') is-invalid @enderror" id="exampleInputName1" placeholder="Name">
            @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="form-group">
            <label>Image upload</label>
            <input type="file" name="image" class="file-upload-default">
            @error('image')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
            <div class="input-group col-xs-12">
              <input type="text" class="form-control file-upload-info @error('image') is-invalid @enderror" disabled="" placeholder="Upload Image">
              <span class="input-group-append">
                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
              </span>
            </div>
          </div>
          <div class="form-group">
            <label>Price</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-primary text-white">đ</span>
              </div>
              <input type="number" name="price" value="{{ old('price') }}" required autocomplete="price" class="form-control @error('price') is-invalid @enderror" aria-label="Amount (to the nearest dollar)">
              @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
          <button type="submit" class="btn btn-primary me-2">Submit</button>
          <a class="btn btn-light" href="{{ route('dashboard.product') }}">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
