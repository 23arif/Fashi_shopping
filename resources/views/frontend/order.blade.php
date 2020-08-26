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
                    @if(isset($orders))
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
                                    <th style="color:#fff">Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class=" first-row">#{{$order->order_no}}</td>
                                        <td class=" first-row">
                                            ${{number_format((float)$order->order_total,2,'.','')}}</td>
                                        <td class=" first-row">{{$order->created_at->formatLocalized('%d')}} {{$order->created_at->formatLocalized('%b')}}
                                            ,{{$order->created_at->formatLocalized('%Y')}}</td>
                                        @if($order->order_purchase ==1)
                                            <td class="first-row"><a
                                                    href="{{route('orderDetailsPage',['slug'=>$order->order_no])}}"
                                                    class="detailsLink">Details</a></td>
                                        @else
                                            <td class="first-row"><p class="text-info"><b>Processing...</b></p></td>
                                        @endif
                                    </tr>
                                @endforeach
                                @if(count($orders)==0)
                                    <tr class="mt-10">
                                        <td colspan="6">
                                            <div class="alert alert-info text-center" id="emptyAlert">You do not have
                                                any
                                                order.
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    @elseif(isset($orderDetails))
                        <section class="content invoice">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-xs-12 invoice-header">
                                    <h1>
                                        <i class="fa fa-globe"></i> Invoice.
                                        <small class="pull-right">Date: 16/08/2016</small>
                                    </h1>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    From
                                    <address>
                                        <strong>Iron Admin, Inc.</strong>
                                        <br>795 Freedom Ave, Suite 600
                                        <br>New York, CA 94107
                                        <br>Phone: 1 (804) 123-9876
                                        <br>Email: ironadmin.com
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    To
                                    <address>
                                        <strong>John Doe</strong>
                                        <br>795 Freedom Ave, Suite 600
                                        <br>New York, CA 94107
                                        <br>Phone: 1 (804) 123-9876
                                        <br>Email: jon@ironadmin.com
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice #007612</b>
                                    <br>
                                    <br>
                                    <b>Order ID:</b> 4F3S8J
                                    <br>
                                    <b>Payment Due:</b> 2/22/2014
                                    <br>
                                    <b>Account:</b> 968-34567
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-xs-12 table">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Product</th>
                                            <th>Serial #</th>
                                            <th style="width: 59%">Description</th>
                                            <th>Subtotal</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Call of Duty</td>
                                            <td>455-981-221</td>
                                            <td>El snort testosterone trophy driving gloves handsome gerry Richardson
                                                helvetica tousled street art master testosterone trophy driving gloves
                                                handsome gerry Richardson
                                            </td>
                                            <td>$64.50</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Need for Speed IV</td>
                                            <td>247-925-726</td>
                                            <td>Wes Anderson umami biodiesel</td>
                                            <td>$50.00</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Monsters DVD</td>
                                            <td>735-845-642</td>
                                            <td>Terry Richardson helvetica tousled street art master, El snort
                                                testosterone trophy driving gloves handsome letterpress erry Richardson
                                                helvetica tousled
                                            </td>
                                            <td>$10.70</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Grown Ups Blue Ray</td>
                                            <td>422-568-642</td>
                                            <td>Tousled lomo letterpress erry Richardson helvetica tousled street art
                                                master helvetica tousled street art master, El snort testosterone
                                            </td>
                                            <td>$25.99</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-xs-6">
                                    <p class="lead">Payment Methods:</p>
                                    <img src="images/visa.png" alt="Visa">
                                    <img src="images/mastercard.png" alt="Mastercard">
                                    <img src="images/american-express.png" alt="American Express">
                                    <img src="images/paypal.png" alt="Paypal">
                                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning
                                        heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo
                                        ifttt zimbra.
                                    </p>
                                </div>
                                <!-- /.col -->
                                <div class="col-xs-6">
                                    <p class="lead">Amount Due 2/22/2014</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>$250.30</td>
                                            </tr>
                                            <tr>
                                                <th>Tax (9.3%)</th>
                                                <td>$10.34</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping:</th>
                                                <td>$5.80</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>$265.24</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-xs-12">
                                    <button class="btn btn-default" onclick="window.print();"><i
                                            class="fa fa-print"></i> Print
                                    </button>
                                </div>
                            </div>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Orders Section End -->
@endsection

@section('css')
    <style>
        .detailsLink {
            color: #000;
            font-weight: bold;
        }

        .detailsLink:hover, .detailsLink:focus {
            color: #f39313;
        }
    </style>
@endsection

@section('js')

@endsection
