<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="/backend/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/backend/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/backend/vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/backend/build/css/custom.min.css" rel="stylesheet">
    @yield('css')
</head>
<style>
    .customProfileImage {
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        width: 80px;
        height: 80px;
        overflow: hidden;
        margin-left: 15px;
    }

    .customProfileImage img {
        max-width: 100%;
        max-height: 100%;
    }

    .profile_info {
        width: 130px;
        float: right
    }
</style>
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="/admin" class="site_title"><i class="fa fa-paw"></i> <span>Admin Panel</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic customProfileImage">

                        @php
                            $id  =\Illuminate\Support\Facades\Auth::user()->id;
                            $userData = \App\User::where('id',$id)->first();
                        @endphp

                        <img
                            src="@if(empty($userData->profile_image))/uploads/img/profileImages/default.png @else /uploads/img/profileImages/{{$userData->slug}}/{{$userData->profile_image}}@endif">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>{{ucfirst(\Illuminate\Support\Facades\Auth::user()->name)}}</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- /menu profile quick info -->

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>General</h3>

                        <ul class="nav side-menu">
                            <li><a href="{{route('adminIndex')}}"><i class="fa fa-home"></i> Home </a></li>
                            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->status() == 9)
                                <li><a href="{{route('adminSettingsPage')}}"><i class="fa fa-cog"></i> Settings </a>
                                </li>
                            @endif
                            <li><a href="{{route('sliderPage')}}"><i class="fa fa-magic"></i> Slider </a></li>
                            <li><a href="{{route('adminProductsPage')}}"><i class="fa fa-shopping-basket"></i> Products
                                </a></li>
                            <li><a href="{{route('adminCategoryPage')}}"><i class="fa fa-newspaper-o"></i> Blog Category
                                </a></li>
                            <li><a href="{{route('adminBlogPage')}}"><i class="fa fa-newspaper-o"></i> Blog </a></li>
                            <li><a href="{{route('getDeal')}}"><i class="fa fa-gift"></i> Deals </a></li>
                            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->status() == 9)
                                <li>
                                    <a href="{{route('getUserTable')}}"><i class="fa fa-users"></i> Users Table </a>
                                </li>

                                <li>
                                    <a href="{{route('getOrdersTable')}}"><i class="fa fa-list-alt"></i> Orders Table
                                    </a>
                                </li>
                            @endif
                            <li><a href="{{route('getBanners')}}"><i class="fa fa-image"></i> Banners </a></li>
                            <li><a href="{{route('adminFaqPage')}}"><i class="fa fa-question-circle-o"></i> FAQs </a>
                            </li>
                            <li><a href="{{route('adminMessagesPage')}}"><i class="fa fa-envelope-o"></i> Messages </a>
                            </li>
                            <li>
                                <a href="{{route('adminNewsletterEmailsPage')}}"><i class="fa fa-mail-reply-all"></i>
                                    Newsletter </a>
                            </li>

                        </ul>
                    </div>

                </div>
                <!-- /sidebar menu -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <img
                                    src="@if(empty($userData->profile_image))/uploads/img/profileImages/default.png @else /uploads/img/profileImages/{{$userData->slug}}/{{$userData->profile_image}}@endif">
                                {{ucfirst(\Illuminate\Support\Facades\Auth::user()->name)}}
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li>
                                    <a href="/admin/profile/{{\Illuminate\Support\Facades\Auth::user()->slug}}-{{\Illuminate\Support\Facades\Auth::user()->id}}">
                                        Profile</a></li>
                                <li>
                                    <a href="/">Back to Web site</a>
                                </li>
                                <li>
                                    <a href="{{route('logout')}}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                            class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                        {{--Hidden form for logout.We need to change get to post with form--}}
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        {{--/Hidden form for logout.We need to change get to post with form--}}

                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span
                                    class="badge bg-green">{{count(\App\ContactComment::where('check_message', 0)->get())}}</span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                @foreach(\App\ContactComment::where('check_message', 0)->get() as $message)
                                    <li>
                                        <a href="{{route('readMessage',['slug'=>$message->slug])}}">
                                        <span>
                                          <span><b>{{$message->name}}</b></span>
                                          <span class="time"> {{$message->created_at->diffForHumans()}}</span>
                                        </span>
                                            <span class="message">
                                            {{\Illuminate\Support\Str::limit($message->message,150,$end='...')}}
                                        </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        @yield('icerik')
    </div>
</div>

<!-- jQuery -->
<script src="/backend/vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/backend/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/backend/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="/backend/vendors/nprogress/nprogress.js"></script>

<!-- Custom Theme Scripts -->
<script src="/backend/build/js/custom.min.js"></script>
@yield('js')
</body>
</html>
