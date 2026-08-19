<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ibear.vn 🥰| Shop gấu bông</title>
    
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://ibear.vn" />
    <meta property="og:title" content="ibear.vn 🥰| Shop gấu bông">
    <meta property="og:description" content="Alway smile 🥰">
    <meta property="og:image" content="https://ibear.vn/assets/images/logo_black.png">

    <meta property="fb:app_id" content="your_app_id" />

    <link rel="stylesheet" href="{{ url('assets/css/reset.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <link rel="stylesheet" href="vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="{{ url('css/vertical-layout-light/style.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/shop.css') }}">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-TV45K6YQCE"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-TV45K6YQCE');
    </script>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
</head>
<body>
<main id="shop">
    <header>
        <nav>
            <ul>
                <li class="logo">
                    <a href="#"><img src="{{ url('assets/images/logo_black.png') }}" alt="Logo"></a>
                </li>
                <li class="link shop">
                    <h1><a href="#">Shop gấu bông</a></h1>
                </li>
                <li class="icon user">
                    <!-- <ul class="icon-user">
                        @auth
                            <li><img src="{{ url('assets/images/my-shop.svg') }}" alt="User"></li>
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
                            <li><img src="{{ url('assets/images/user.svg') }}" alt="User"></li>
                            <li><a href="{{ route('register') }}">ĐĂNG KÝ</a>/<a href="{{ route('login') }}">ĐĂNG NHẬP</a></li>
                        @endguest
                    </ul> -->
                </li>
            </ul>
        </nav>
    </header>
    <!-- <section class="section-1">
        <h2>Shop ibear.vn</h2>
    </section> -->
</main>
<section class="section-2">
    <div class="search">
        <div class="search-inner">
            <form action="{{ route('shop_index') }}" method="GET">
                <input type="hidden" name="page" value="<?= isset($_GET['page']) ? $_GET['page'] : 1 ?>">
                <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                    <span class="input-group-addon input-group-prepend border-right">
                        <span class="icon-calendar input-group-text calendar-icon"></span>
                    </span>
                    <input type="text" class="form-control" name="date" placeholder="Tìm theo tên" autocomplete="off">
                    &nbsp;&nbsp;
                    <input type="image" src="{{ url('assets/images/search.svg') }}"  width="24px">
                </div>
            </form>
        </div>
    </div>
</section>
<section class="product-wrapper">
    <div class="product-wrapper-inner">
        @foreach($products as $key => $product)
            <div class="product">
                <div class="product-inner">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" width="100%">
                    <div class="product-detail">
                        <p><a href="">{{ $product->name }}</a></p>
                        <?php 
                            $dt = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $product->created_at);
                            $dt = new \Carbon\Carbon($dt->toDateString());
                            $newDate =  $dt->format('d/m/Y');
                        ?>
                        <p>Ngày đăng {{ $newDate }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        {!! $products->appends(request()->input())->links() !!}
    </div>
</section>
<footer class="text-center">
    <p>© <?= date('Y') ?> - Toàn bộ bản quyền thuộc ibear.vn</p>
</footer>
<script>
      $('#datepicker-popup').datepicker(
        {
            format: 'dd/mm/yyyy'
        }
      );
    </script>
</body>