@extends('frontend.app')
@section('icerik')
    <title>Fashi | FAQs</title>

    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <a href="/faq"> FAQs</a>
                        <span>
                                {{ucfirst($author->name)}}'s question{{count($questions)>1 ? 's' : ''}} ({{count($questions)}})
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Faq Section Begin -->
    <div class="faq-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="faq-accordin">
                        <div class="accordion" id="accordionExample">
                            @foreach($questions as $question)
                                <div class="card text-center">
                                    <div class="card-header text-left h3">
                                        <a href="/faq/{{$question->primeTitle->slug}}/{{$question->slug}}">{{$question->title}}</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-1 dateContainer">
                                                <div class="date">
                                                    <div
                                                        class="day">{{$question->created_at->formatLocalized('%d')}}</div>
                                                    <div
                                                        class="month">{{$question->created_at->formatLocalized('%b')}}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-11 text-left"
                                                 style="padding:20px 20px 20px 20px ">
                                                {{$question->content}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div
                                            class="col-sm-12  col-md-5 offset-md-7 col-lg-5 offset-lg-7  footerContainer">
                                            <div class="footerItems"><i class="ti-user "></i>
                                                <a href="/faq/author/{{$question->user->slug}}-{{$question->user->id}}"
                                                   class="specialLink"> {{$question->user->name}}</a></div>
                                            <div class="footerItems"><i class="fa fa-tags "></i>

                                                @php($e=$question->tags)
                                                @php($tags = explode(',',$e))
                                                @foreach($tags as $tag)
                                                    <a href="/faq/tags/{{\Illuminate\Support\Str::Slug($tag)}}"
                                                       class="specialLink">{{$tag}}</a>
                                                @endforeach
                                            </div>
                                            <div class="footerItems">
                                                <i class="ti-comments "></i> 12 Comments
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Faq Section End -->

    <!-- Partner Logo Section Begin -->
    <div class="partner-logo">
        <div class="container">
            <div class="logo-carousel owl-carousel">
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="img/logo-carousel/logo-1.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="img/logo-carousel/logo-2.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="img/logo-carousel/logo-3.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="img/logo-carousel/logo-4.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="img/logo-carousel/logo-5.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Partner Logo Section End -->

@endsection

@section('css')
    <style>
        #collapseOne, #collapseTwo, #collapseThree {
            border: 1px solid #eee;
        }

        .footerContainer {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .footerItems, .footerItems i {
            color: #e7ab3c;
            font-weight: bold;
        }

        .specialLink {
            color: #e7ab3c;
            transition: all 0.2s;
        }

        .specialLink:hover, .specialLink:focus {
            color: #e7ab3c;
            transition: all 0.2s;
            text-decoration: underline;
        }

        .dateContainer {
            display: flex;
            align-items: center;
        }

        .date {
            width: 50px;
            height: auto;
            margin: auto auto;
        }

        .day {
            background: #fff;
            width: 100%;
            height: 50px;
            text-align: center;
            line-height: 50px;
            margin-bottom: 3px;
            font-size: 30px;
            color: #e7ab3c;
        }

        .month {
            background: #e7ab3c;
            width: 100%;
            height: 30px;
            text-align: center;
            line-height: 30px;
            color: #fff;
        }
        .card-header a {
            color: #2c2525;
            transition: all .1s;

        }

        .card-header a:hover, .card-header a:focus {
            color: #e7ab3c;
            transition: all .1s;
            text-decoration: underline;
        }
    </style>
@endsection

@section('js')
@endsection
