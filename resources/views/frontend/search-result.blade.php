@extends('frontend.app')
@section('icerik')
    <title>Fashi | Shop</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                    @include('frontend.modules.shop-side-bar')
                </div>

                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="product-show-option">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="alert alert-info text-center">Result of search : <b>{{count($products)}}</b> {{count($products)>1 ? 'products' : 'product'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="product-list">
                        <div class="row">
                            @if(isset($products))
                                @foreach($products as $product)
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="product-item">
                                            <div class="pi-pic">
                                                @foreach($photos = Storage::disk('uploads')->files('img/products/'.$product->slug) as $photo)
                                                @endforeach
                                                <img src="/uploads/{{$photo}}" alt="">
                                                @if($product->pr_last_price < $product->pr_prev_price)
                                                    <div class="sale pp-sale">Sale</div>
                                                @endif
                                                <div class="icon">
                                                    <i class="icon_heart_alt"></i>
                                                </div>
                                                <ul>
                                                    <li class="quick-view"><a href="#">+ Quick View</a></li>
                                                </ul>
                                            </div>
                                            <div class="pi-text">
                                                <a href="shop/product-details/{{$product->slug}}">
                                                    <div class="catagory-name">{{$product->pr_name}}</div>
                                                </a>
                                                <div class="product-price">
                                                    ${{$product->pr_last_price}}
                                                    @if($product->pr_last_price < $product->pr_prev_price)
                                                        <span>${{$product->pr_prev_price}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif(isset($filteredProducts))
                                @foreach($filteredProducts->sortByDesc('id') as $product)
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="product-item">
                                            <div class="pi-pic">
                                                @foreach($photos = Storage::disk('uploads')->files('img/products/'.$product->slug) as $photo)
                                                @endforeach
                                                <img src="/uploads/{{$photo}}" alt="">
                                                @if($product->pr_last_price < $product->pr_prev_price)
                                                    <div class="sale pp-sale">Sale</div>
                                                @endif
                                                <div class="icon">
                                                    <i class="icon_heart_alt"></i>
                                                </div>
                                                <ul>
                                                    <li class="w-icon active"><a href="#"><i
                                                                class="icon_bag_alt"></i></a>
                                                    </li>
                                                    <li class="quick-view"><a href="#">+ Quick View</a></li>
                                                    <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="pi-text">
                                                <a href="shop/product-details/{{$product->slug}}">
                                                    <div class="catagory-name">{{$product->pr_name}}</div>
                                                </a>
                                                <div class="product-price">
                                                    ${{$product->pr_last_price}}
                                                    @if($product->pr_last_price < $product->pr_prev_price)
                                                        <span>${{$product->pr_prev_price}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->

@endsection

@section('css')
    {{--Sweet Alert--}}
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    <style>
        .swal-wide {
            width: 600px !important;
        }
    </style>
    {{--/Sweet Alert--}}
@endsection

@section('js')
    {{--Sweet Alert--}}
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script !src="">
            // Change price filter number to filtered number
            @if(isset($filteredMaxAmount))
        var filteredMaxNumber = '${{$filteredMaxAmount}}';
        var filteredMinNumber = '${{$filteredMinAmount}}';
        $('#maxamount').val(filteredMaxNumber);
        $('#minamount').val(filteredMinNumber);
        @endif

    </script>
@endsection
