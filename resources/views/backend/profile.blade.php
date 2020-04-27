@extends('backend.app')
@section('icerik')
    <title>Admin Panel | Profile</title>

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Profile Settigs</h3>
                </div>
            </div>

            <div class="clearfix"></div>
            @foreach($datas as $data)
            @endforeach
            <div class="">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="row">
                                <div class="col col-xs-12 col-sm-4 col-md-4  " id="profileImageContainer">
                                    <div class="profileImage">
                                        <div class="imageContainer">
                                            <div class="circle">
                                                <img
                                                    src="@if(empty($data->profile_image))/uploads/img/profileImages/default.png @else /uploads/img/profileImages/{{$data->slug}}/{{$data->profile_image}}@endif">
                                            </div>
                                            <b>{{ucfirst($data->name)}}</b>
                                            <p>
                                                @if(\Illuminate\Support\Facades\Auth::user()->status()=='9')
                                                    Admin
                                                @elseif(\Illuminate\Support\Facades\Auth::user()->status()=='1')
                                                    Editor
                                                @elseif(\Illuminate\Support\Facades\Auth::user()->status()=='2')
                                                    Mod
                                                @endif
                                            </p>
                                        </div>
                                        <div class="lists">
                                            <p>Blogs <span class="pull-right">{{count($data->countBlog)}}</span></p>
                                        </div>
                                        <div class="lists">
                                            <p>Blog comments <span
                                                    class="pull-right">{{count($data->countBlogComment)}}</span></p>
                                        </div>
                                        <div class="lists">
                                            <p>FAQs <span class="pull-right">{{count($data->faqQuestions)}}</span></p>
                                        </div>
                                        <div class="lists">
                                            <p>FAQ comments <span
                                                    class="pull-right">{{count($data->faqComments)}}</span></p>
                                        </div>

                                        <div class="changeImage">
                                            <form method="post" id="changeImageForm" enctype="multipart/form-data">
                                                {{csrf_field()}}
                                                <div id="changeImage">
                                                    <input type="file" id="logo" name="logo">
                                                </div>
                                                <div class="row" style="margin-top: 5px;">
                                                    <div class="col col-md-7 col-sm-12 col-xs-6">
                                                        <button type="button" class="btn btn-info btn-block"
                                                                onclick="formSubmit()">
                                                            Select
                                                            image
                                                        </button>
                                                    </div>
                                                    <div class="col col-md-5 col-sm-12 col-xs-6">
                                                        <button class="btn btn-primary btn-block" type="submit">Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div>
                                            <div class="test"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col col-xs-12 col-sm-8 col-md-8  " id="profileSettingsContainer">
                                    <div class="profileSettings">
                                        <form method="post" id="profileForm" data-parsley-validate
                                              class="form-horizontal form-label-left">

                                            {{csrf_field()}}
                                            <div class="row">
                                                <div
                                                    class="formOne col col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-8 col-xs-offset-2">
                                                    <div class="form-group">
                                                        <label for="name"
                                                               class="control-label">Name</label>
                                                        <input id="name" class="form-control"
                                                               type="text" name="name"
                                                               value="{{$data->name}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="surname"
                                                               class="control-label">Surname</label>
                                                        <input id="surname" class="form-control"
                                                               type="text" name="surname"
                                                               value="{{$data->surname}}">
                                                    </div>

                                                </div>
                                                <div
                                                    class="formTwo col col-md-4 col-md-offset-2 col-sm-4 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                                                    <div class="form-group">
                                                        <label for="email"
                                                               class="control-label">E-mail</label>
                                                        <input id="email" class="form-control"
                                                               type="email" name="email"
                                                               value="{{$data->email}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label">Phone</label>
                                                        <div>
                                                            <input type="text" class="form-control"
                                                                   data-inputmask="'mask' : '(999) 999-9999'"
                                                                   name="phone" value="{{$data->phone}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                        <button type="submit" class="btn btn-primary btn-block">Update
                                                            changes
                                                        </button>
                                                    </div>
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
    </div>

    <!-- /page content -->
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    <link rel="stylesheet" href="/css/projectCustom.css">
    <style>
        #profileImageContainer {
            height: auto;
            padding: 10px;
        }

        .profileImage {
            width: 100%;
            min-height: 460px;
            border: 1px solid #eee;
            border-radius: 5px;
        }

        .imageContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .imageContainer b {
            color: #4a423f;
            font-size: 18px;
            margin: 6px 0 0px 0px;
        }

        .circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .circle img {
            max-width: 100%;
            max-height: 100%;
        }

        .lists {
            height: 38px;
            border-bottom: 2px solid #eee
        }

        .lists p {
            margin: 15px;
            color: #4a423f;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .lists span {
            color: #ffc106;
        }

        #changeImage {
            display: none;
        }

        #profileSettingsContainer {
            height: auto;
            padding: 10px;
        }

        .profileSettings {
            width: 100%;
            height: 460px;
            border: 1px solid #eee;
            border-radius: 5px;
            padding-top: 30px;
        }

        .profileSettings label {
            padding-bottom: 7px;
        }

    </style>

@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#changeImageForm').ajaxForm({
                beforeSubmit: function () {
                    Swal.fire({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                        text: 'Loading please wait!',
                        showConfirmButton: false
                    })
                }, success: function (response) {
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

    <script>
        $(document).ready(function () {
            $('#profileForm').ajaxForm({
                beforeSubmit: function () {

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

    <script>

        function formSubmit() {
            $('#logo').click()
        }
    </script>


    <!-- jquery.inputmask -->
    <script src="/backend/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- /jquery.inputmask -->

    <!-- jquery.inputmask -->
    <script>
        $(document).ready(function () {
            $(":input").inputmask();
        });
    </script>
    <!-- /jquery.inputmask -->


@endsection
