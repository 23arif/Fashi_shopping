@extends('backend.app')
@section('icerik')
    <title>Admin Panel | FAQs</title>

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>FAQs</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">

                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#list" id="list-tab"
                                                                          role="tab" data-toggle="tab"
                                                                          aria-expanded="true">FAQs</a>
                                </li>
                                <li role="presentation" class=""><a href="#add" role="tab" id="add-tab"
                                                                    data-toggle="tab"
                                                                    aria-expanded="false">Add FAQ Title</a>
                                </li>
                            </ul>

                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="list"
                                     aria-labelledby="list-tab">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_content">

                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php($i=1)
                                                    @foreach($faqs as $faq)
                                                        <tr>
                                                            <th scope="row">{{$i++}}</th>
                                                            <td>{{$faq->name}}</td>
                                                            <td>{{$faq->short_content}}</td>
                                                            <td><a href="faq/edit-faq/{{$faq->slug}}">
                                                                    <button class="btn btn-info">Edit</button>
                                                                </a></td>
                                                            <td>
                                                                <meta name="csrf-token"
                                                                      content="<?php echo e(csrf_token()); ?>">

                                                                <button class="btn btn-danger"
                                                                        onclick="dlt('{{$faq->slug}}')">Delete
                                                                </button>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{----------------------------------}}

                                <div role="tabpanel" class="tab-pane fade" id="add"
                                     aria-labelledby="add-tab">

                                    <form method="post" id="faqForm" data-parsley-validate
                                          class="form-horizontal form-label-left">
                                        {{csrf_field()}}

                                        {{Form::bsText('name','Title*')}}

                                        <div class="form-group">
                                            <label for="shortContent"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Short
                                                Content*</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="shortContent"
                                                       class="form-control col-md-6 col-sm-6 col-xs-12"
                                                       name="short_content">
                                            </div>
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit" class="btn btn-success">Save FAQ Title
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
        </div>
    </div>
@endsection

@section('css')
    <!-- Datatables -->
    <link href="/backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="/backend/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css"
          rel="stylesheet">
    <link href="/backend/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"
          rel="stylesheet">
    <link href="/backend/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css"
          rel="stylesheet">
    {{--Sweet Alert--}}
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    <link rel="stylesheet" href="/css/projectCustom.css">
    {{--/Sweet Alert--}}
@endsection

@section('js')
    {{--Sweet Alert--}}
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    {{--  Sweet Alert  For Delet FAQ--}}
    <script>

        function dlt(slug) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will delete this FAQ topic !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST",
                        url: '',
                        data: {
                            'slug': slug,
                            '_token': CSRF_TOKEN
                        }, success: function (response) {
                            Swal.fire(
                                response.processtitle,
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
    {{--/ Sweet Alert  For blog list page--}}

    {{--  Sweet Alert  For add FAQ page--}}
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
                            location.reload();
                        }
                    })
                }
            })
        })
    </script>
    {{--/   For add blog page--}}

    {{--/Sweet Alert--}}


@endsection
