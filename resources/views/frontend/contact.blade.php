@extends('frontend.app')
@section('icerik')
    <title>Fashi | Contact</title>

    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                        <span>Contact</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Map Section Begin -->
    <div class="map spad">
        <div class="container">
            <div class="map-inner">
                <iframe
                    src="{{$settings[0]->map}}"
                    height="610" style="border:0" allowfullscreen="">
                </iframe>
                <div class="icon">
                    <i class="fa fa-map-marker"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Map Section Begin -->

    <!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="contact-title">
                        <h4>Contacts Us</h4>
                        <p>{{$settings[0]->description}}</p>
                    </div>
                    <div class="contact-widget">
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-location-pin"></i>
                            </div>
                            <div class="ci-text">
                                <span>Address:</span>
                                <p>
                                    {{$settings[0]->address}}
                                </p>
                            </div>
                        </div>
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-mobile"></i>
                            </div>
                            <div class="ci-text">
                                <span>Phone:</span>
                                <p>
                                    {{$settings[0]->phone}}
                                </p>
                            </div>
                        </div>
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-email"></i>
                            </div>
                            <div class="ci-text">
                                <span>Faks:</span>
                                <p>
                                    {{$settings[0]->faks}}
                                </p>
                            </div>
                        </div>
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-email"></i>
                            </div>
                            <div class="ci-text">
                                <span>Email:</span>
                                <p>{{$settings[0]->mail}}</p>
                            </div>
                        </div>
                        <div class="cw-item">
                            @if(!empty($settings[0]->facebook))
                                <div class="ci-icon">
                                    <i class="ti-facebook"></i>
                                </div>
                                <div class="ci-text">
                                    <span>Facebook:</span>
                                    <p>{{$settings[0]->facebook}}</p>
                                </div>
                            @endif
                            @if(!empty($settings[0]->instagram))
                                <div class="ci-icon">
                                    <i class="ti-instagram"></i>
                                </div>
                                <div class="ci-text">
                                    <span>Instagram:</span>
                                    <p>{{$settings[0]->instagram}}</p>
                                </div>
                            @endif
                            @if(!empty($settings[0]->twitter))
                                <div class="ci-icon">
                                    <i class="ti-twitter"></i>
                                </div>
                                <div class="ci-text">
                                    <span>Twitter:</span>
                                    <p>{{$settings[0]->twitter}}</p>
                                </div>
                            @endif
                            @if(!empty($settings[0]->linkedin))
                                <div class="ci-icon">
                                    <i class="ti-linkedin"></i>
                                </div>
                                <div class="ci-text">
                                    <span>Linkedin:</span>
                                    <p>{{$settings[0]->linkedin}}</p>
                                </div>
                            @endif
                                @if(!empty($settings[0]->youtube))
                                <div class="ci-icon">
                                    <i class="fa fa-youtube-play"></i>
                                </div>
                                <div class="ci-text">
                                    <span>Youtube:</span>
                                    <p>{{$settings[0]->youtube}}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="contact-form">
                        <div class="leave-comment">
                            <h4>Leave A Comment</h4>
                            <p>Our staff will call back later and answer your questions.</p>
                            <form action="#" class="comment-form">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input type="text" placeholder="Your name">
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" placeholder="Your email">
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea placeholder="Your message"></textarea>
                                        <button type="submit" class="site-btn">Send message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->


@endsection

@section('css')
@endsection

@section('js')
@endsection

