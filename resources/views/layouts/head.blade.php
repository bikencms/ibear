<header>
        <nav>
            <ul>
                <li class="link">
                    <a href="#">TRANG CHỦ</a>
                </li>
                <li class="link shop">
                    <a href="#">CỬA HÀNG</a>
                </li>
                <li class="logo">
                    <a href="#"><img src="{{ url('assets/images/logo.png') }}" alt="Logo"></a>
                </li>
                <li class="icon user">
                    <ul class="icon-user">
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
                    </ul>
                </li>
                <li class="icon">
                    <a href="#">
                        <ul class="icon-cart">
                            <li><img src="{{ url('assets/images/cart.svg') }}" alt="Cart"></li>
                            <li>GIỎ HÀNG</li>
                        </ul>
                    </a>
                </li>
            </ul>
        </nav>
    </header>