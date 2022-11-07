@extends('layouts.app')

@section('content')
    <main class="py py-4">
        <div class="container-dashboard">
            <div class="col-left inline-block vertical-align-middle">
                <nav>
                    <ul>
                        <li>Summary</li>
                        <li>Transaction</li>
                        <li>Statistics</li>
                        <li>Product</li>
                    </ul>
                </nav>
            </div><div class="col-center inline-block vertical-align-middle">
                center
            </div><div class="col-right inline-block vertical-align-middle">
                <ul>
                    <li>Shop Profile</li>
                    <li><a href="{{ route('dashboard') }}"></a>/<a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        <img width="20px" src="{{ url('assets/images/logout.svg') }}" alt="Log out">
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
                <div class="profile text-center margintop30px">
                    <img width="150px" src="{{ url('assets/images/shop.svg') }}" alt="Shop"> <br>
                    {{ Auth::user()->name }}
                    <div class="total margintop30px">
                        <div class="total-left">
                            <ul>
                                <li>
                                    <img width="15px" src="{{ url('assets/images/total.svg') }}" alt="Total"></li>
                                <li>
                                    4.8M <br>
                                    <span>VND</span>
                                </li>
                            </ul>
                        </div>
                        <div class="total-middle"></div>
                        <div class="total-right">
                            <ul>
                                <li>
                                    <img width="15px" src="{{ url('assets/images/product.svg') }}" alt="Product"></li>
                                <li>
                                    142 <br>
                                    <span>Products</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
