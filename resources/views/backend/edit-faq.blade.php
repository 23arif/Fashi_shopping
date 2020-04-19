@extends('backend.app')
@section('icerik')
    <title>Admin Panel | Edit Blog</title>

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title">
                    <a href="/admin/faq"><h3 class="fa fa-arrow-circle-left"
                                              style="font-size: 25px;float: left;margin-right:10px"></h3></a>
                    <h3 style="float:left;">Edit &nbsp;<u><b>{{$topic->name}}</b></u>&nbsp; FAQs topic.</h3>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <form method="post" id="faqForm" data-parsley-validate
                                  class="form-horizontal form-label-left">
                                {{csrf_field()}}

                                {{Form::bsText('name','Title *',$topic->name)}}

                                <div class="form-group">
                                    <label for="shortContent"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Short Content</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="shortContent"
                                               class="form-control col-md-6 col-sm-6 col-xs-12" name="short_content"
                                               value="{{$topic->short_content}}">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-success">Update
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
    <script src="/js/sweetalert2.min.js"></script>
    <script src="/js/jquery.form.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#faqForm').ajaxForm({
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
                            location.href = '/admin/faq';
                        }
                    })

                }
            })
        })

    </script>

@endsection
