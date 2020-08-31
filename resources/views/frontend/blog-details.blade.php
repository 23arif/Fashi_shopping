@extends('frontend.app')
@section('icerik')
    <title>Fashi | Blog details</title>
    <!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-details-inner">
                        <p><a href="/" class="href"><i class="fa fa-home"></i> Home</a> <i class="arrow_carrot-right"
                                                                                           style="font-size: 16px;"></i>
                            <a href="/blog" class="href">Blog</a> <i class="arrow_carrot-right"
                                                                     style="font-size: 16px;"></i>

                            @for($i= 0;$i<count($blogCategory)-1;$i++)
                                <a href="/blog/@for($k= 0;$k<=$i;$k++){{$blogCategory[$k]}}/@endfor"
                                   class="href">{{$blogCategory[$i]}}</a>
                                <i class="arrow_carrot-right"
                                   style="font-size: 16px;"></i>
                            @endfor
                            <a style="font-size: 16px">{{$blogs->slug}}</a>

                        </p>
                        <hr>
                        <div class="blog-detail-title">
                            <h2>{{$blogs->title}}</h2>
                            <p><i class="fa fa-tags"></i>
                                @foreach($blogs->blogTags as $tag)
                                    <a href="/blog/tags/{{$tag->slug}}" class="blogTags">{{$tag->tag}}</a>
                                @endforeach
                                <span>- {{$blogs->created_at->formatLocalized('%d')}} {{$blogs->created_at->formatLocalized('%b')}},{{$blogs->created_at->formatLocalized('%Y')}}</span>
                            </p>
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
                                    @foreach($blogs->blogTags as $tag)
                                        <a href="/blog/tags/{{$tag->slug}}">
                                            <li>{{$tag->tag}}</li>
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
                                @if($prevBlog)
                                    @foreach($photos = Storage::disk('uploads')->files('img/blog/'.$prevBlog->slug) as $photo)
                                    @endforeach
                                    <div class="col-lg-5 col-md-6">
                                        <a href="/blog/@if(isset($prevBlog->parent))@php($primaryCategory=$prevBlog->parent)@if(isset($primaryCategory->parent))@php($doubleprimaryCategory= $primaryCategory->parent)@if(isset($doubleprimaryCategory->parent)){{$doubleprimaryCategory->parent->slug}}/@endif{{$primaryCategory->parent->slug}}/@endif{{$prevBlog->parent->slug}}/@endif{{$prevBlog->slug}}"
                                           class="prev-blog">
                                            <div class="pb-pic">
                                                <i class="ti-arrow-left"></i>
                                                <img src="/uploads/{{$photo}}" alt="{{$prevBlog->title}}">
                                            </div>
                                            <div class="pb-text">
                                                <span>Previous Blog:</span>
                                                <h5>{{$prevBlog->title}}</h5>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                                @if($nextBlog)
                                    @foreach($photos = Storage::disk('uploads')->files('img/blog/'.$nextBlog->slug) as $photo)
                                    @endforeach
                                    <div class="col-lg-5 {{$prevBlog ? 'offset-lg-2' : 'offset-lg-7'}} col-md-6">
                                        <a href="/blog/@if(isset($nextBlog->parent))@php($primaryCategory=$nextBlog->parent)@if(isset($primaryCategory->parent))@php($doubleprimaryCategory= $primaryCategory->parent)@if(isset($doubleprimaryCategory->parent)){{$doubleprimaryCategory->parent->slug}}/@endif{{$primaryCategory->parent->slug}}/@endif{{$nextBlog->parent->slug}}/@endif{{$nextBlog->slug}}"
                                           class="next-blog">
                                            <div class="nb-pic">
                                                <img src="/uploads/{{$photo}}" alt="{{$nextBlog->title}}">
                                                <i class="ti-arrow-right"></i>
                                            </div>
                                            <div class="nb-text">
                                                <span>Next Blog:</span>
                                                <h5>{{$nextBlog->title}}</h5>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if($prevBlog || $nextBlog)
                            <hr>
                        @endif

                        <div class="container">
                            <div id="comments" style="margin-bottom: 25px"></div>
                            @php($comments = $blogs->comments()->latest()->paginate(10))
                            @foreach($comments->where('prime_comment','0') as $comment)
                                <div class="card" style="margin-bottom: 25px;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2 imgAndTime">
                                                <img
                                                    src="/uploads/img/profileImages/{{$comment->user->profile_image ? $comment->user->slug."/".$comment->user->profile_image : "default.png" }}"
                                                    class="roundImg"/>
                                                <p class="text-secondary text-center" style="font-size: 13px"><i
                                                        class="fa fa-clock-o"></i> {{$comment->created_at->diffForHumans()}}
                                                </p>

                                            </div>
                                            <div class="col-md-10">
                                                <p><strong>
                                                        @if($comment->user_id>'0')
                                                            {{$comment->user->name}}
                                                        @else
                                                            {{$comment->name}}
                                                        @endif
                                                    </strong></p>
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
                                            <div id="{{$reply->prime_comment}}"
                                                 style="margin-bottom: 15px"></div>
                                            <div class="card card-inner">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-2 imgAndTime">
                                                            <img
                                                                src="/uploads/img/profileImages/{{$reply->user->profile_image ? $reply->user->slug."/".$reply->user->profile_image : "default.png" }}"
                                                                class="roundImg"/>
                                                            <p class="text-secondary text-center"
                                                               style="font-size: 13px"><i
                                                                    class="fa fa-clock-o"></i> {{$reply->created_at->diffForHumans()}}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <p>
                                                                <strong>
                                                                    @if($reply->user_id>'0')
                                                                        {{$reply->user->name}}
                                                                    @else
                                                                        {{$reply->name}}
                                                                    @endif
                                                                </strong>
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
                            {{$comments->links()}}
                        </div>

                        @if(\Illuminate\Support\Facades\Auth::check())
                            <div class="leave-comment">
                                <h4>Leave A Comment</h4>
                                <form method="post" class="comment-form">
                                    {{csrf_field()}}
                                    <div id="reply"></div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                                <textarea placeholder="Comment *" name="content"
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

        .roundImg {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .imgAndTime {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
                        .then(function () {
                            var repliedComment = $('#reply input').val();

                            if ($('#reply input').attr('name') == 'prime_comment') {
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
                        if ($('#reply input').attr('name') == 'prime_comment') {
                            var repliedComment = $('#reply input').val();
                            var comment = '<div class="card card-inner">' +
                                '<div class="card-body" style="border:1px solid #f39313!important">' +
                                '<div class="row">' +
                                '<div class="col-md-2 imgAndTime">' +
                                '<img src="/uploads/img/profileImages/default.png" class="roundImg"/>' +
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
                                '<div class="col-md-2 imgAndTime">' +
                                '<img src="/uploads/img/profileImages/default.png" class="roundImg"/>' +
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
