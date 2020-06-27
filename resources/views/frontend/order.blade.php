@extends('frontend.app')
@section('icerik')
    <title>Fashi | Orders</title>
    <!-- Breadcrumb Section Begin -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <a href="/shop">Shop</a>
                        <span>Orders</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Orders Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if (\Session::has('orderSession'))
                        <div class="alert alert-info text-center">{{session()->get('orderSession')}}</div>
                    @endif
                    <div class="cart-table">
                        <table>
                            <thead style="background:#e7ab3c">
                            <tr>
                                <th style="color:#fff">Order Number</th>
                                <th style="color:#fff">Total Price</th>
                                <th style="color:#fff">Order Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class=" first-row">{{$order->order_no}}</td>
                                    <td class=" first-row">${{number_format((float)$order->order_total,2,'.','')}}</td>
                                    <td class=" first-row">{{$order->created_at->formatLocalized('%d')}} {{$order->created_at->formatLocalized('%b')}}
                                        ,{{$order->created_at->formatLocalized('%Y')}}</td>
                                </tr>
                            @endforeach
                            @if(count($orders)==0)
                                <tr class="mt-10">
                                    <td colspan="6">
                                        <div class="alert alert-info text-center" id="emptyAlert">You do not have any
                                            order.
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Orders Section End -->
@endsection

@section('css')
@endsection

@section('js')
@endsection
