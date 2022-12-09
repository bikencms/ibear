<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home page</title>
    <link rel="stylesheet" href="{{ url('assets/css/reset.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/shop.css') }}">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-R0GX9KF0TH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-R0GX9KF0TH');
    </script>
</head>
<body>
<main id="shop">
    <header>
        <nav>
            <ul>
                <li class="icon user">
                    <ul class="icon-user">
                        @auth
                            <li>
                                <a href="{{ route('dashboard') }}"></a>/<a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('ĐĂNG XUẤT') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li><a href="{{ route('register') }}"><img src="{{ url('assets/images/user-registry.svg') }}" alt="User"></a></li>
                            <li><a href="{{ route('login') }}"><img src="{{ url('assets/images/login.svg') }}" alt="User"></a></li>
                        @endguest
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <section class="section-1">
        <h2>Shop ibear.vn</h2>
    </section>
</main>
<section class="section-2">
    <div class="search">
        <div class="search-inner">
            <form action="/shop" method="GET">
                <input type="text" placeholder="Tìm kiếm sản phẩm" name="name"> 
                <input type="image" src="{{ url('assets/images/search.svg') }}"  width="24px">
            </form>
        </div>
    </div>
</section>
<section class="product-wrapper">
    <div class="product-wrapper-inner">
        @foreach($products as $product)<div class="product">
                <div class="product-inner">
                    <img src="{{ url('uploads/') }}/{{ $product->image }}" alt="{{ $product->name }}" width="100%">
                    <p><a href="">{{ $product->name }}</a></p>
                    <p class="red">{{ $product->price }}</p>
                    <p class="margin-bottom-10px"><img src="{{ url('assets/images/shop-store.svg') }}" alt="shop store" width="20px"><a href="{{ route('shop.detail', ['id'=>$product->user_id]) }}">{{ $product->user_name }}</a></p>
                </div>
            </div>@endforeach
    </div> 
</section>
<footer class="text-center">
    <p>© <?= date('Y') ?> - Toàn bộ bản quyền thuộc ibear.vn</p>
</footer>
</body>