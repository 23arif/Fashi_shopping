@extends('backend.app')
@section('icerik')


    <title>Admin Panel | Slider page</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title">
                    <h3 style="float:left;">Edit Slider &nbsp; </h3>

                </div>

            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <label for="title"
                                   class="control-label col-md-1 col-sm-2 col-xs-4">
                                @if($sliderSwitch== 1)
                                    Disable banner
                                @else
                                    Enable banner
                                @endif
                            </label>
                            <input type="checkbox" data-toggle="toggle" id="switcher"
                                   @if($sliderSwitch == 1)
                                   checked
                                   @endif onchange="sw()">
                            @if($sliderSwitch == 1)
                                <div class="form-group nav navbar-right ">
                                    <a href="{{route('addSlider')}}" class="btn btn-primary col-xs-12"> + Add new
                                        slide</a>
                                </div>
                            @endif
                            <div class="clearfix"></div>
                        </div>


                        <div class="x_content">
                            @if($sliderSwitch == 1)
                                @if(count($sliders) == 0)
                                    <div class="alert alert-info text-center">There is not slide yet .</div>
                                @else
                                    @foreach($sliders as $slider)
                                        <div class="col-md-55">
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                    <img style="width: 100%; display: block;"
                                                         src="/uploads/img/Slider/{{$slider->image}}"
                                                         alt="{{$slider->title}}"/>
                                                    <div class="mask no-caption">
                                                        <div class="tools tools-bottom">
                                                            <a href="{{route('editSlider',['sliderSlug'=>$slider->slug])}}"><i
                                                                    class="fa fa-pencil"></i></a>
                                                            <a href="javascript: void(0)"
                                                               onclick="dltSlide('{{$slider->slug}}')"><i
                                                                    class="fa fa-times"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="caption">
                                                    <p><strong>{{$slider->title}}</strong>
                                                    </p>
                                                    <p>{{\Illuminate\Support\Str::limit($slider->description,20,$end='...')}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @else
                                <div class="alert alert-info text-center">Sliders are disabled !</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    {{--Sweet Alert--}}
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    <link rel="stylesheet" href="/css/projectCustom.css">
    {{--/Sweet Alert--}}
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <style>
        .view-first img{
            height: 100%;
        }
    </style>
@endsection

@section('js')
    {{--Sweet Alert--}}
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


    <script !src="">
        function sw() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            if ($('#switcher').prop('checked') == true) {
                $.ajax({
                    type: 'POST',
                    url: '{{route('slider_switcher_and_dlt')}}',
                    data: {
                        'switchResult': 1,
                        '_token': CSRF_TOKEN
                    }, success: function (response) {
                        if (response.processStatus == "success") {
                            location.reload();
                        }
                    }
                })
            } else {
                $.ajax({
                    type: 'POST',
                    url: '{{route('slider_switcher_and_dlt')}}',
                    data: {
                        'switchResult': 0,
                        '_token': CSRF_TOKEN
                    }, success: function (response) {
                        if (response.processStatus == "success") {
                            location.reload();
                        }
                    }
                })
            }
        }

        function dltSlide(slug) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: '{{route('slider_switcher_and_dlt')}}',
                        data: {
                            'slug': slug,
                            '_token': CSRF_TOKEN
                        },
                        beforeSubmit: function () {
                            Swal.fire({
                                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                                text: 'Loading please wait!',
                                showConfirmButton: false
                            })
                        }, success: function (response) {
                            if (response.processStatus == "success") {
                                location.reload();
                            }
                        }
                    })


                }
            })


        }
    </script>
@endsection
