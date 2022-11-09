<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Home page</title>
        <link rel="stylesheet" href="{{ url('assets/css/reset.css') }}">
        <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
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
        @include('layouts.head')

            <section class="vision text-center">
                <h2 class="margin-bottom10px">Quy trình bán hàng/mua hàng vô cùng đơn giản</h2>
                <div class="process">
                    <div class="col-4 padding20px inline-block">
                        <div class="process-inner">
                            <img class="margin-bottom10px" src="{{ url('assets/images/user-registry.svg') }}" alt="User Registry" width="70">
                            <p>Đăng ký</p>
                            <p>Chỉ với 1 bước đơn giản</p>
                        </div>
                    </div><div class="col-4 padding20px inline-block">
                        <div class="process-inner">
                            <img class="margin-bottom10px" src="{{ url('assets/images/user-product.svg') }}" alt="User Registry" width="70">
                            <p>Tạo sản phẩm hay mua hàng</p>
                            <p>Nhanh chóng, tiện lợi</p>
                        </div>
                    </div><div class="col-4 padding20px inline-block">
                        <div class="process-inner">
                            <img class="margin-bottom10px" src="{{ url('assets/images/user-contact.svg') }}" alt="User Registry" width="70">
                            <p>Kết nối</p>
                            <p>Rộng rãi, dễ dàng</p>
                        </div>
                    </div> 
                </div>
            </section>
        </main>
        <footer class="text-center">
            <!-- <nav>
                <ul>
                    <li class="link">
                        <a href="#">TRANG CHỦ</a>
                    </li>
                    <li class="link shop">
                        <a href="#">GIỚI THIỆU</a>
                    </li>
                    <li class="link shop">
                        <a href="#">GÓP Ý</a>
                    </li>
                    <li class="link shop">
                        <a href="#">LIÊN HỆ</a>
                    </li>
                </ul>
            </nav> -->
            <p>© <?= date('Y') ?> - Toàn bộ bản quyền thuộc ibear.vn</p>
        </footer>
    </body>
</html>