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
{{--                                @if(isset($blog->parent))--}}
{{--                                    {{$blog->parent->name}}--}}
{{--                                    @php($primaryCategory=$blog->parent);--}}
{{--                                    @if(isset($primaryCategory->parent))--}}
{{--                                        {{$primaryCategory->parent->name}}--}}
{{--                                        @php($doubleprimaryCategory= $blog->parent);--}}
{{--                                        @if(isset($doubleprimaryCategory->parent))--}}
{{--                                            {{$doubleprimaryCategory->parent->name}}--}}
{{--                                        @endif--}}
{{--                                    @endif--}}
{{--                                @endif--}}
                                {!!$blogs->description!!}
                            </p>
                        </div>
                        {{--                        <div class="blog-quote">--}}
                        {{--                            <p>{{$short_content}}</p>--}}
                        {{--                        </div>--}}

                        @if($blogs->short_content)
                            <div class="blog-quote">
                                <p>{{$blogs->short_content}}</p>
                            </div>
                        @endif


                        <div class="blog-more">
                            <div class="row">
                                @foreach($photos = Storage::disk('uploads')->files('img/blog/'.$blogs->slug) as $photo)
                                    <div class="col-sm-4">
                                        <img src="/uploads/{{$photo}}" alt="{{$blogs->title}}" height="203" width="358">
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
                        <div class="posted-by">
                            <div class="pb-pic">
                                <img src="/frontend/img/blog/post-by.png" alt="">
                            </div>
                            <div class="pb-text">
                                <a href="#">
                                    <h5>Shane Lynch</h5>
                                </a>
                                <p>Aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                                    velit esse cillum bore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    amodo</p>
                            </div>
                        </div>
                        <div class="leave-comment">
                            <h4>Leave A Comment</h4>
                            <form action="#" class="comment-form">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input type="text" placeholder="Name">
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" placeholder="Email">
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea placeholder="Messages"></textarea>
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
@endsection

@section('js')
@endsection
