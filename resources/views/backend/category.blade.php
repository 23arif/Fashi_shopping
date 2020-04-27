@extends('backend.app')
@section('icerik')
    <title>Admin Panel | Category</title>

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Category</h3>
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
                                                                          aria-expanded="true">Category List</a>
                                </li>
                                <li role="presentation" class=""><a href="#add" role="tab" id="add-tab"
                                                                    data-toggle="tab"
                                                                    aria-expanded="false">Add Category</a>
                                </li>
                            </ul>

                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="list"
                                     aria-labelledby="list-tab">

                                    <table id="table" class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category Name</th>
                                            <th>Delete</th>
                                        </tr>
                                        </thead>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <tbody>
                                        @foreach($categories as $category)
                                            <tr>
                                                <th scope="row">{{$category->id}}</th>
                                                <td>{{$category->name}}</td>
                                                <td>
                                                    <button onclick="dlt(this,'{{$category->id}}')"
                                                            class="btn btn-danger">Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            @foreach($category->child as $secondaryCategory)
                                                <tr>
                                                    <th scope="row">{{$secondaryCategory->id}}</th>
                                                    <td>{{$category->name}}<i
                                                            class="fa fa-arrow-right"
                                                            style="margin: 0 10px"></i>{{$secondaryCategory->name}}
                                                    </td>
                                                    <td>
                                                        <button onclick="dlt(this,'{{$secondaryCategory->id}}')"
                                                                class="btn btn-danger">Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                                @foreach($secondaryCategory->child as $doubleSecondaryCategory)
                                                    <tr>
                                                        <th scope="row">{{$doubleSecondaryCategory->id}}</th>
                                                        <td>{{$category->name}}<i
                                                                class="fa fa-arrow-right"
                                                                style="margin: 0 10px"></i>{{$secondaryCategory->name}}
                                                            <i class="fa fa-arrow-right"
                                                               style="margin: 0 10px"></i>{{$doubleSecondaryCategory->name}}
                                                        </td>
                                                        <td>
                                                            <button
                                                                onclick="dlt(this,'{{$doubleSecondaryCategory->id}}')"
                                                                class="btn btn-danger">Delete
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <p id="test"></p>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="add"
                                     aria-labelledby="add-tab">
                                    <form method="post" id="categoryForm" data-parsley-validate
                                          class="form-horizontal form-label-left">
                                        {{csrf_field()}}

                                        <div class="form-group">
                                            <label for="shortContent"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Categories</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" name="up_category">
                                                    <option value="0">Primary category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                        @foreach($category->child as $secondary_category)
                                                            <option
                                                                value="{{$secondary_category->id}}">{{$category->name}}
                                                                -->{{$secondary_category->name}}</option>
                                                            @foreach($secondary_category->child as $double_sec_category)
                                                                <option
                                                                    value="{{$double_sec_category->id}}">{{$category->name}}
                                                                    -->{{$secondary_category->name}}
                                                                    -->{{$double_sec_category->name}}</option>
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{Form::bsText('name','Category Name*')}}

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit" class="btn btn-success">Save category
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
    {{--    <link href="/backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">--}}
    {{--    <link href="/backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">--}}
    {{--    <link href="/backend/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css"--}}
    {{--          rel="stylesheet">--}}
    {{--    <link href="/backend/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"--}}
    {{--          rel="stylesheet">--}}
    {{--    <link href="/backend/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css"--}}
    {{--          rel="stylesheet">--}}
    {{--Sweet Alert--}}
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    <link rel="stylesheet" href="/css/projectCustom.css">
    {{--/Sweet Alert--}}
@endsection

@section('js')
    {{--Sweet Alert--}}
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    {{-- Delete function for category list--}}

    <script>

        function dlt(r, id) {
            var row = r.parentNode.parentNode.rowIndex;
            Swal.fire({
                title: 'Are you sure?',
                text: "The category will delete!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "POST",
                    url: '',
                    data: {
                        'id': id,
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
                        if (response.processStatus == 'success') {
                            document.getElementById('table').deleteRow(row);
                        }
                        Swal.fire(
                            response.processTitle,
                            response.processDesc,
                            response.processStatus
                            )
                    }
                })
            }
            })
        }

    </script>

    {{--/ Delete function for category list--}}

    {{--  Sweet Alert  For add category page--}}
    <script>
        $(document).ready(function () {
            $('#categoryForm').ajaxForm({
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
