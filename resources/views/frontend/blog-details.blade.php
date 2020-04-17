@extends('frontend.app')
@section('icerik')
    <title>Fashi | Blog details</title>
    <!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-details-inner">
                        <p><a href="/">Home</a>/<a href="/blog">Blog</a>/{{implode('/',$blogCategory)}}</p>
                        <div class="blog-detail-title">
                            <h2>{{$blogs->title}}</h2>
                            <p>{{$blogs->tags}} <span>- {{$blogs->created_at->toDateString()}}</span></p>
                        </div>
                        <div class="blog-large-pic">
                            @foreach($photos = Storage::disk('uploads')->files('img/blog/'.$blogs->slug) as $photo)
                            @endforeach
                            <img src="/uploads/{{$photo}}" alt="">
                        </div>
                        <div class="blog-detail-desc">
                            <p>
                                {!! $blogs->description !!}
                            </p>
                        </div>

                        @if($blogs->short_content)
                            <div class="blog-quote">
                                <p>{{$blogs->short_content}}</p>
                            </div>
                        @endif


                        <div class="blog-more">
                            <div class="row">
                                @foreach($photos = Storage::disk('uploads')->files('img/blog/'.$blogs->slug) as $photo)
                                    <div class="col-sm-4">
                                        <img src="/uploads/{{$photo}}" alt="{{$blogs->title}}" height="200">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tag-share">
                            <div class="details-tag">
                                <ul>
                                    <li><i class="fa fa-tags"></i></li>
                                    @foreach (explode(',', $blogs->tags) as $tags)
                                        <a href="#">
                                            <li>{{trim($tags)}}</li>
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
                                <div class="col-lg-5 col-md-6">
                                    <a href="#" class="prev-blog">
                                        <div class="pb-pic">
                                            <i class="ti-arrow-left"></i>
                                            <img src="/frontend/img/blog/prev-blog.png" alt="">
                                        </div>
                                        <div class="pb-text">
                                            <span>Previous Post:</span>
                                            <h5>The Personality Trait That Makes People Happier</h5>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-5 offset-lg-2 col-md-6">
                                    <a href="#" class="next-blog">
                                        <div class="nb-pic">
                                            <img src="/frontend/img/blog/next-blog.png" alt="">
                                            <i class="ti-arrow-right"></i>
                                        </div>
                                        <div class="nb-text">
                                            <span>Next Post:</span>
                                            <h5>The Personality Trait That Makes People Happier</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="container">
                            @foreach($blogs->comments->where('prime_comment','0') as $comment)
                                <div id="comments" style="margin-bottom: 25px"></div>
                                <div class="card" style="margin-bottom: 25px">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="https://image.ibb.co/jw55Ex/def_face.jpg"
                                                     class="img img-rounded img-fluid"/>
                                                <p class="text-secondary text-center" style="font-size: 13px"><i
                                                        class="fa fa-clock-o"></i> {{$comment->created_at}}</p>

                                            </div>
                                            <div class="col-md-10">
                                                <p>
                                                <p><strong>
                                                        @if($comment->user_id>'0')
                                                            {{$comment->user->name}}
                                                        @else
                                                            {{$comment->name}}
                                                        @endif
                                                    </strong></p>
                                                </p>
                                                <div class="clearfix"></div>
                                                <p>{{$comment->content}}</p>
                                                <p>
                                                    <a class="float-right btn btn-outline-primary ml-2"
                                                       onclick='reply({{$comment->id}})'> <i
                                                            class="fa fa-reply"></i> Reply</a>
                                                </p>
                                            </div>
                                        </div>
                                        {{--Reply section--}}

                                        @foreach($comment->child->sortBy('id') as $reply)
                                            {{--                                            <div id="newReply" style="margin-bottom: 15px"></div>--}}
                                            <div id="{{$reply->prime_comment}}" style="margin-bottom: 15px"></div>
                                            <div class="card card-inner">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <img src="https://image.ibb.co/jw55Ex/def_face.jpg"
                                                                 class="img img-rounded img-fluid"/>
                                                            <p class="text-secondary text-center"
                                                               style="font-size: 13px"><i
                                                                    class="fa fa-clock-o"></i> {{$reply->created_at}}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <p>
                                                            <p><strong>
                                                                    @if($reply->user_id>'0')
                                                                        {{$reply->user->name}}
                                                                    @else
                                                                        {{$reply->name}}
                                                                    @endif
                                                                </strong></p>
                                                            </p>
                                                            <p>{{$reply->content}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="leave-comment">
                            <h4>Leave A Comment</h4>
                            <form method="post" class="comment-form">
                                {{csrf_field()}}
                                <div id="reply"></div>
                                <div class="row">
                                    @if(!\Illuminate\Support\Facades\Auth::check())
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="Name *" name="name" id="name">
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="Email *" name="email" id="email">
                                        </div>
                                    @endif
                                    <div class="col-lg-12">
                                        <textarea placeholder="Comment *" name="content" id="content"></textarea>
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
    </style>
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>
    <script>
        function reply(id) {
            var hidden = '<input type="hidden"  value="' + id + '" name="prime_comment">';
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
                    // .then(function () {
                    //     $('html,body').animate({
                    //         scrollTop: $("#comments").offset().top
                    //     },
                    //         'slow');
                    // })
                    if (response.processStatus == 'success') {
                        var content = document.getElementById('content').value;
                        if ($('#reply input').attr('name') == 'prime_comment') {
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
        return;
        })
    </script>
@endsection
