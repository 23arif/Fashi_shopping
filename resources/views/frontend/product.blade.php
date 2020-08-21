@extends('frontend.app')
@section('icerik')
    <title>Fashi | Product</title>
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <a href="/shop">Shop</a>
                        <span>Details</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.modules.shop-side-bar')
                </div>
                <div class="col-lg-9">
                    @if (\Session::has('addToCartMsg'))
                        <div class="alert alert-info text-center">{{session()->get('addToCartMsg')}}</div>
                    @endif
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-pic-zoom">
                                @foreach($photos = Storage::disk('uploads')->files('img/products/'.$products->slug) as $photo)
                                @endforeach
                                <img class="product-big-img" src="/uploads/{{$photo}}" alt="{{$products->pr_name}}">
                                <div class="zoom-icon">
                                    <i class="fa fa-search-plus"></i>
                                </div>
                            </div>
                            <div class="product-thumbs">
                                <div class="product-thumbs-track ps-slider owl-carousel">
                                    @foreach($photos = Storage::disk('uploads')->files('img/products/'.$products->slug) as $photo)
                                        <div class="pt" data-imgbigurl="/uploads/{{$photo}}">
                                            <img src="/uploads/{{$photo}}" alt="{{$products->pr_name}}" height="200">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">

                            <div class="product-details">
                                <div class="pd-title">
                                    <span>{{$products->pr_name}}</span>
                                    <a href="#" class="heart-icon"><i class="icon_heart_alt"></i></a>
                                </div>
                                <div class="pd-rating">
                                    {{(new App\Http\Controllers\HomeGetController)->starRating($productRating)}}
                                    <span>({{$productRating}})</span>
                                </div>
                                <div class="pd-desc">
                                    <h4>${{$products->pr_last_price}}
                                        @if($products->pr_last_price < $products->pr_prev_price)
                                            <span>${{$products->pr_prev_price}}</span>
                                        @endif
                                    </h4>
                                </div>
                                {{--                                <div class="pd-color">--}}
                                {{--                                    <h6>Color</h6>--}}
                                {{--                                    <div class="pd-color-choose">--}}
                                {{--                                        <div class="cc-item">--}}
                                {{--                                            <input type="radio" id="cc-black">--}}
                                {{--                                            <label for="cc-black"></label>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="cc-item">--}}
                                {{--                                            <input type="radio" id="cc-yellow">--}}
                                {{--                                            <label for="cc-yellow" class="cc-yellow"></label>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="cc-item">--}}
                                {{--                                            <input type="radio" id="cc-violet">--}}
                                {{--                                            <label for="cc-violet" class="cc-violet"></label>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                <div class="pd-size-choose">
                                    @foreach($productSizes as $productSize)
                                        <div class="sc-item">
                                            <input type="radio" id="sm-size">
                                            <label for="sm-size">{{$productSize}}</label>
                                        </div>
                                    @endforeach
                                </div>

                                <form action="{{route('addToCart',['slug'=>$products->slug])}}" method="post">
                                    @csrf
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="1" name="quantity">
                                        </div>
                                        <button class="primary-btn pd-cart" type="submit" style="border: none">Add To
                                            Cart
                                        </button>
                                    </div>
                                </form>

                                <ul class="pd-tags">
                                    <li><span>BRAND</span>: {{$products->prBrand->name}}</li>
                                    <li><span>CATEGORIES</span>: {{$products->prCategory->category_name}}</li>
                                    <li><span>TAGS</span>:
                                        @foreach($products->prTags as $tag)
                                            {{ $loop->first ? '' : ', ' }}
                                            {{ucfirst($tag->tag)}}
                                        @endforeach
                                    </li>
                                </ul>
                                <div class="pd-share">
                                    <div class="p-code">Sku : #{{$products->pr_sku}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-tab">
                        <div class="tab-item">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#tab-1" role="tab">DESCRIPTION</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab-2" role="tab">SPECIFICATIONS</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab-3" role="tab">Customer Reviews ({{count($comments)}}
                                        )</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-item-content">
                            <div class="tab-content">
                                <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                                    <div class="product-content">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <h5>About :</h5>
                                                <p>
                                                    {!! $products->pr_desc !!}
                                                </p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img src="/uploads/{{$photo}}" alt="{{$products->pr_name}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                    <div class="specification-table">
                                        <table>
                                            <tr>
                                                <td class="p-catagory">Seller Name</td>

                                                <td class="p-stock">{{ucfirst($products->sellerName->name)}}</td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Customer Rating</td>
                                                <td>
                                                    <div class="pd-rating">
                                                        {{(new App\Http\Controllers\HomeGetController)->starRating($productRating)}}
                                                        <span>({{$productRating}})</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Price</td>
                                                <td>
                                                    <div class="p-price">${{$products->pr_last_price}}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Payments</td>
                                                <td>
                                                    <div class="cart-add">
                                                        @foreach($userExtraData->where('user_id',$products->seller_id) as $extra)

                                                            @if(!is_null($extra->paypal))
                                                                <img width="45" height="35"
                                                                     src="/uploads/payments/payPal.png"
                                                                     alt="">
                                                            @endif

                                                            @if(!is_null($extra->master_card))
                                                                <img width="45" height="35"
                                                                     src="/uploads/payments/masterCard.png" alt="">
                                                            @endif

                                                            @if(!is_null($extra->visa))
                                                                <img width="45" height="35"
                                                                     src="/uploads/payments/visa.png"
                                                                     alt="">
                                                            @endif

                                                            @if(empty($extra->paypal) && empty($extra->master_card) && empty($extra->visa))
                                                                <div class="p-stock"> No payments method</div>
                                                            @endif
                                                        @endforeach

                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Availability</td>
                                                <td>
                                                    <div class="p-stock">22 in stock</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Weight</td>
                                                <td>
                                                    <div class="p-weight">
                                                        {{number_format((float)$products->pr_weight,2,'.','')}} kq
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Size</td>
                                                <td>
                                                    <div class="p-size">
                                                        @foreach($productSizes as $productSize)
                                                            {{ $loop->first ? '' : ', ' }}
                                                            {{$productSize}}
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Color</td>
                                                <td><span class="cs-color"></span></td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Sku</td>
                                                <td>
                                                    <div class="p-code">#{{$products->pr_sku}}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                    <div class="customer-review-option">
                                        <h4>{{count($comments)}} Comments</h4>
                                        <div class="comment-option">
                                            @foreach($comments as $comment)
                                                <div class="co-item">
                                                    <div class="avatar-pic">
                                                        <img
                                                            src="/uploads/img/profileImages/{{$comment->getCommentUser->profile_image ? $comment->getCommentUser->slug."/".$comment->getCommentUser->profile_image : "default.png" }}"/>
                                                    </div>
                                                    <div class="avatar-text">
                                                        <div class="at-rating">
                                                            @if(!is_null($comment->rating))
                                                                {{(new App\Http\Controllers\HomeGetController)->starRating($comment->rating)}}
                                                            @endif
                                                        </div>
                                                        <h5>{{ucfirst($comment->getCommentUser->name)}}
                                                            &nbsp;{{ucfirst($comment->getCommentUser->surname )}}
                                                            <span>{{$comment->created_at->formatLocalized('%d')}} {{$comment->created_at->formatLocalized('%b')}},{{$comment->created_at->formatLocalized('%Y')}}</span>
                                                        </h5>
                                                        <div class="at-reply">{{$comment->comment}}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if(\Illuminate\Support\Facades\Auth::check())
                                            <div class="leave-comment">
                                                <h4>Leave A Comment</h4>
                                                <form method="post"
                                                      action="{{route('productComment',['slug'=>$products->slug])}}"
                                                      id="productCommentForm" class="comment-form">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <textarea placeholder="Messages" name="message"></textarea>
                                                            <div class="customize">
                                                                <div class="rating">
                                                                    <fieldset class="rating">
                                                                        <input type="radio" id="star5" name="rating"
                                                                               value="5"/>
                                                                        <label class="full" for="star5"
                                                                               title="Awesome - 5 stars"></label>
                                                                        <input type="radio" id="star4half" name="rating"
                                                                               value="4.5"/>
                                                                        <label class="half"
                                                                               for="star4half"
                                                                               title="Pretty good - 4.5 stars"></label>
                                                                        <input type="radio" id="star4" name="rating"
                                                                               value="4"/>
                                                                        <label class="full" for="star4"
                                                                               title="Pretty good - 4 stars"></label>
                                                                        <input type="radio" id="star3half" name="rating"
                                                                               value="3.5"/>
                                                                        <label class="half" for="star3half"
                                                                               title="Meh - 3.5 stars"></label>
                                                                        <input type="radio" id="star3" name="rating"
                                                                               value="3"/>
                                                                        <label class="full"
                                                                               for="star3"
                                                                               title="Meh - 3 stars"></label>
                                                                        <input type="radio" id="star2half" name="rating"
                                                                               value="2.5"/>
                                                                        <label class="half"
                                                                               for="star2half"
                                                                               title="Kinda bad - 2.5 stars"></label>
                                                                        <input type="radio" id="star2" name="rating"
                                                                               value="2"/>
                                                                        <label class="full"
                                                                               for="star2"
                                                                               title="Kinda bad - 2 stars"></label>
                                                                        <input type="radio" id="star1half" name="rating"
                                                                               value="1.5"/>
                                                                        <label class="half"
                                                                               for="star1half"
                                                                               title="Meh - 1.5 stars"></label>
                                                                        <input type="radio" id="star1" name="rating"
                                                                               value="1"/>
                                                                        <label class="full"
                                                                               for="star1"
                                                                               title="Sucks big time - 1 star"></label>
                                                                        <input type="radio" id="starhalf" name="rating"
                                                                               value="0.5"/>
                                                                        <label class="half"
                                                                               for="starhalf"
                                                                               title="Sucks big time - 0.5 stars"></label>
                                                                    </fieldset>
                                                                </div>
                                                                <button type="submit" class="site-btn">Send message
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        @else
                                            <div class="leave-comment">
                                                <div class="alert alert-info text-center">Please <a href="/login"
                                                                                                    class="href"><b>Login</b></a>
                                                    or <a
                                                        href="/register" class="href"><b>Register</b></a> for comment
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->

    <!-- Related Products Section End -->
    @if(count($relatedProducts)>0)
        <div class="related-products spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>Related Products</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-lg-3 col-sm-6">
                            <div class="product-item">
                                <div class="pi-pic">
                                    @foreach($photos = Storage::disk('uploads')->files('img/products/'.$relatedProduct->slug) as $photo)
                                    @endforeach
                                    <img src="/uploads/{{$photo}}" alt="{{$relatedProduct->pr_name}}">
                                    @if($relatedProduct->pr_last_price < $relatedProduct->pr_prev_price)
                                        <div class="sale">Sale</div>
                                    @endif
                                    <div class="icon">
                                        <i class="icon_heart_alt"></i>
                                    </div>
                                    <ul>
                                        <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                        <li class="quick-view"><a href="{{$relatedProduct->slug}}">+ Quick View</a></li>
                                    </ul>
                                </div>
                                <div class="pi-text">
                                    <a href="{{$relatedProduct->slug}}">
                                        <div class="catagory-name">{{$relatedProduct->pr_name}}</div>
                                    </a>
                                    <div class="product-price">
                                        ${{$relatedProduct->pr_last_price}}
                                        @if($relatedProduct->pr_last_price < $relatedProduct->pr_prev_price)
                                            <span>${{$relatedProduct->pr_prev_price}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    @endif
    <!-- Related Products Section End -->
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">

    <style>
        .href {
            color: #252525;
            font-size: 16px;
            font-weight: 400;
            transition: all .2s;

        }

        .href:hover, .href:focus {
            color: #e7ab3c;
            transition: all .1s;
        }

        .customize {
            display: flex;
            justify-content: space-between;
        }

        /****** Style Star Rating Widget *****/
        .rating {
            border: none;
            float: left;
        }

        .rating > input {
            display: none;
        }

        .rating > label:before {
            margin: 5px;
            font-size: 1.5em;
            font-family: FontAwesome;
            display: inline-block;
            content: "\f005";
        }

        .rating > .half:before {
            content: "\f089";
            position: absolute;
        }

        .rating > label {
            color: #ddd;
            float: right;
        }

        /***** CSS Magic to Highlight Stars on Hover *****/

        .rating > input:checked ~ label, /* show gold star when clicked */
        .rating:not(:checked) > label:hover, /* hover current star */
        .rating:not(:checked) > label:hover ~ label {
            color: #FFD700;
        }

        /* hover previous stars in list */

        .rating > input:checked + label:hover, /* hover current star when changing rating */
        .rating > input:checked ~ label:hover,
        .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
        .rating > input:checked ~ label:hover ~ label {
            color: #FFED85;
        }


    </style>
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#productCommentForm').ajaxForm({
                beforeSubmit: function () {
                    Swal.fire({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                        text: 'Loading please wait!',
                        showConfirmButton: false
                    })
                },
                success: function (response) {
                    Swal.fire(
                        response.processTitle,
                        response.processDesc,
                        response.processStatus
                    ).then(() => {
                        if (response.processStatus == "success") {
                            location.reload();
                        }
                    })
                }
            })
        })


        // $(document).ready(function () {
        //     $('.comment-form').ajaxForm({
        //         success: function (response) {
        //             Swal.fire(
        //                 response.processTitle,
        //                 response.processDesc,
        //                 response.processStatus
        //             )
        //                 .then(function () {
        //                     var repliedComment = $('#reply input').val();
        //
        //                     if ($('#reply input').attr('name') == 'primary_comment') {
        //                         $('html,body').animate({
        //                                 scrollTop: $('#' + repliedComment).offset().top
        //                             },
        //                             'slow');
        //                     } else {
        //                         $('html,body').animate({
        //                                 scrollTop: $("#comments").offset().top
        //                             },
        //                             'slow');
        //                     }
        //                 })
        //             if (response.processStatus == 'success') {
        //                 var content = document.getElementById('content').value;
        //                 if ($('#reply input').attr('name') == 'primary_comment') {
        //                     var repliedComment = $('#reply input').val();
        //                     var comment = '<div class="card card-inner">' +
        //                         '<div class="card-body" style="border:1px solid #f39313!important">' +
        //                         '<div class="row">' +
        //                         '<div class="col-md-2">' +
        //                         '<img src="/uploads/img/profileImages/default.png" class="img img-rounded img-fluid"/>' +
        //                         '<p class="text-secondary text-center" style="font-size: 13px"><i class="fa fa-clock-o"> </i> Just now</p>' +
        //                         '</div>' +
        //                         '<div class="col-md-10">' +
        //                         '<p>' +
        //                         '<p style="color:#f39313"><strong>You</strong></p>' +
        //                         '</p>' +
        //                         '<p>' + content + '</p>' +
        //                         '</div>' +
        //                         '</div>' +
        //                         '</div>' +
        //                         '</div>';
        //                     document.getElementById(repliedComment).innerHTML = comment;
        //
        //                 } else {
        //                     var comment = '<div class="card">' +
        //                         '<div class="card-body" style="border:1px solid #f39313!important">' +
        //                         '<div class="row">' +
        //                         '<div class="col-md-2">' +
        //                         '<img src="/uploads/img/profileImages/default.png" class="img img-rounded img-fluid"/>' +
        //                         '<p class="text-secondary text-center" style="font-size: 13px"><i class="fa fa-clock-o"> </i> Just now</p>' +
        //                         '</div>' +
        //                         '<div class="col-md-10">' +
        //                         '<p>' +
        //                         '<p style="color:#f39313"><strong>You</strong></p>' +
        //                         '</p>' +
        //                         '<p>' + content + '</p>' +
        //                         '</div>' +
        //                         '</div>' +
        //                         '</div>' +
        //                         '</div>';
        //                     document.getElementById('comments').innerHTML = comment;
        //                 }
        //
        //             }
        //         }
        //     })
        // })
    </script>
@endsection
