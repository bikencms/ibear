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
        <main>
            <section class="vision">
                <h1 class="margin-bottom10px">"Má biết, má dzui đó"</h1>
                <p>Do nhu cầu mua sắm ngày càng tăng <br> mà các mặt hàng 
                    trên thị trường không đáp ứng được <br> nhu cầu người tiêu dùng 
                    như: giá cả, chất lượng,... <br>Chính vì thế ibear.vn ra đời.
                </p>
            </section>
            <section class="vision">
                <div class="col-6 background-purple inline-block text-center inner-vision color-pink">
                    <p class="title width-title">Nếu bạn muốn bán hàng trên website của tôi, hãy đăng ký shop của bạn</p>
                    <a class="button color-pink background-button-purple" href="#">ĐĂNG KÝ</a>
                </div><div class="col-6 background-pink inline-block text-center inner-vision color-purple">
                    <p class="title width-title">Nếu bạn chỉ muốn mua hàng, hãy đến với cửa hàng của chúng tôi</p>
                    <a class="button color-pink background-button-pink" href="#">CỬA HÀNG</a>
                </div>   
            </section>
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