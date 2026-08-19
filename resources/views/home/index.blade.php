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
        <link rel="stylesheet" href="css/vertical-layout-light/style.css">
        <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-TV45K6YQCE"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-TV45K6YQCE');
        </script>
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
            />
        
         <style>
            html,
            body {
                position: relative;
                height: 100%;
            }

            body {
                background: #000;
                font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
                font-size: 14px;
                color: #fff;
                margin: 0;
                padding: 0;
            }

            .swiper {
                width: 100%;
                height: 698px;
            }

            .swiper-slide {
                text-align: center;
                font-size: 18px;
                background: #444;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .swiper-slide img {
                display: block;
                width: 100%;
                height: 100%;
                object-fit: scale-down;
            }
        </style>
    </head>
    <body>
        @include('layouts.head')
        <main>
            <section class="container">
                <!-- Slider main container -->
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ url('assets/images/store/image6.jpg') }}" alt="Logo">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ url('assets/images/store/image7.png') }}" alt="Logo">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ url('assets/images/store/image1.jpg') }}" alt="Logo">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ url('assets/images/store/image2.jpg') }}" alt="Logo">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ url('assets/images/store/image3.jpg') }}" alt="Logo">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ url('assets/images/store/image4.jpg') }}" alt="Logo">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ url('assets/images/store/image5.jpg') }}" alt="Logo">
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </section>
        </main>
        <footer class="text-center">
            @include('layouts.footer')
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            var swiper = new Swiper(".mySwiper", {
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
            },
            loop: true,
            });
        </script>
    </body>
</html>
