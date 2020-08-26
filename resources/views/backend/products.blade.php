@extends('backend.app')
@section('icerik')
    <title>Admin Panel | Products</title>

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Products</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <button id="mobileVersionBtn" class="btn btn-info pull-right" onclick="sH()">Menu</button>
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="mobileVersion" role="tablist">
                                <li role="presentation" class="active"><a href="#list" id="list-tab"
                                                                          role="tab" data-toggle="tab"
                                                                          aria-expanded="true">Products List</a>
                                </li>
                                <li role="presentation" class=""><a href="#add" role="tab" id="add-tab"
                                                                    data-toggle="tab"
                                                                    aria-expanded="false">Add Product</a>
                                </li>
                                <li role="presentation" class=""><a href="#addCategory" role="tab" id="add-tab"
                                                                    data-toggle="tab"
                                                                    aria-expanded="false">Add Product Category</a>
                                </li>
                                <li role="presentation" class=""><a href="#addPrBrand" role="tab" id="add-tab"
                                                                    data-toggle="tab"
                                                                    aria-expanded="false">Add Product Brand</a>
                                </li>
                            </ul>
                            <ul id="myTab" class="nav nav-tabs bar_tabs hidden-md hidden-sm hidden-xs" role="tablist">
                                <li role="presentation" class="active"><a href="#list" id="list-tab"
                                                                          role="tab" data-toggle="tab"
                                                                          aria-expanded="true">Products List</a>
                                </li>
                                <li role="presentation" class=""><a href="#add" role="tab" id="add-tab"
                                                                    data-toggle="tab"
                                                                    aria-expanded="false">Add Product</a>
                                </li>
                                <li role="presentation" class=""><a href="#addCategory" role="tab" id="add-tab"
                                                                    data-toggle="tab"
                                                                    aria-expanded="false">Add Product Category</a>
                                </li>
                                <li role="presentation" class=""><a href="#addPrBrand" role="tab" id="add-tab"
                                                                    data-toggle="tab"
                                                                    aria-expanded="false">Add Product Brand</a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade  active in" id="list"
                                     aria-labelledby="list-tab">

                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Color</th>
                                            <th>Previous price</th>
                                            <th>Last price</th>
                                            <th>Brand</th>
                                            <th>Size</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                        </thead>


                                        <tbody>

                                        @foreach($products as $product)
                                            <tr>
                                                <td>{{$product->id}}</td>
                                                <td>{{$product->pr_name}}</td>
                                                <td>{{strip_tags($product->pr_desc)}}</td>
                                                <td>{{$product->prCategory->category_name}}</td>
                                                <td>{{$product->pr_color}}</td>
                                                <td><strike>{{$product->pr_prev_price}}</strike></td>
                                                <td>{{$product->pr_last_price}}</td>
                                                <td>{{$product->prBrand->name}}</td>
                                                <td>
                                                    @foreach($product->prSize as $s)
                                                        {{ $loop->first ? '' : ', ' }}
                                                        {{$s->size}}&nbsp;
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a href="{{route('adminEditProduct',['slug'=>$product->slug])}}"
                                                       class="btn btn-primary">Edit</a>
                                                </td>
                                                <td>
                                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                                    <button class="btn btn-danger" onclick="dlt('{{$product->slug}}')">
                                                        Delete
                                                    </button>
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="add"
                                     aria-labelledby="add-tab">
                                    <form method="post" id="productForm" enctype="multipart/form-data"
                                          class="form-horizontal form-label-left">
                                        {{csrf_field()}}

                                        <div class="form-group">
                                            <label for="shortContent"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Categories
                                                *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" name="pr_category">
                                                    @foreach($categories as $category)
                                                        <option
                                                            value="{{$category->id}}">{{$category->category_name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="pr_brand"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Brand *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" name="pr_brand">
                                                    @foreach($brands as $brand)
                                                        <option
                                                            value="{{$brand->id}}">{{$brand->name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="pr_size"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Size *</label>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" name="pr_size[]" multiple>
                                                    <option value="xs">XS</option>
                                                    <option value="s">S</option>
                                                    <option value="m">M</option>
                                                    <option value="l">L</option>
                                                    <option value="xl">XL</option>
                                                    <option value="xxl">XXL</option>
                                                    <option value="xxxl">XXXL</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="pr_weight" class="control-label col-md-3 col-sm-3 col-xs-12">Weight
                                                *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="input-group">
                                                    <input name="pr_weight" type="number" placeholder="0.00" min="0"
                                                           step="0.01" data-number-to-fixed="2"
                                                           data-number-stepfactor="100"
                                                           class="form-control currency"
                                                           id="pr_weight" required/>
                                                    <span class="input-group-addon">kq</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3 col-sm-3 col-xs-12">Photos*</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="file" name="photos[]" multiple
                                                       class="form-control col-md-6 col-sm-6 col-xs-12" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="pr_name"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Name *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="pr_name" name="pr_name" class="form-control"
                                                       required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="pr_description"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Description
                                                *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <textarea name="pr_desc" id="pr_description" rows="5"
                                                          class="form-control col-md-6 col-sm-6 col-xs-12 ckeditor"
                                                          required></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Color *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="input-group demo2">
                                                    <input name="pr_color" type="text" value="#038003"
                                                           class="form-control" required/>
                                                    <span class="input-group-addon"><i></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Price *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="input-group">
                                                    <input name="pr_last_price" type="number" placeholder="0.00" min="0"
                                                           step="0.01" data-number-to-fixed="2"
                                                           data-number-stepfactor="100"
                                                           class="form-control currency"
                                                           id="pr_last_price" required/>
                                                    <span class="input-group-addon">$</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="tags"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Tags *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="tags"
                                                       class="form-control col-md-6 col-sm-6 col-xs-12" name="pr_tags"
                                                       value="" data-role="tagsinput">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="pr_sku"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Products SKU
                                                *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="number" id="pr_sku" name="pr_sku" class="form-control"
                                                       required>
                                            </div>
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit" class="btn btn-success">
                                                    Save product
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="addCategory"
                                     aria-labelledby="add-tab">
                                    <form method="post" id="productCatForm" enctype="multipart/form-data"
                                          class="form-horizontal form-label-left">
                                        {{csrf_field()}}

                                        <div class="form-group">
                                            <label for="category_name"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Name *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="category_name" name="category_name"
                                                       class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="category_desc"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Description
                                                *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                 <textarea name="category_desc" id="category_desc" rows="5"
                                                           class="form-control col-md-6 col-sm-6 col-xs-12 ckeditor"></textarea>
                                            </div>
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit" class="btn btn-success">Save category
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="addPrBrand"
                                     aria-labelledby="add-tab">
                                    <form method="post" id="productBrandForm" class="form-horizontal form-label-left">
                                        {{csrf_field()}}

                                        <div class="form-group">
                                            <label for="name"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Brand name
                                                *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="name" name="name"
                                                       class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description"
                                                   class="control-label col-md-3 col-sm-3 col-xs-12">Description
                                                *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                 <textarea name="brand_desc" id="description" rows="5"
                                                           class="form-control col-md-6 col-sm-6 col-xs-12 ckeditor"></textarea>
                                            </div>
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit" class="btn btn-success">Save brand
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

    <!-- Bootstrap Colorpicker -->
    <link href="/backend/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="/backend/vendors/cropper/dist/cropper.min.css" rel="stylesheet">
    <!--/Bootstrap Colorpicker -->

    {{--    Bootstap Tags Input--}}
    <link rel="stylesheet" href="/bootstrap-tagsinput-latest/src/bootstrap-tagsinput.css">
    {{--/Bootstap Tags Input--}}

    <style>
        #mobileVersionBtn {
            display: none;
            z-index: 100;
        }

        .mobileVersion {
            width: 100%;
            height: auto;
            right: 20px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            margin-top: 40px;
            padding: 0;
            display: none;

        }

        .mobileVersion li {
            border-bottom: 1px solid #eee;
            background: #4da5df;
            list-style: none;
            display: flex;
            justify-content: center;
            padding: 10px;
            font-size: 15px;
            font-weight: 700;
        }

        .mobileVersion a {
            color: #fff !important;
        }

        .mobileVersion a:hover, .mobileVersion a:focus {
            text-decoration: underline;
        }

        @media screen and (max-width: 1200px) {
            .dt-buttons, #datatable-buttons_filter {
                display: none;
            }

            #mobileVersionBtn {
                display: block;
            }
        }
    </style>
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

    {{--  Sweet Alert  For product list page--}}
    <script>
        function dlt(slug) {
            Swal.fire({
                title: 'Are you sure?',
                text: "The product will delete!",
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
                            ).then(() => {
                                location.reload();
                            });
                        }
                    })
                }
            })
        }
    </script>
    {{--/ Sweet Alert  For product list page--}}

    {{--  Sweet Alert  For add product/Category/Size page--}}
    <script>
        $(document).ready(function () {
            $('#productForm,#productCatForm,#productSizeForm,#productBrandForm').ajaxForm({
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
    {{--/   For add product/Category/Size page--}}

    {{--/Sweet Alert--}}

    {{--Ckeditor--}}
    <script src="/js/ckeditor/ckeditor.js"></script>
    {{--/Ckeditor--}}

    {{--    Bootstrap Tags Input--}}
    <script src="/bootstrap-tagsinput-latest/src/bootstrap-tagsinput.js"></script>
    {{--/    Bootstrap Tags Input--}}

    <!-- Bootstrap Colorpicker -->
    <script src="/backend/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.demo1').colorpicker();
            $('.demo2').colorpicker();

            $('#demo_forceformat').colorpicker({
                format: 'rgba',
                horizontal: true
            });

            $('#demo_forceformat3').colorpicker({
                format: 'rgba',
            });

            $('.demo-auto').colorpicker();
        });
    </script>
    <!-- /Bootstrap Colorpicker -->

    {{--Product page mobile version menu btn function--}}
    <script !src="">
        function sH() {
            $('.mobileVersion').fadeToggle()
        }

        $('.mobileVersion  li a').on('click', function () {
            $('.mobileVersion').fadeOut()
        })
    </script>
    {{--/Product page mobile version menu btn function--}}

@endsection
