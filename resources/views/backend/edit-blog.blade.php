@extends('backend.app')
@section('icerik')
    <title>Admin Panel | Edit Blog</title>

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <a href="/admin/blog"><h3 class="fa fa-arrow-circle-left"
                                              style="font-size: 25px;float: left;margin-right:10px"></h3></a>
                    <h3 style="float:left;">Edit &nbsp;<u><b>{{$blog->title}}</b></u>&nbsp; blog.</h3>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="row">
                                @foreach($photos = Storage::disk('uploads')->files('img/blog/'.$blog->slug) as $photo)
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="/uploads/{{$photo}}"
                                                     alt="image"/>
                                                <div class="mask">
                                                    <p></p>
                                                    <div class="tools tools-bottom">
                                                        <form action="" method="post" id="deleteImage"
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
                                    </div>
                                @endforeach
                            </div>

                            <form method="post" id="blogForm" data-parsley-validate
                                  class="form-horizontal form-label-left">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label
                                        class="control-label col-md-3 col-sm-3 col-xs-12">Add new images</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" name="photos[]" multiple
                                               class="form-control col-md-6 col-sm-6 col-xs-12">
                                    </div>
                                </div>

                                {{Form::bsText('title','Title *',$blog->title)}}

                                <div class="form-group">
                                    <label for="description"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Description *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                <textarea name="description" id="description" rows="5"
                                                          class="form-control col-md-6 col-sm-6 col-xs-12 ckeditor">{{$blog->description}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tags *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="tags_1" type="text" class="tags form-control" name="tags"
                                               value="{{$blog->tags}}"/>
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
                    )

                }
            })
        })

    </script>
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
                            location.href = '/admin/blog';
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
@endsection
