@extends('frontend.app')
@section('icerik')
    <title>Fashi | FAQs</title>

    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 row">
                    <div class="breadcrumb-text col-md-7 col-sm-7 col-7">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                        <span>FAQs</span>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->status()>0)
                        <div class="col-md-5 col-sm-5 col-5  btn-faq-container">
                            <div class="pull-right btn btn-faq"><a href="/faq/add-faq"><b>+ Add new FAQ</b></a></div>
                        </div>
                    @endif
                </div>
            </div>
            <hr>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Faq Section Begin -->
    <div class="container" style="display: flex;justify-content: center;padding-top: 10px">
        <h4 style="font-weight: bold"><span style="color:#e7ab3c;">{{count($prime_titles)}}</span>
            Topic{{count($prime_titles)>1 ? 's' : ''}} and
            <span style="color:#e7ab3c;">
                @php($showCounter =\App\FaqTopic::where('show_hide','1')->count())
                @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->status()>'0')
                    {{count($faqTopics)}}
                @else
                    {{$showCounter}}
                @endif
            </span>
            question{{count($faqTopics)>1 ? 's': ' ' }}</h4>
    </div>
    <div class="faq-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="faq-accordin">
                        <div class="accordion" id="accordionExample">
                            @foreach($prime_titles as $prime_title)
                                <div class="card">
                                    <div class="card-heading ">
                                        <a data-toggle="collapse"
                                           data-target="#{{$prime_title->slug}}">{{$prime_title->name}}</a>
                                    </div>
                                    {{---------------------}}
                                    <div id="{{$prime_title->slug}}"
                                         class="collapse" data-parent="#accordionExample">
                                        @foreach($faqTopics->where('prime_title',$prime_title->id) as $faqTopic)
                                            @if(($faqTopic->show_hide == '1')  || (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->status()>'0'))

                                                <div class="card text-center" style="border:1px solid #eee">
                                                    <div class="card-header text-left h3">
                                                        <a @if($faqTopic->show_hide=='1')
                                                           href="/faq/{{$faqTopic->primeTitle->slug}}/{{$faqTopic->slug}}"
                                                           @endif
                                                           @if($faqTopic->show_hide == '0') class="unPoint" @endif>{{$faqTopic->title}}</a>
                                                        @if($faqTopic->show_hide == '0')
                                                            <span
                                                                class="pull-right"><h6><u>Disabled question</u></h6></span>
                                                        @endif
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-1 dateContainer">
                                                                <div class="date">
                                                                    <div
                                                                        class="day">{{$faqTopic->created_at->formatLocalized('%d')}}</div>
                                                                    <div
                                                                        class="month">{{$faqTopic->created_at->formatLocalized('%b')}}</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-11 text-left"
                                                                 style="padding:20px 20px 20px 20px ">
                                                                {{--{{ strip_tags(\Illuminate\Support\Str::limit($faqTopic->content,200,$end='...')) }}--}}
                                                                @php($text = strip_tags($faqTopic->content))
                                                                {{\Illuminate\Support\Str::limit($text,200,$end='...')}}

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div
                                                            class="col-sm-12  col-md-6 offset-md-6 col-lg-5 offset-lg-7  footerContainer">
                                                            <div class="footerItems"><i class="ti-user "></i>
                                                                <a href="/faq/author/{{$faqTopic->user->slug}}-{{$faqTopic->user->id}}"
                                                                   class="specialLink"> {{$faqTopic->user->name}}</a>
                                                            </div>
                                                            <div class="footerItems"><i class="fa fa-tags "></i>

                                                                @php($e=$faqTopic->tags)
                                                                @php($tags = explode(',',$e))
                                                                @foreach($tags as $tag)
                                                                    <a href="/faq/tags/{{\Illuminate\Support\Str::Slug($tag)}}"
                                                                       class="specialLink">{{$tag}}</a>
                                                                @endforeach
                                                            </div>
                                                            <div class="footerItems"><i class="ti-comments "></i>
                                                                {{count($faqTopic->faqComments)}} Comments
                                                            </div>
                                                            @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->status()>0)
                                                                <div class="footerItems"><i class="ti-trash "></i>
                                                                    <a href="#" class="specialLink"
                                                                       onclick="deleteQuestion('delete','{{$faqTopic->id}}')">Delete</a>

                                                                </div>
                                                                <div class="footerItems">
                                                                    @if($faqTopic->show_hide == '1')
                                                                        <i class="fa fa-eye-slash"></i>
                                                                        <a href="#" class="specialLink"
                                                                           onclick="deleteQuestion('hide','{{$faqTopic->id}}')">
                                                                            Hide
                                                                        </a>
                                                                    @else
                                                                        <i class="ti-eye "></i>
                                                                        <a href="#" class="specialLink"
                                                                           onclick="deleteQuestion('show','{{$faqTopic->id}}')">
                                                                            Show
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif
                                        @endforeach
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

        .btn-faq-container {
            display: flex;
            align-items: center;
            justify-content: flex-end
        }

        .btn-faq {
            background: #e7ab3c;
            cursor: auto !important;
        }

        .btn-faq a {
            color: #fff;
            transition: all .2s;
        }

        .btn-faq a:hover {
            color: #000;
            transition: all .2s;
        }

        .unPoint {
            cursor: not-allowed;
        }
    </style>

    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->status()>0)
        <script src="/js/jquery.form.min.js"></script>
        <script src="/js/sweetalert2.min.js"></script>

        <script>
            function deleteQuestion(status, id) {
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Yes !'
                }).then(function (result) {
                    if (result.value) {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            type: "POST",
                            url: '/faq/delete-faq',
                            data: {
                                'id': id,
                                'status': status,
                                '_token': CSRF_TOKEN
                            },
                            beforeSubmit: function () {
                                Swal.fire({
                                    title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                                    text: 'Loading please wait!',
                                    showConfirmButton: false
                                })
                            },
                            success: function (response) {
                                Swal.fire(
                                    response.processTitle,
                                    response.processDesc,
                                    response.processStatus
                                    ).then(() => {
                                    if (response.processStatus == "success") {
                                        location.reload();
                                    }
                                })
                            }
                        })
                    }
                })
            }

        </script>
    @endif
@endsection
