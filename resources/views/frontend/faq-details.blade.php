@extends('frontend.app')
@section('icerik')
    <title>Fashi | FAQs details</title>
    <!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-details-inner">
                        <p><a href="/" class="href"><i class="fa fa-home"></i> Home</a> <i class="arrow_carrot-right"
                                                                                           style="font-size: 16px;"></i>
                            <a href="/faq" class="href">FAQs</a><i class="arrow_carrot-right"
                                                                   style="font-size: 16px;"></i>
                            <a href="/faq" class="href">{{$topic}}</a><i class="arrow_carrot-right"
                                                                         style="font-size: 16px;"></i><span>{{$question->slug}}</span>
                        </p>
                        <hr>
                        <div class="blog-detail-title">
                            <h2>{{$question->title}}</h2>
                            <p><i class="fa fa-tags"></i>
                                @foreach(explode(',',$question->tags) as $tag)
                                    <a href="/faq/tags/{{$tag}}" class="blogTags">{{$tag}}</a>
                                @endforeach
                                <span>- {{$question->created_at->formatLocalized('%d')}} {{$question->created_at->formatLocalized('%b')}},{{$question->created_at->formatLocalized('%Y')}}</span>
                            </p>
                        </div>
                        <div class="blog-detail-desc">
                            <p>
                                {!! $question->content !!}
                            </p>
                        </div>
                        <div class="tag-share">
                            <div class="details-tag">
                                <ul>
                                    <li><i class="fa fa-tags"></i></li>
                                    @foreach(explode(',',$question->tags) as $tag)
                                        <a href="/faq/tags/{{$tag}}">
                                            <li>{{$tag}}</li>
                                        </a>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="blog-share">
                                <span>Share:</span>
                                <div class="social-links">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-youtube-play"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="blog-post">
                            <div class="row">
                                @if($prevQuestion)
                                    <div class="col-lg-5 col-md-6">
                                        <a href="/faq/{{$prevQuestion->primeTitle->slug}}/{{$prevQuestion->slug}}" class="prev-blog">
                                            <div class="pb-pic">
                                                <i class="ti-arrow-left"></i>
                                            </div>
                                            <div class="pb-text">
                                                <span>Previous Question:</span>
                                                <h5>{{$prevQuestion->title}}</h5>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                                @if($nextQuestion)
                                    <div class="col-lg-5 {{$prevQuestion ? 'offset-lg-2' : 'offset-lg-7'}} col-md-6">
                                        <a href="/faq/{{$nextQuestion->primeTitle->slug}}/{{$nextQuestion->slug}}" class="next-blog">
                                            <div class="nb-pic">
                                                <i class="ti-arrow-right"></i>
                                            </div>
                                            <div class="nb-text">
                                                <span>Next Question:</span>
                                                <h5>{{$nextQuestion->title}}</h5>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr>


                        <div class="container">
                            <div id="comments" style="margin-bottom: 25px"></div>
                            @php($q = $question->faqComments()->latest()->paginate(5))
                            @foreach($q->where('primary_comment','0') as $comment)
                                <div class="card" style="margin-bottom: 25px">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="https://image.ibb.co/jw55Ex/def_face.jpg"
                                                     class="img img-rounded img-fluid"/>
                                                <p class="text-secondary text-center" style="font-size: 13px"><i
                                                        class="fa fa-clock-o"></i> {{$comment->created_at->diffForHumans()}}
                                                </p>

                                            </div>
                                            <div class="col-md-10">
                                                <p>
                                                <p><strong>
                                                        {{$comment->commentOwner->name}}
                                                    </strong></p>
                                                </p>
                                                <div class="clearfix"></div>
                                                <p>{{$comment->faq_content}}</p>
                                                <p>
                                                    <a class="float-right btn btn-outline-primary ml-2"
                                                       onclick='reply({{$comment->id}})'> <i
                                                            class="fa fa-reply"></i> Reply</a>
                                                </p>
                                            </div>
                                        </div>
                                        {{--Reply section--}}

                                        @foreach($comment->primaryComment->sortByDesc('id') as $reply)
                                            {{--                                            <div id="newReply" style="margin-bottom: 15px"></div>--}}
                                            <div id="{{$reply->primary_comment}}"
                                                 style="margin-bottom: 15px"></div>
                                            <div class="card card-inner">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <img src="https://image.ibb.co/jw55Ex/def_face.jpg"
                                                                 class="img img-rounded img-fluid"/>
                                                            <p class="text-secondary text-center"
                                                               style="font-size: 13px"><i
                                                                    class="fa fa-clock-o"></i> {{$reply->created_at->diffForHumans()}}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <p>
                                                            <p><strong>
                                                                    {{$reply->commentOwner->name}}
                                                                </strong></p>
                                                            </p>
                                                            <p>{{$reply->faq_content}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            {{$q->links()}}

                        </div>
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <div class="leave-comment">
                                <h4>Leave A Comment</h4>
                                <form method="post" class="comment-form">
                                    {{csrf_field()}}
                                    <div id="reply"></div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                                <textarea placeholder="Comment *" name="faq_content"
                                                          id="content"></textarea>
                                            <button type="submit" class="site-btn">Send message</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="leave-comment">
                                <div class="alert alert-info text-center">Please <a href="/login"
                                                                                    class="href"><b>Login</b></a> or <a
                                        href="/register" class="href"><b>Register</b></a> for comment
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->

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

    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    <style>
        .card-inner {
            margin-left: 4rem;
        }

        #content:focus {
            border: 2px solid #f39313;
        }

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

        .blogTags {
            color: #e7ab3c;
            transition: all .2s;
        }

        .blogTags:hover, .blogTags:focus {
            color: #e7ab3c;
            text-decoration: underline;
            transition: all .2s;
        }
    </style>
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>
    <script>
        function reply(id) {
            var hidden = '<input type="hidden"  value="' + id + '" name="primary_comment">';
            document.getElementById('reply').innerHTML = hidden;

            $('html,body').animate({
                scrollTop: $(".leave-comment").offset().top
            },
                'slow');
            $('#content').focus().css('border', '2px solid #f39313');


        }

        $(document).ready(function () {
            $('.comment-form').ajaxForm({
                success: function (response) {
                    Swal.fire(
                        response.processTitle,
                        response.processDesc,
                        response.processStatus
                        )
                        .then(function () {
                            var repliedComment = $('#reply input').val();

                            if ($('#reply input').attr('name') == 'primary_comment') {
                                $('html,body').animate({
                                    scrollTop: $('#' + repliedComment).offset().top
                                },
                                    'slow');
                            } else {
                                $('html,body').animate({
                                    scrollTop: $("#comments").offset().top
                                },
                                    'slow');
                            }
                        })
                    if (response.processStatus == 'success') {
                        var content = document.getElementById('content').value;
                        if ($('#reply input').attr('name') == 'primary_comment') {
                            var repliedComment = $('#reply input').val();
                            var comment = '<div class="card card-inner">' +
                                '<div class="card-body" style="border:1px solid #f39313!important">' +
                                '<div class="row">' +
                                '<div class="col-md-2">' +
                                '<img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid"/>' +
                                '<p class="text-secondary text-center" style="font-size: 13px"><i class="fa fa-clock-o"> </i> Just now</p>' +
                                '</div>' +
                                '<div class="col-md-10">' +
                                '<p>' +
                                '<p style="color:#f39313"><strong>You</strong></p>' +
                                '</p>' +
                                '<p>' + content + '</p>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                            document.getElementById(repliedComment).innerHTML = comment;

                        } else {
                            var comment = '<div class="card">' +
                                '<div class="card-body" style="border:1px solid #f39313!important">' +
                                '<div class="row">' +
                                '<div class="col-md-2">' +
                                '<img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid"/>' +
                                '<p class="text-secondary text-center" style="font-size: 13px"><i class="fa fa-clock-o"> </i> Just now</p>' +
                                '</div>' +
                                '<div class="col-md-10">' +
                                '<p>' +
                                '<p style="color:#f39313"><strong>You</strong></p>' +
                                '</p>' +
                                '<p>' + content + '</p>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                            document.getElementById('comments').innerHTML = comment;
                        }

                    }
                }
            })
        })
    </script>
@endsection
