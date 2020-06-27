@extends('frontend.app')
@section('icerik')
    <title>Fashi | Check out</title>
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <a href="/shop">Shop</a>
                        <span>Check Out</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Shopping Cart Section Begin -->
    <section class="checkout-section spad">
        <div class="container">
            <form action="{{route('checkoutPost')}}" method="post" class="checkout-form">
                @csrf
                <div class="row">
                    <div class="col-lg-7">
                        <div class="col-lg-12">
                            @if(!\Illuminate\Support\Facades\Auth::check())
                                <div class="checkout-content">
                                    <a href="#" class="content-btn">Click Here To Login</a>
                                </div>
                            @endif
                            {{--                            @if($errors->any())--}}
                            {{--                                <ul>--}}
                            {{--                                    @foreach($errors->all() as $error)--}}
                            {{--                                        <li>{{$error}}</li>--}}
                            {{--                                    @endforeach--}}
                            {{--                                </ul>--}}
                            {{--                            @endif--}}
                            <h4>Billing Details</h4>
                            <div class="row">
                                <div class="col-lg-6  mb-3">
                                    <label for="billing_firstName">First Name<span>*</span></label>
                                    <input type="text" name="billing_first_name" id="billing_firstName"
                                           placeholder="Name" value="{{ old('billing_firstName') }}">
                                    @if($errors->has('billing_firstName'))
                                        <small class="text-danger">{{$errors->first('billing_firstName')}}</small>
                                    @endif
                                </div>
                                <div class="col-lg-6  mb-3">
                                    <label for="billing_lastName">Last Name<span>*</span></label>
                                    <input type="text" name="billing_last_name" id="billing_lastName"
                                           placeholder="Last Name" value="{{ old('billing_lastName') }}">
                                    @if($errors->has('billing_lastName'))
                                        <small for="billing_lastName" class="text-danger">{{$errors->first('billing_lastName')}}</small>
                                    @endif
                                </div>
                                <div class="col-lg-12  mb-3">
                                    <label for="billing_country">Country<span>*</span></label>
                                    <input type="text" name="billing_country" id="billing_country"
                                           placeholder="Country" value="{{ old('billing_country') }}">
                                    @if($errors->has('billing_country'))
                                        <small class="text-danger">{{$errors->first('billing_country')}}</small>
                                    @endif
                                </div>
                                <div class="col-lg-12  mb-3">
                                    <label for="billing_street">Street Address<span>*</span></label>
                                    <input type="text" name="billing_street_1" id="street" class="billing_street"
                                           placeholder="Street Address 1" value="{{ old('billing_street_1') }}">
                                    @if($errors->has('billing_street_1'))
                                        <small class="text-danger">{{$errors->first('billing_street_1')}}</small>
                                    @endif
                                    <input type="text" name="billing_street_2" class="mt-3" placeholder="Street Address 2" value="{{ old('billing_street_2') }}">
                                </div>
                                <div class="col-lg-12  mb-3">
                                    <label for="billing_zip">Postcode / ZIP<span>*</span></label>
                                    <input type="text" name="billing_zip" id="billing_zip" placeholder="Postcode / ZIP" value="{{ old('billing_zip') }}">
                                    @if($errors->has('billing_zip'))
                                        <small class="text-danger">{{$errors->first('billing_zip')}}</small>
                                    @endif
                                </div>
                                <div class="col-lg-12  mb-3">
                                    <label for="billing_town">Town / City<span>*</span></label>
                                    <input type="text" name="billing_town" id="billing_town" placeholder="Town / City" value="{{ old('billing_town') }}">
                                    @if($errors->has('billing_town'))
                                        <small class="text-danger">{{$errors->first('billing_town')}}</small>
                                    @endif
                                </div>
                                <div class="col-lg-6  mb-3">
                                    <label for="billing_email">Email Address<span>*</span></label>
                                    <input type="text" name="billing_email" id="billing_email" placeholder="Email" value="{{ old('billing_email') }}">
                                    @if($errors->has('billing_email'))
                                        <small class="text-danger">{{$errors->first('billing_email')}}</small>
                                    @endif
                                </div>
                                <div class="col-lg-6  mb-3">
                                    <label for="billing_phone">Phone<span>*</span></label>
                                    <input type="text" name="billing_phone" id="billing_phone" placeholder="Phone" value="{{ old('billing_phone') }}">
                                    @if($errors->has('billing_phone'))
                                        <small class="text-danger">{{$errors->first('billing_phone')}}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <h4>Card Details</h4>
                            <div class="row">
                                <div class="col-lg-12  mb-3">
                                    <label for="cardHolder">Card Holder<span>*</span></label>
                                    <input type="text" class="cardHolder" placeholder="NAME HERE">
                                </div>

                                <div class="col-lg-12  mb-3">
                                    <label for="cardNumber">Card Number<span>*</span></label>
                                    <input type="text" class="form-control"
                                           data-inputmask="'mask' : '9999-9999-9999-9999'"
                                           placeholder="0000 0000 0000 0000">
                                </div>

                                <div class="col-lg-6  mb-3">
                                    <label for="expiredDate">Expires<span>*</span></label>
                                    <input type="text" class="form-control" data-inputmask="'mask': '99/99'"
                                           placeholder="MM/YY">
                                </div>

                                <div class="col-lg-6  mb-3">
                                    <label for="cvv">CVV<span>*</span></label>
                                    <input type="text" class="cvv" maxlength="3" placeholder="000">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 " id="orderSummary">
                        <div class="col-lg-12 sticky-top">
                            {{--Coupon Code field--}}
                            {{--                        <div class="checkout-content">--}}
                            {{--                            <input type="text" placeholder="Enter Your Coupon Code">--}}
                            {{--                        </div>--}}
                            <div class="place-order">
                                <h4>Your Order</h4>
                                <div class="order-total">
                                    <ul class="order-table">
                                        <li>Product <span>Total</span></li>
                                        @foreach($cartProducts as $cartProduct)
                                            <li class="fw-normal">{{$cartProduct->getProductInfo->pr_name}}
                                                x {{$cartProduct->quantity}}
                                                <span>${{$cartProduct->getProductInfo->pr_last_price * $cartProduct->quantity}}</span>
                                            </li>
                                        @endforeach
                                        <li class="fw-normal">Subtotal
                                            <span>${{number_format((float)$totalPrice,2,'.','')}}</span></li>
                                        <li class="total-price">Total
                                            <span>${{number_format((float)$totalPrice,2,'.','')}}</span></li>
                                    </ul>
                                    {{--                                <div class="payment-check">--}}
                                    {{--                                    <div class="pc-item">--}}
                                    {{--                                        <label for="pc-check">--}}
                                    {{--                                            Cheque Payment--}}
                                    {{--                                            <input type="checkbox" id="pc-check">--}}
                                    {{--                                            <span class="checkmark"></span>--}}
                                    {{--                                        </label>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="pc-item">--}}
                                    {{--                                        <label for="pc-paypal">--}}
                                    {{--                                            Paypal--}}
                                    {{--                                            <input type="checkbox" id="pc-paypal">--}}
                                    {{--                                            <span class="checkmark"></span>--}}
                                    {{--                                        </label>--}}
                                    {{--                                    </div>--}}
                                    {{--                                </div>--}}
                                    <div class="order-btn">
                                        <button type="submit" class="site-btn place-btn">Place Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>
    <!-- Shopping Cart Section End -->

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
@endsection

@section('css')
    <style>
       .container input{
           margin-bottom: 0px;
       }
    </style>
@endsection

@section('js')
    <!-- jquery.inputmask -->
    <script src="/backend/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- /jquery.inputmask -->

    <!-- jquery.inputmask -->
    <script>
        $(document).ready(function () {
            $(":input").inputmask();
        });
    </script>
    <!-- /jquery.inputmask -->
@endsection
