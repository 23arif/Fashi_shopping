@extends('frontend.app')
@section('icerik')
    <title>Fashi | Shop</title>
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <a href="/shop"> Shop</a>
                        <span>{{ucfirst($getBrand->name)}}</span>
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
                            <div class="col-lg-7 col-md-7">
                                <div class="select-option">
                                    <select class="sorting">
                                        <option value="">Default Sorting</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-5 text-right">
                                <p>{{count($products)}} {{count($products)>1 ? 'Products' : 'Product'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="product-list">
                        <div class="row">
                            @if(count($products))
                                @foreach($products as $product)
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="product-item">
                                            <div class="pi-pic">
                                                @foreach($photos = Storage::disk('uploads')->files('img/products/'.$product->slug) as $photo)
                                                @endforeach
                                                <img src="/uploads/{{$photo}}" alt="">
                                                @if($product->pr_last_price != $product->pr_prev_price)
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
                                                <a href="/shop/product-details/{{$product->slug}}">
                                                    <div class="catagory-name">{{$product->pr_name}}</div>
                                                </a>
                                                <div class="product-price">
                                                    ${{$product->pr_last_price}}
                                                    @if($product->pr_last_price != $product->pr_prev_price)
                                                        <span>${{$product->pr_prev_price}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert fashiInfoAlert">
                                    No products found for <u>{{ucfirst($getBrand->name)}}</u> brand
                                </div>
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
    <link rel="stylesheet" href="/css/projectCustom.css">
@endsection

@section('js')
@endsection
