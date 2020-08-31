@extends('frontend.app')
@section('icerik')
    <title>Fashi | Shopping cart</title>
    <!-- Breadcrumb Section Begin -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <a href="/shop">Shop</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            @if (session()->has('notif'))
                <div class="alert alert-success text-center">{{session()->get('notif')}}</div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table>
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th class="p-name">Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Size</th>
                                <th>Total</th>
                                <th><i class="ti-close"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($fetchToCart))
                                @foreach($fetchToCart->sortByDesc('id') as $fetch)

                                    @foreach($photos = Storage::disk('uploads')->files('img/products/'.$fetch->getProductInfo->slug) as $photo)
                                    @endforeach
                                    <tr>
                                        <td class="cart-pic first-row"><img src="/uploads/{{$photo}}"
                                                                            alt=""></td>
                                        <td class="cart-title first-row">
                                            <h5>{{$fetch->getProductInfo->pr_name}}</h5>
                                        </td>
                                        <td class="p-price first-row">${{$fetch->getProductInfo->pr_last_price}}</td>
                                        <td class="qua-col first-row">
                                            <div class="quantity">
                                                <div class="pro-qtyy">
                                                    <button class="dec qtybtn"
                                                            onclick="decQtyy(this,'{{$fetch->product_id}}','{{$fetch->pr_size}}')">
                                                        -
                                                    </button>
                                                    <input id="productQuantity" type="text"
                                                           value="{{$fetch->quantity}}"
                                                           onchange="typeQty(this,'{{$fetch->product_id}}','{{$fetch->pr_size}}')">
                                                    <button class="inc qtybtn"
                                                            onclick="incQtyy(this,'{{$fetch->product_id}}','{{$fetch->pr_size}}')">
                                                        +
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="cart-title first-row text-center">
                                            <h5><b>{{$fetch->pr_size}}</b></h5>
                                        </td>
                                        @php($eachTotal = intval($fetch->quantity) * $fetch->getProductInfo->pr_last_price)
                                        <td class="total-price first-row">$ {{$eachTotal}}</td>
                                        <td class="close-td first-row"><i class="ti-close"
                                                                          onclick="deleteSelectedProduct(this,'{{$fetch->product_id}}','{{$fetch->pr_size}}')"></i>
                                        </td>
                                    </tr>

                                @endforeach

                                @if(count($fetchToCart) == 0)
                                    <tr class="mt-10">
                                        <td colspan="6">
                                            <div class="alert alert-info text-center" id="emptyAlert">You don't have any
                                                items in your
                                                cart.
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @else
                                @if(isset($basketArray))
                                    @foreach($basketArray as $key=>$value)
                                        @foreach($photos = Storage::disk('uploads')->files('img/products/'.\App\Product::where('id',$key)->first()->slug) as $photo)
                                        @endforeach
                                        <tr>
                                            <td class="cart-pic first-row"><img src="/uploads/{{$photo}}"
                                                                                alt=""></td>
                                            <td class="cart-title first-row">
                                                <h5>{{\App\Product::where('id',$key)->first()->pr_name}}</h5>
                                            </td>
                                            <td class="p-price first-row">
                                                ${{\App\Product::where('id',$key)->first()->pr_last_price}}</td>
                                            <td class="qua-col first-row">
                                                <div class="quantity">
                                                    <div class="pro-qtyy">
                                                    <span class="dec qtybtn"
                                                          onclick="decQtyy(this)">-</span>
                                                        <input id="productQuantity" type="text"
                                                               value="{{$value}}"
                                                               onkeyup="typeQty(this)">
                                                        <span class="inc qtybtn"
                                                              onclick="incQtyy(this)">+</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="total-price first-row">
                                                ${{number_format((float)$value * \App\Product::where('id',$key)->first()->pr_last_price,2,'.','')}}</td>
                                            <td class="close-td first-row"><i class="ti-close"
                                                                              onclick="deleteSelectedProduct(this)"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="mt-10">
                                        <td colspan="6">
                                            <div class="alert alert-info text-center" id="emptyAlert">You don't have any
                                                items in your
                                                cart.
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if(isset($fetchToCart))
                        @if(count($fetchToCart)>0)
                            <div class="row">
                                <div class="col-lg-4 offset-lg-8 mb-5">
                                    <div class="proceed-checkout">
                                        <ul>
                                            <li class="subtotal">Subtotal
                                                <span>${{number_format((float)$totalPrice,2,'.','')}}</span></li>
                                            <li class="subtotal">Shipping <span>$0.00</span></li>
                                            <li class="cart-total">Total
                                                <span>$ <span
                                                        id="cartTotal">{{number_format((float)$totalPrice,2,'.','')}}</span></span>
                                            </li>
                                        </ul>
                                        <a href="{{route('checkoutPage')}}" class="proceed-btn">PROCEED TO CHECK OUT</a>

                                    </div>
                                </div>
                            </div>
                        @endif
                    @elseif($basketArray)
                        <div class="row">
                            <div class="col-lg-4 offset-lg-8 mb-5">
                                <div class="proceed-checkout">
                                    <ul>
                                        <li class="subtotal">Subtotal
                                            <span>$</span></li>
                                        <li class="subtotal">Shipping <span>$0.00</span></li>
                                        <li class="cart-total">Total
                                            <span>$ <span
                                                    id="cartTotal"></span></span>
                                        </li>
                                    </ul>
                                    <a href="{{route('checkoutPage')}}" class="proceed-btn">PROCEED TO CHECK OUT</a>

                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->

@endsection

@section('css')
    {{--Sweet Alert--}}
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    {{--/Sweet Alert--}}
    <style>
        .cart-table table tr td.qua-col .pro-qtyy {
            width: 123px;
            height: 46px;
            border: 2px solid #ebebeb;
            padding: 0 15px;
            float: left;
        }

        .cart-table table tr td.qua-col .pro-qtyy .qtybtn {
            font-size: 24px;
            color: #b2b2b2;
            float: left;
            line-height: 38px;
            cursor: pointer;
            width: 18px;
        }

        .cart-table table tr td.qua-col .pro-qtyy .qtybtn.dec {
            font-size: 30px;
        }

        .cart-table table tr td.qua-col .pro-qtyy input {
            text-align: center;
            width: 52px;
            font-size: 14px;
            font-weight: 700;
            border: none;
            color: #4c4c4c;
            line-height: 40px;
            float: left;
        }

        .dec, .inc {
            border: 0px !important;
            background: transparent !important;
        }
    </style>
@endsection

@section('js')
    {{--Sweet Alert--}}
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script !src="">

        function typeQty(t, product_id, pr_size) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var typedQty = $(t).val();
            $.ajax({
                type: 'POST',
                url: '{{route('postShoppingCart')}}',
                data: {
                    '_token': CSRF_TOKEN,
                    'identifier': 'typeQty', // to identify fetch request
                    'product_id': product_id,
                    'pr_size': pr_size,
                    'typedQty': typedQty

                },success: function (response) {
                    if (response.processStatus == 'info' || response.processStatus == 'error') {
                        Swal.fire(
                            response.processTitle,
                            response.processDesc,
                            response.processStatus
                        ).then(() => {
                            location.reload();
                        })
                    } else {
                        location.reload();
                    }
                }
            })
        }

        function deleteSelectedProduct(t, product_id, pr_size) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: '{{route('postShoppingCart')}}',
                data: {
                    'identifier': 'deleteSelectedProduct', // to identify fetch request
                    'product_id': product_id,
                    'pr_size': pr_size,
                    '_token': CSRF_TOKEN
                },
                success: function (response) {
                    if (response.processStatus == 'error') {
                        Swal.fire(
                            response.processTitle,
                            response.processDesc,
                            response.processStatus
                        ).then(() => {
                            location.reload();
                        })
                    } else {
                        location.reload();
                    }
                }
            })
        }

        function decQtyy(t, pr_id, pr_size) {
            $(t).prop('disabled', true);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var newDecreasedQty = parseInt($(t).next().val()) - 1;
            $(t).next().val(newDecreasedQty)
            if (newDecreasedQty < 1) {
                newDecreasedQty = 'deleteProduct';
            }

            $.ajax({
                type: 'POST',
                url: "{{route('postShoppingCart')}}",
                data: {
                    'identifier': 'decQtyy', // to identify fetch request
                    'pr_id': pr_id,
                    'pr_size': pr_size,
                    'newDecreasedQty': newDecreasedQty,
                    '_token': CSRF_TOKEN
                }
                ,
                success: function (response) {
                    if (response.processStatus == 'error') {
                        Swal.fire(
                            response.processTitle,
                            response.processDesc,
                            response.processStatus
                        ).then(() => {
                            location.reload();
                        })
                    } else {
                        location.reload();
                    }
                }
            })
        }

        function incQtyy(t, pr_id, pr_size) {
            $(t).prop('disabled', true);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var newIncreasedQty = parseInt($(t).prev().val()) + 1;
            $(t).prev().val(newIncreasedQty);

            $.ajax({
                type: 'POST',
                url: "{{route('postShoppingCart')}}",
                data: {
                    'identifier': 'incQtyy', // to identify fetch request
                    'pr_id': pr_id,
                    'pr_size': pr_size,
                    'newIncreasedQty': newIncreasedQty,
                    '_token': CSRF_TOKEN
                },
                success: function (response) {
                    if (response.processStatus != 'success') {
                        Swal.fire(
                            response.processTitle,
                            response.processDesc,
                            response.processStatus
                        ).then(() => {
                            location.reload();
                        })
                    } else {
                        location.reload();
                    }
                }
            })
        }

    </script>
@endsection
