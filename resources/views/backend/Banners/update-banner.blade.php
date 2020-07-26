@extends('backend.app')
@section('icerik')


    <title>Admin Panel | Update Banner</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title">
                    <h3 style="float:left;">Update Banner</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">

                            <form method="post" id="updateBannerForm" enctype="multipart/form-data"
                                  class="form-horizontal form-label-left">
                                @csrf

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Current banner
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12"
                                         style="border:2px solid #ddd;display: flex;justify-content: center;align-items: center;overflow: auto;height: 330px">
                                        <img src="/uploads/img/Banners/{{$banner->image}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bannerImage"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Update image
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" id="bannerImage" name="img"
                                               class="form-control col-md-6 col-sm-6 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="bannerTitle"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Title *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="bannerTitle"
                                               class="form-control col-md-6 col-sm-6 col-xs-12" name="title"
                                               value="{{$banner->title}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="bannerLink"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Link *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="link" id="bannerLink"
                                               class="form-control col-md-6 col-sm-6 col-xs-12"
                                               value="{{$banner->link}}">
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
            $('#updateBannerForm').ajaxForm({
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
                        location.href = '{{route('getBanners')}}';
                    })
                }
            })
        })

    </script>

@endsection
