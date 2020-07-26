@extends('frontend.app')
@section('icerik')
    <title>Fashi | Blog</title>

    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Blog Section Begin -->
    <section class="blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1">
                    @include('frontend.blog-side-bar')
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="row">
                        @foreach($blogs as $blog)
                            <div class="col-lg-6 col-sm-6">
                                <div class="blog-item">
                                    @foreach($photos = Storage::disk('uploads')->files('img/blog/'.$blog->slug) as $photo)
                                    @endforeach
                                    <div class="bi-pic">
                                        <img src="/uploads/{{$photo}}" alt="" width="100" height="150">
                                    </div>

                                    <div class="bi-text">
                                        <a href="/blog/@if(isset($blog->parent))@php($primaryCategory=$blog->parent)@if(isset($primaryCategory->parent))@php($doubleprimaryCategory= $primaryCategory->parent)@if(isset($doubleprimaryCategory->parent)){{$doubleprimaryCategory->parent->slug}}/@endif{{$primaryCategory->parent->slug}}/@endif{{$blog->parent->slug}}/@endif{{$blog->slug}}">
                                            <h4>{{$blog->title}}</h4>
                                        </a>
                                        <p>
                                            <i class="ti-user"></i> - <a
                                                href="{{route('blogAuthorName',['authorName'=>$authorName=$blog->user->slug.'-'.$blog->user->id])}}"
                                                class="href">{{$blog->user->name}}</a>&nbsp;
                                            <i class="ti-comments"></i> - {{$blog->comments->count()}}
                                            <span class="pull-right"><i
                                                    class="fa fa-clock-o"></i> {{$blog->created_at->formatLocalized('%d')}} {{$blog->created_at->formatLocalized('%b')}},{{$blog->created_at->formatLocalized('%Y')}}</span>

                                            <br>
                                            <i class="fa fa-tags"></i>
                                            @foreach(explode(',',$blog->tags) as $tag)
                                                <a href="/blog/tags/{{$tag}}" class="href">{{$tag}}</a>
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-lg-12">
{{--                            {{$blogs->links('vendor.pagination.bootstrap-4')}}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

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
        .href {
            color: #e7ab3c;
            transition: all 0.2s;
        }

        .href:hover, .href:focus {
            text-decoration: underline;
            color: #e7ab3c;
            transition: all 0.2s;
        }
    </style>

@endsection

@section('js')
@endsection
