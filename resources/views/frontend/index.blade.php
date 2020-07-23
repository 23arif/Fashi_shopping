@extends('frontend.app')
@section('icerik')
    <title>Fashi | Online Shopping</title>

    <!-- Hero Section Begin -->
    @if($settings[0]->slider == 1)
        <section class="hero-section">
            <div class="hero-items owl-carousel">
                @foreach($slides as $slide)
                    <div class="single-hero-items set-bg" data-setbg="/uploads/img/Slider/{{$slide->image}}">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h1>{{$slide->title}}</h1>
                                    <p>{{$slide->description}}</p>
                                    <a href="{{$slide->link}}" class="primary-btn">Shop Now</a>
                                </div>
                            </div>
                            @if(!empty($slide->sale))
                                <div class="off-card">
                                    <h2>Sale <span>{{$slide->sale}}%</span></h2>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <div class="banner-section spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <a href="{{route('prCategory',['catName'=>'men'])}}">
                        <div class="single-banner">
                            <img src="/frontend/img/banner-1.jpg" alt="">
                            <div class="inner-text">
                                <h4>Men’s</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a href="{{route('prCategory',['catName'=>'women'])}}">
                        <div class="single-banner">
                            <img src="/frontend/img/banner-2.jpg" alt="">
                            <div class="inner-text">
                                <h4>Women’s</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a href="{{route('prCategory',['catName'=>'kids'])}}">
                        <div class="single-banner">
                            <img src="/frontend/img/banner-3.jpg" alt="">
                            <div class="inner-text">
                                <h4>Kid’s</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Section End -->

    <!-- Women Banner Section Begin -->
    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg" data-setbg="/frontend/img/products/women-large.jpg">
                        <h2>Women’s</h2>
                        <a href="{{route('prCategory',['catName'=>'women'])}}">Discover More</a>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <div class="product-slider owl-carousel">
                        @foreach($allProducts->where('pr_category',2) as $product)
                            @foreach($photos = Storage::disk('uploads')->files('img/products/'.$product->slug) as $photo)
                            @endforeach
                            <div class="product-item">
                                <div class="pi-pic">
                                    <img src="/uploads/{{$photo}}" alt="{{$product->pr_name}}">
                                    @if($product->pr_prev_price != $product->pr_last_price)
                                        <div class="sale">Sale</div>
                                    @endif
                                    <div class="icon">
                                        <i class="icon_heart_alt"></i>
                                    </div>
                                    <ul>
                                        <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                        <li class="quick-view"><a href="#">+ Quick View</a></li>
                                    </ul>
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">{{$product->pr_name}}</div>
                                    <div class="product-price">
                                        ${{$product->pr_last_price}}
                                        @if($product->pr_prev_price != $product->pr_last_price)
                                            <span>${{$product->pr_prev_price}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Women Banner Section End -->

    <!-- Deal Of The Week Section Begin-->
    @if(\App\Deal::where('id',1)->first())
        @if($deals->enable_disable == 1)
            <section class="deal-of-week set-bg spad" data-setbg="/frontend/img/time-bg.jpg">
                <div class="container">
                    <div class="col-lg-6 text-center">
                        <div class="section-title">
                            <h2>{{$deals->title}}</h2>
                            <p>{{$deals->desc}}</p>
                            <div class="product-price">
                                ${{$deals->price}}
                                <span>/ {{$deals->pr_name}}</span>
                            </div>
                        </div>
                        <div class="countdown-timer" id="countdown">
                            <div class="cd-item">
                                <span>{{$deals->day}}</span>
                                <p>Days</p>
                            </div>
                            <div class="cd-item">
                                <span>{{$deals->hourse}}</span>
                                <p>Hrs</p>
                            </div>
                            <div class="cd-item">
                                <span>{{$deals->minute}}</span>
                                <p>Mins</p>
                            </div>
                            <div class="cd-item">
                                <span>{{$deals->second}}</span>
                                <p>Secs</p>
                            </div>
                        </div>
                        <a href="{{$deals->link}}" class="primary-btn">Shop Now</a>
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- Deal Of The Week Section End -->

    <!-- Man Banner Section Begin -->
    <section class="man-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="product-slider owl-carousel">
                        @foreach($allProducts->where('pr_category',1) as $product)
                            @foreach($photos = Storage::disk('uploads')->files('img/products/'.$product->slug) as $photo)
                            @endforeach
                            <div class="product-item">
                                <div class="pi-pic">
                                    <img src="/uploads/{{$photo}}" alt="{{$product->pr_name}}">
                                    @if($product->pr_prev_price != $product->pr_last_price)
                                        <div class="sale">Sale</div>
                                    @endif
                                    <div class="icon">
                                        <i class="icon_heart_alt"></i>
                                    </div>
                                    <ul>
                                        <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                        <li class="quick-view"><a href="#">+ Quick View</a></li>
                                    </ul>
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">{{$product->pr_name}}</div>
                                    <div class="product-price">
                                        ${{$product->pr_last_price}}
                                        @if($product->pr_prev_price != $product->pr_last_price)
                                            <span>${{$product->pr_prev_price}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="product-large set-bg m-large" data-setbg="/frontend/img/products/man-large.jpg">
                        <h2>Men’s</h2>
                        <a href="{{route('prCategory',['catName'=>'men'])}}">Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Man Banner Section End -->

    <!-- Latest Blog Section Begin -->
    <section class="latest-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>From The Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($fromTheBlog->sortByDesc('id')->take(3) as $blog)
                    @foreach($photos = Storage::disk('uploads')->files('img/blog/'.$blog->slug) as $photo)
                    @endforeach
                    <div class="col-lg-4 col-md-6">
                        <div class="single-latest-blog">
                            <img src="/uploads/{{$photo}}" width="100" height="150" alt="{{$blog->title}}">
                            <div class="latest-text">
                                <div class="tag-list">
                                    <div class="tag-item">
                                        <i class="fa fa-calendar-o"></i>
                                        {{$blog->created_at->formatLocalized('%d')}} {{$blog->created_at->formatLocalized('%b')}}
                                        ,{{$blog->created_at->formatLocalized('%Y')}}
                                    </div>
                                    <div class="tag-item">
                                        <i class="fa fa-comment-o"></i>
                                        {{$blog->comments->count()}}
                                    </div>
                                </div>
                                <a href="/blog/@if(isset($blog->parent))@php($primaryCategory=$blog->parent)@if(isset($primaryCategory->parent))@php($doubleprimaryCategory= $primaryCategory->parent)@if(isset($doubleprimaryCategory->parent)){{$doubleprimaryCategory->parent->slug}}/@endif{{$primaryCategory->parent->slug}}/@endif{{$blog->parent->slug}}/@endif{{$blog->slug}}">
                                    <h4>{{$blog->title}}</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="benefit-items">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="/frontend/img/icon-1.png" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Free Shipping</h6>
                                <p>For all order over 99$</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="/frontend/img/icon-2.png" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Delivery On Time</h6>
                                <p>If good have prolems</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-benefit">
                            <div class="sb-icon">
                                <img src="/frontend/img/icon-1.png" alt="">
                            </div>
                            <div class="sb-text">
                                <h6>Secure Payment</h6>
                                <p>100% secure payment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Blog Section End -->

    <!-- Partner Logo Section Begin -->
    <div class="partner-logo">
        <div class="container">
            <div class="logo-carousel owl-carousel">
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="/frontend/img/logo-carousel/logo-1.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="/frontend/img/logo-carousel/logo-2.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="/frontend/img/logo-carousel/logo-3.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="/frontend/img/logo-carousel/logo-4.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="/frontend/img/logo-carousel/logo-5.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Partner Logo Section End -->
@endsection()

@section('css')
@endsection()

@section('js')
@endsection()
