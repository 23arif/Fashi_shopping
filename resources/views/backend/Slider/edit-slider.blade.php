@extends('backend.app')
@section('icerik')


    <title>Admin Panel | Edit Slider</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title">
                    <h3 style="float:left;">Edit Slider</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">

                            <form method="post" id="updateSlideForm" enctype="multipart/form-data"
                                  class="form-horizontal form-label-left">
                                @csrf

                                <div class="form-group">
                                    <label for="dealBanner"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Current banner
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12"
                                         style="border:2px solid #ddd;display: flex;justify-content: center;align-items: center;overflow: auto;height: 330px">
                                        <img src="/uploads/img/Slider/{{$slider->image}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sliderImage"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Update image
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" id="sliderImage" name="img"
                                               class="form-control col-md-6 col-sm-6 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="title"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Title *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="title"
                                               class="form-control col-md-6 col-sm-6 col-xs-12" name="title" value="{{$slider->title}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="desc"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Description *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="desc"
                                               class="form-control col-md-6 col-sm-6 col-xs-12" name="description" value="{{$slider->description}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sale"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Sale </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="number" name="sale" id="sale"
                                               class="form-control col-md-6 col-sm-6 col-xs-12" value="{{$slider->sale}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="link"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Link *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="link" id="link"
                                               class="form-control col-md-6 col-sm-6 col-xs-12" value="{{$slider->link}}">
                                    </div>
                                </div>


                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">Update
                                        </button>
                                    </div>
                                </div>
                            </form>

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
@endsection

@section('js')
    {{--Sweet Alert--}}
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#updateSlideForm').ajaxForm({
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
                        if(response.processStatus == 'success'){
                            location.href = '{{route("sliderPage")}}';
                        }
                    })
                }
            })
        })

    </script>



@endsection
