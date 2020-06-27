@extends('backend.app')
@section('icerik')
    <title>Admin Panel | Blog</title>

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Blog</h3>
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
                                                                          aria-expanded="true">Blog List</a>
                                </li>
                                <li role="presentation" class=""><a href="#add" role="tab" id="add-tab"
                                                                    data-toggle="tab"
                                                                    aria-expanded="false">Add Blog</a>
                                </li>
                            </ul>

                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="list"
                                     aria-labelledby="list-tab">

                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Category</th>
                                            <th>Hit</th>
                                            <th>Comments</th>
                                            <th>Created at</th>
                                            <th>Delete</th>
                                            <th>Edit</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        @php
                                            $queue = 1;
                                        @endphp

                                        @foreach($blogs->sortByDesc('id') as $blog)
                                            <tr>
                                                <td>{{$blog->id}}</td>
                                                <td>{{$blog->title}}</td>
                                                <td>{{$blog->user->name}}</td>
                                                <td>{{$blog->category}}</td>
                                                <td>{{$blog->hit}}</td>
                                                <td>{{count($blog->comments)}}</td>
                                                <td>
                                                    {{$blog->created_at->formatLocalized('%d')}} {{$blog->created_at->formatLocalized('%b')}},{{$blog->created_at->formatLocalized('%Y')}}
                                                </td>
                                                <td>
                                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                                    <button class="btn btn-danger" onclick="dlt('{{$blog->slug}}')">
                                                        Delete
                                                    </button>
                                                </td>
                                                <td>
                                                    <a href="blog/edit-blog/{{$blog->slug}}" class="btn btn-primary">Edit</a>
                                                </td>
                                            </tr>
                                            @php
                                                $queue++
                                            @endphp

                                        @endforeach
                                        </tbody>
                                    </table>
                                    <p id="test"></p>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="add"
                                     aria-labelledby="add-tab">
                                    <form method="post" id="blogForm" data-parsley-validate
                                          class="form-horizontal form-label-left">
                                        {{csrf_field()}}
                                        {{-- ////--}}
                                        <input type="hidden" name="check" value="blogForm">
                                        {{-- ///--}}
                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3 col-sm-3 col-xs-12">Photos*</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="file" name="photos[]" multiple
                                                       class="form-control col-md-6 col-sm-6 col-xs-12" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="shortContent"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Categories
                                                *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" name="category">
                                                    <option value="0">Other category</option>
                                                    @foreach($categories as $category)
                                                        <option
                                                            value="{{$category->id}}">{{$category->name}}</option>
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


                                        {{Form::bsText('title','Title*')}}

                                        <div class="form-group">
                                            <label for="shortContent"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Short
                                                Content</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="shortContent"
                                                       class="form-control col-md-6 col-sm-6 col-xs-12"
                                                       name="short_content">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="description"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Description*</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <textarea name="description" id="description" rows="5"
                                                          class="form-control col-md-6 col-sm-6 col-xs-12 ckeditor"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tags*</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="tags_1" type="text" class="tags form-control" name="tags"/>
                                            </div>
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit" class="btn btn-success">Save blog
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
    <!-- Datatables -->
    <script src="/backend/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/backend/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="/backend/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/backend/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="/backend/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="/backend/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/backend/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/backend/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="/backend/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="/backend/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/backend/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="/backend/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="/backend/vendors/jszip/dist/jszip.min.js"></script>
    <script src="/backend/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="/backend/vendors/pdfmake/build/vfs_fonts.js"></script>

    <script>
        $(document).ready(function () {
            var handleDataTableButtons = function () {
                if ($("#datatable-buttons").length) {
                    $("#datatable-buttons").DataTable({
                        dom: "Bfrtip",
                        buttons: [
                            {
                                extend: "copy",
                                className: "btn-sm"
                            },
                            {
                                extend: "csv",
                                className: "btn-sm"
                            },
                            {
                                extend: "excel",
                                className: "btn-sm"
                            },
                            {
                                extend: "pdfHtml5",
                                className: "btn-sm"
                            },
                            {
                                extend: "print",
                                className: "btn-sm"
                            },
                        ],
                        responsive: true
                    });
                }
            };

            TableManageButtons = function () {
                "use strict";
                return {
                    init: function () {
                        handleDataTableButtons();
                    }
                };
            }();

            $('#datatable').dataTable();

            $('#datatable-keytable').DataTable({
                keys: true
            });

            $('#datatable-responsive').DataTable();

            $('#datatable-scroller').DataTable({
                ajax: "js/datatables/json/scroller-demo.json",
                deferRender: true,
                scrollY: 380,
                scrollCollapse: true,
                scroller: true
            });

            $('#datatable-fixed-header').DataTable({
                fixedHeader: true
            });

            var $datatable = $('#datatable-checkbox');

            $datatable.dataTable({
                'order': [[1, 'asc']],
                'columnDefs': [
                    {orderable: false, targets: [0]}
                ]
            });
            $datatable.on('draw.dt', function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_flat-green'
                });
            });

            TableManageButtons.init();
        });
    </script>

    <!-- /Datatables -->


    {{--Sweet Alert--}}
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    {{--  Sweet Alert  For blog list page--}}
    <script>
        function dlt(slug) {
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
                            'slug': slug,
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
                                ).then(()=>{
                                    location.reload();
                            });
                        }
                    })
                }
            })
        }
    </script>
    {{--/ Sweet Alert  For blog list page--}}

    {{--  Sweet Alert  For add blog page--}}
    <script>
        $(document).ready(function () {
            $('#blogForm').ajaxForm({
                beforeSubmit: function () {
                    Swal.fire({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                        text: 'Loading please wait!',
                        showConfirmButton: false
                    })
                },
                beforeSerialize: function () {
                    for (instance in CKEDITOR.instances) CKEDITOR.instances[instance].updateElement();
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

    {{--Ckeditor--}}
    <script src="/js/ckeditor/ckeditor.js"></script>
    {{--/Ckeditor--}}

    <!-- jQuery Tags Input -->
    <script src="/backend/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <script>
        function onAddTag(tag) {
            alert("Added a tag: " + tag);
        }

        function onRemoveTag(tag) {
            alert("Removed a tag: " + tag);
        }

        function onChangeTag(input, tag) {
            alert("Changed a tag: " + tag);
        }

        $(document).ready(function () {
            $('#tags_1').tagsInput({
                width: 'auto'
            });
        });
    </script>
    <!-- /jQuery Tags Input -->


@endsection
