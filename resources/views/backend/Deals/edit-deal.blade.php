@extends('backend.app')
@section('icerik')


    <title>Admin Panel | Edit Deal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title">
                    <h3 style="float:left;">Edit deal</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">

                            <form method="post" id="editBannerForm" enctype="multipart/form-data"
                                  class="form-horizontal form-label-left">
                                @csrf
                                <div class="form-group">
                                    <label for="title"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">
                                        @if($deals->enable_disable == 1)
                                            Disable banner
                                        @else
                                            Enable banner
                                        @endif
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="checkbox" data-toggle="toggle" id="switcher"
                                               @if($deals->enable_disable == 1)
                                               checked
                                               @endif onchange="sw()">
                                    </div>
                                </div>

                                <hr>

                                @if($deals->enable_disable == 1)

                                    @if(isset($deals->banner))
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Current banner
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12"
                                                 style="border:2px solid #ddd;display: flex;justify-content: center;align-items: center;overflow: auto;height: 330px">
                                                <img src="/uploads/img/DealsBanner/{{$deals->banner}}" >
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="dealBanner"
                                               class="control-label col-md-3 col-sm-3 col-xs-12">Change banner *
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="file" id="dealBanner" name="dealBanner"
                                                   class="form-control col-md-6 col-sm-6 col-xs-12">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="title"
                                               class="control-label col-md-3 col-sm-3 col-xs-12">Title *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="title"
                                                   class="form-control col-md-6 col-sm-6 col-xs-12" name="title"
                                                   @if($deals)
                                                   value="{{$deals->title}}"
                                                   @else
                                                   placeholder="Not data yet"
                                                @endif >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="desc"
                                               class="control-label col-md-3 col-sm-3 col-xs-12">Description *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="desc"
                                                   class="form-control col-md-6 col-sm-6 col-xs-12" name="desc"
                                                   @if($deals)
                                                   value="{{$deals->desc}}"
                                                   @else
                                                   placeholder="Not data yet"
                                                @endif>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="price"
                                               class="control-label col-md-3 col-sm-3 col-xs-12">Price *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" name="price" id="price" min="0" step = '0.01'
                                                   class="form-control col-md-6 col-sm-6 col-xs-12"
                                                   @if($deals)
                                                   value="{{$deals->price}}"
                                                   @else
                                                   placeholder="Not data yet"
                                                @endif required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="pr_name"
                                               class="control-label col-md-3 col-sm-3 col-xs-12">Product Name *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="pr_name" id="pr_name"
                                                   class="form-control col-md-6 col-sm-6 col-xs-12"
                                                   @if($deals)
                                                   value="{{$deals->pr_name}}"
                                                   @else
                                                   placeholder="Not data yet"
                                                @endif>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="durationDay"
                                               class="control-label col-md-3 col-sm-3 col-xs-12">Duration *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="date" name="durationDate" id="durationDate" min="{{date('Y-m-d')}}"
                                                   class="form-control"  value="{{$deals->date}}">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="link"
                                               class="control-label col-md-3 col-sm-3 col-xs-12">Link *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="link" id="link"
                                                   class="form-control col-md-6 col-sm-6 col-xs-12"
                                                   @if($deals)
                                                   value="{{$deals->link}}"
                                                   @else
                                                   placeholder="http://127.0.0.1:8000/shop/..."
                                                @endif>
                                        </div>
                                    </div>


                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button type="submit" class="btn btn-primary">Update deal
                                            </button>
                                        </div>
                                    </div>
                                @endif
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

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('js')
    {{--Sweet Alert--}}
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#editBannerForm').ajaxForm({
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
                        location.reload();
                    })
                }
            })
        })

    </script>

    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


    <script !src="">
        function sw() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            if ($('#switcher').prop('checked') == true) {
                $.ajax({
                    type: 'POST',
                    url: '{{route('switchDeal')}}',
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
                    url: '{{route('switchDeal')}}',
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
    </script>
@endsection
