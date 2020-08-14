@extends('backend.app')
@section('icerik')
    <title>Admin Panel | Edit Product</title>

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title">
                    <a href="/admin/blog"><h3 class="fa fa-arrow-circle-left"
                                              style="font-size: 25px;float: left;margin-right:10px"></h3></a>
                    <h3 style="float:left;">Edit &nbsp;<u><b>{{$product->pr_name}}</b></u>&nbsp; Product.</h3>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="row">
                                @foreach($photos = Storage::disk('uploads')->files('img/products/'.$product->slug) as $photo)

                                    <div class="col-md-55" style="height: 150px">
                                        <div class="image view view-first" style="height: 150px">
                                            <img style="width: 100%; height: 100%; display: block;"
                                                 src="/uploads/{{$photo}}"
                                                 alt="image"/>
                                            <div class="mask" style="height: 100%">
                                                <p></p>
                                                <div class="tools tools-bottom" style="bottom: -30px!important;">
                                                    <form action="" method="post"
                                                          class="deleteImage">
                                                        {{csrf_field()}}
                                                        <input type="hidden" name="photo" value="{{$photo}}">
                                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                                class="fa fa-times"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>

                            <form method="post" id="editProductForm" data-parsley-validate
                                  class="form-horizontal form-label-left">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="pr_image"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Add new images</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="pr_image" type="file" name="photos[]" multiple
                                               class="form-control col-md-6 col-sm-6 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="pr_name"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Product Name *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="pr_name" name="pr_name"
                                               class="form-control col-md-6 col-sm-6 col-xs-12"
                                               value="{{$product->pr_name}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="shortContent"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Categories
                                        *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" name="pr_category">
                                            <option
                                                value="{{$product->prCategory->id}}">{{$product->prCategory->category_name}}</option>
                                            @foreach($categories as $category)
                                                @if($category->category_name != $product->prCategory->category_name)
                                                    <option
                                                        value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="pr_brand"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Brand *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" name="pr_brand">
                                            <option
                                                value="{{$product->prBrand->id}}">{{$product->prBrand->name}}</option>
                                            @foreach($brands as $brand)
                                                @if($brand->name != $product->prBrand->name)
                                                    <option
                                                        value="{{$brand->id}}">{{$brand->name}}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="pr_size"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Size *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" name="pr_size">
                                            <option
                                                value="{{$product->prSize->id}}">{{strtoupper($product->prSize->size)}}</option>
                                            @foreach($sizes->sortBy('id') as $size)
                                                @if(strtoupper($size->size) !=strtoupper($product->prSize->size))
                                                    <option
                                                        value="{{$size->id}}">{{strtoupper($size->size)}}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="pr_desc"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Description *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                <textarea name="pr_desc" id="pr_desc" rows="5"
                                                          class="form-control col-md-6 col-sm-6 col-xs-12 ckeditor">{{$product->pr_desc}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tags_1" class="control-label col-md-3 col-sm-3 col-xs-12">Product Tags*</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="pr_tags" id="tags_1" type="text"
                                               class="tags form-control" value="{{$product->pr_tags}}"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="pr_color" class="control-label col-md-3 col-sm-3 col-xs-12">Product
                                        Color *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="input-group demo2">
                                            <input id="pr_color" name="pr_color" type="text"
                                                   value="{{$product->pr_color}}"
                                                   class="form-control"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="pr_weight"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Product Weight *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="pr_weight" name="pr_weight"
                                               class="form-control col-md-6 col-sm-6 col-xs-12"
                                               value="{{$product->pr_weight}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Price *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="input-group">
                                            <input name="pr_last_price" type="number" placeholder="0.00" min="0"
                                                   step="0.01" data-number-to-fixed="2"
                                                   data-number-stepfactor="100"
                                                   class="form-control currency"
                                                   id="c2" value="{{$product->pr_last_price}}"/>
                                            <span class="input-group-addon">$</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="pr_sku"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Product SKU *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="pr_sku" name="pr_sku"
                                               class="form-control col-md-6 col-sm-6 col-xs-12"
                                               value="{{$product->pr_sku}}">
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-success">Update product
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

    <!-- Bootstrap Colorpicker -->
    <link href="/backend/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="/backend/vendors/cropper/dist/cropper.min.css" rel="stylesheet">
    <!--/Bootstrap Colorpicker -->
@endsection

@section('js')
    {{--Sweet Alert--}}
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.deleteImage').ajaxForm({
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
    <script>
        $(document).ready(function () {
            $('#editProductForm').ajaxForm({
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
                            location.href = '{{route("adminProductsPage")}}';
                        }
                    })

                }
            })
        })

    </script>
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

    {{--Price input field--}}
    <script>
        webshims.setOptions('forms-ext', {
            replaceUI: 'auto',
            types: 'number'
        });
        webshims.polyfill('forms forms-ext');
    </script>
    {{--/Price input field--}}
@endsection
