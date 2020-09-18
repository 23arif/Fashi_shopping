<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fashi Template">
    <meta name="keywords" content="Fashi, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="/frontend/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/frontend/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/frontend/css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="/frontend/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="/frontend/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="/frontend/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="/frontend/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="/frontend/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/frontend/css/style.css" type="text/css">
    <style>
        .welcome {
            color: #252525;
            transition: all 0.1s;
        }

        .welcome:hover, .welcome:focus {
            color: #e7ab3c;
            transition: all 0.1s;
            text-decoration: underline;
        }
    </style>
    @yield('css')
</head>

<body>
<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Header Section Begin -->
<header class="header-section">
    <div class="header-top">
        <div class="container">
            <div class="ht-left">
                <div class="mail-service">
                    <i class=" fa fa-envelope"></i>
                    {{$settings[0]->mail}}
                </div>
                <div class="phone-service">
                    <i class=" fa fa-phone"></i>
                    + {{$settings[0]->phone}}
                </div>
            </div>
            <div class="ht-right">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <a href="{{route('logout')}}" class="login-panel"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="fa fa-sign-out pull-right"></i> Log Out</a>

                    {{--Hidden form for logout.We need to change get to post with form--}}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    {{--/Hidden form for logout.We need to change get to post with form--}}

                @else
                    <a href="/login" class="login-panel">
                        <i class="fa fa-user"></i> Login
                    </a>
                @endif

                @if(\Illuminate\Support\Facades\Auth::check())
                    <div class="top-welcome">
                        Welcome <b><a
                                @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->status()>0)
                                href="/admin @endif"
                                class="welcome">{{ucfirst(\Illuminate\Support\Facades\Auth::user()->name)}}</a></b>
                    </div>
                @endif


                <div class="lan-selector">
                    <select class="language_drop" id="locale" name="locale" onchange="langLocalization()"
                            style="width:300px;">
                        @foreach($locales as $locale)
                            <option @if(App::isLocale($locale->abbreviation)) selected
                                    @endif value='{{$locale->abbreviation}}'
                                    data-image="/frontend/img/{{$locale->flag}}"
                                    data-imagecss="flag yt"
                                    data-title="{{$locale->abbreviation}}">{{ucfirst($locale->abbreviation)}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="top-social">
                    @if(!empty($settings[0]->facebook))
                        <a href="{{$settings[0]->facebook}}"><i class="ti-facebook"></i></a>
                    @endif
                    @if(!empty($settings[0]->twitter))
                        <a href="{{$settings[0]->twitter}}"><i class="ti-twitter-alt"></i></a>
                    @endif

                    @if(!empty($settings[0]->instagram))
                        <a href="{{$settings[0]->instagram}}"><i class="ti-instagram"></i></a>
                    @endif

                    @if(!empty($settings[0]->linkedin))
                        <a href="{{$settings[0]->linkedin}}"><i class="fa fa-linkedin-square"></i></a>
                    @endif

                    @if(!empty($settings[0]->youtube))
                        <a href="{{$settings[0]->youtube}}"><i class="fa fa-youtube-play"></i></a>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="inner-header">
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <div class="logo">
                        <a href="/">
                            <img src="/uploads/img/Logo/{{$settings[0]->header_logo}}" alt="{{$settings[0]->title}}">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="advanced-search">
                        <div class="input-group">
                            <form action="{{route('searchPage')}}" method="GET" id="searchForm">
                                <input type="text" name="result" placeholder="What do you need?" autocomplete="off">
                                <button type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 text-right col-md-3">
                    <ul class="nav-right">
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <li class="orders-icon">
                                <a href="{{route('ordersPage')}}">
                                    <i class="ti-clipboard"></i>
                                </a>
                            </li>
                        @endif
                        <li class="heart-icon">
                            <a href="#">
                                <i class="icon_heart_alt"></i>
                                <span>1</span>
                            </a>
                        </li>
                        <li class="cart-icon">
                            <a href="/shop/shopping-cart">
                                <i class="icon_bag_alt"></i>
                                <span id="basketCounter">
                                @if(\Illuminate\Support\Facades\Auth::check())
                                        {{count(\App\Basket::where('user_id', \Illuminate\Support\Facades\Auth::id())->get())}}
                                    @else
                                        @if(isset($basketArray))
                                            {{count($basketArray)}}
                                        @else
                                            0
                                        @endif
                                    @endif
                                </span>
                            </a>
                            <div class="cart-hover">
                                <div class="select-items">
                                    <table>
                                        <tbody>
                                        @if(count($cartProducts) == 0)
                                            <div class="alert alert-info text-center h6" id="cartEmptyAlert">Cart is
                                                empty.
                                            </div>
                                        @else
                                            @if(count($cartProducts)>3)
                                                @foreach($cartProducts->take(3) as $cartProduct)
                                                    @foreach($photos = Storage::disk('uploads')->files('img/products/'.$cartProduct->getProductInfo->slug) as $photo)
                                                    @endforeach
                                                    <tr>
                                                        <td class="si-pic">
                                                            <img src="/uploads/{{$photo}}" alt="" width="80"
                                                                 height="80">
                                                        </td>
                                                        <td class="si-text">
                                                            <div class="product-selected">
                                                                <p>${{$cartProduct->getProductInfo->pr_last_price}}
                                                                    x {{$cartProduct->quantity}}</p>
                                                                <h6>{{\Illuminate\Support\Str::limit($cartProduct->getProductInfo->pr_name,15,$end='...')}}</h6>

                                                            </div>
                                                        </td>
                                                        <td class="si-close">
                                                            <i class="ti-close"></i>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    <td colspan="3" align="center">
                                                        <a href="{{route('shoppingCartPage')}}"
                                                           style="color: #f39313;font-weight: bold">
                                                            . . .
                                                        </a>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach($cartProducts as $cartProduct)
                                                    @foreach($photos = Storage::disk('uploads')->files('img/products/'.$cartProduct->getProductInfo->slug) as $photo)
                                                    @endforeach
                                                    <tr>
                                                        <td class="si-pic">
                                                            <img src="/uploads/{{$photo}}" width="80"
                                                                 height="80">
                                                        </td>
                                                        <td class="si-text">
                                                            <div class="product-selected">
                                                                <p>${{$cartProduct->getProductInfo->pr_last_price}}
                                                                    x {{$cartProduct->quantity}}</p>
                                                                <h6>{{\Illuminate\Support\Str::limit($cartProduct->getProductInfo->pr_name,15,$end='...')}}</h6>

                                                            </div>
                                                        </td>
                                                        <td class="si-close">
                                                            <i class="ti-close"></i>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                @if(count($cartProducts) != 0)
                                    <div class="select-total">
                                        <span>total:</span>
                                        <h5>${{number_format((float)$totalPrice,2,',','')}}</h5>
                                    </div>
                                @endif
                                <div class="select-button">
                                    <a href="{{route('shoppingCartPage')}}" class="primary-btn view-card">VIEW CARD</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-item">
        <div class="container">
            <div class="nav-depart">
                <div class="depart-btn">
                    <i class="ti-menu"></i>
                    <span>All departments</span>
                    <ul class="depart-hover">
                        @foreach($allDepartments as $department)
                            {{--                            class="active"--}}
                            <li>
                                <a href="{{route('prCategory',['catName'=>$department->slug])}}">{{$department->category_name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <nav id="spcMenu" class="nav-menu mobile-menu">
                <ul>
                    <li {{$activeUrl =='127.0.0.1:8000' ? "class=active" : ' '}}><a
                            href="{{route('homePage')}}">Home</a></li>
                    <li {{$activeUrl=='shop' ? "class=active" : ' '}}><a href="{{route('shopPage')}}">Shop</a></li>
                    <li {{$activeUrl=='blog' ? "class=active" : ' '}}><a href="{{route('blogPage')}}">Blog</a></li>
                    <li {{$activeUrl=='contact' ? "class=active" : ' '}}><a href="{{route('contactPage')}}">Contact</a>
                    </li>
                    <li {{$activeUrl=='faq' ? "class=active" : ' '}}><a href="{{route('faqPage')}}">Faqs</a></li>
                </ul>
            </nav>
            <div id="mobile-menu-wrap"></div>
        </div>
    </div>
</header>
<!-- Header End -->

@yield('icerik')


<!-- Footer Section Begin -->
<footer class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="footer-left">
                    <div class="footer-logo">
                        <a href="/"><img src="/uploads/img/Logo/{{$settings[0]->footer_logo}}"
                                         alt="{{$settings[0]->title}}"></a>
                    </div>
                    <ul>
                        <li>Address: {{$settings[0]->address}}</li>
                        <li>Phone: +{{$settings[0]->phone}}</li>
                        <li>Faks: +{{$settings[0]->faks}}</li>
                        <li>Email: {{$settings[0]->mail}}</li>
                    </ul>
                    <div class="footer-social">
                        @if(!empty($settings[0]->facebook))
                            <a href="{{$settings[0]->facebook}}"><i class="ti-facebook"></i></a>
                        @endif
                        @if(!empty($settings[0]->twitter))
                            <a href="{{$settings[0]->twitter}}"><i class="ti-twitter-alt"></i></a>
                        @endif

                        @if(!empty($settings[0]->instagram))
                            <a href="{{$settings[0]->instagram}}"><i class="ti-instagram"></i></a>
                        @endif

                        @if(!empty($settings[0]->linkedin))
                            <a href="{{$settings[0]->linkedin}}"><i class="fa fa-linkedin-square"></i></a>
                        @endif

                        @if(!empty($settings[0]->youtube))
                            <a href="{{$settings[0]->youtube}}"><i class="fa fa-youtube-play"></i></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-1">
                <div class="footer-widget">
                    <h5>Information</h5>
                    <ul>
                        <li><a href="{{route('contactPage')}}">Contact</a></li>
                        <li><a href="{{route('faqPage')}}">FAQs</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="footer-widget">
                    <h5>My Account</h5>
                    <ul>
                        <li><a href="{{route('adminIndex')}}">My Account</a></li>
                        <li><a href="{{route('shopPage')}}">Shop</a></li>
                        <li><a href="{{route('shoppingCartPage')}}">Shopping Cart</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="newslatter-item">
                    <h5>Join Our Newsletter Now</h5>
                    <p>Get E-mail updates about our latest shop and special offers.</p>
                    <form action="{{route('newsletterMails')}}" method="post" class="subscribe-form">
                        @csrf
                        <input type="email" placeholder="Enter Your Mail"
                               name="email" {{$errors->any() || session()->has('mailAdded') ? 'autofocus': ''}}>
                        <button type="submit">Subscribe</button>
                    </form>
                    <ul style="list-style: none">
                        @if(session()->has('mailAdded'))
                            <li class="text-success"><i class="fa fa-check"></i>&nbsp;{{session()->get('mailAdded')}}
                            </li>
                        @endif
                        @if($errors->any())
                            <li style="color:#e7ab3c">
                                <i class="fa fa-warning"></i>&nbsp;{{ implode('', $errors->all(':message')) }}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-reserved">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright-text">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                        All rights reserved by <span
                            style="color: #e7ab3c;font-weight: bold">{{$settings[0]->title}}</span>
                    </div>
                    <div class="payment-pic">
                        <img src="/frontend/img/payment-method.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Js Plugins -->
<script src="/frontend/js/jquery-3.3.1.min.js"></script>
<script src="/frontend/js/bootstrap.min.js"></script>
<script src="/frontend/js/jquery-ui.min.js"></script>
<script src="/frontend/js/jquery.countdown.min.js"></script>
<script src="/frontend/js/jquery.nice-select.min.js"></script>
<script src="/frontend/js/jquery.zoom.min.js"></script>
<script src="/frontend/js/jquery.dd.min.js"></script>
<script src="/frontend/js/jquery.slicknav.js"></script>
<script src="/frontend/js/owl.carousel.min.js"></script>
<script src="/frontend/js/main.js"></script>

<script>
    document.onreadystatechange = function () {
        var selected_parent;
        if (document.readyState === 'interactive') {
            selected_parent = $('#spcMenu').children().find('a').filter('.active').parent('li').index();
            jQuery.data(document.body, "selected_parent", selected_parent);
        }
        if (document.readyState === 'complete') {
            var selected_parent = jQuery.data(document.body, "selected_parent");
            $('#spcMenu').children('li:eq(' + selected_parent + ')').children('a').addClass('active');
        }
    }
</script>
<script !src="">
    function langLocalization() {
        var l = document.getElementById('locale').value;
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: '/locale',
            data: {
                'locale': l,
                '_token': CSRF_TOKEN
            },
            success: function (response) {
                location.reload();
            }
        })
    }
</script>
@yield('js')
</body>

</html>
