@extends('layouts.dashboard')
@section('content')
<div class="row">
  @include('dashboard.product.header')
  <div class="col-sm-3 grid-margin stretch-card">
    <div class="card card-rounded">
      <div class="card-body">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center">
              <img class="img-xl rounded-circle" width="100%" src="/assets/images/product-create.png" alt="Profile image">
            </div>
            <div class="col-12 text-center mt-5">
              <h4 class="rate-percentage">Product Name</h4>
            </div>
            <div class="col-12">
              <h6 class="text-success text-center"><span>12,000,000đ</span></h6>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-3 grid-margin stretch-card">
  <div class="card card-rounded">
    <div class="card-body">
      <div class="row">
          <div class="d-flex justify-content-between align-items-center">
            <img class="img-xl rounded-circle" width="100%" src="/assets/images/product-create.png" alt="Profile image">
          </div>
          <div class="col-12 text-center mt-5">
            <h4 class="rate-percentage">Product Name</h4>
          </div>
          <div class="col-12">
            <h6 class="text-success text-center"><span>12,000,000đ</span></h6>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-3 grid-margin stretch-card">
    <div class="card card-rounded">
      <div class="card-body">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center">
              <img class="img-xl rounded-circle" width="100%" src="/assets/images/product-create.png" alt="Profile image">
            </div>
            <div class="col-12 text-center mt-5">
              <h4 class="rate-percentage">Product Name</h4>
            </div>
            <div class="col-12">
              <h6 class="text-success text-center"><span>12,000,000đ</span></h6>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-3 grid-margin stretch-card">
  <div class="card card-rounded">
    <div class="card-body">
      <div class="row">
          <div class="d-flex justify-content-between align-items-center">
            <img class="img-xl rounded-circle" width="100%" src="/assets/images/product-create.png" alt="Profile image">
          </div>
          <div class="col-12 text-center mt-5">
            <h4 class="rate-percentage">Product Name</h4>
          </div>
          <div class="col-12">
            <h6 class="text-success text-center"><span>12,000,000đ</span></h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
