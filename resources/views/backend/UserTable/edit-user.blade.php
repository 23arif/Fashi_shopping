@extends('backend.app')
@section('icerik')


    <title>Admin Panel | Edit User</title>

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title">
                    <a href="{{route('getUserTable')}}"><h3 class="fa fa-arrow-circle-left"
                                                            style="font-size: 25px;float: left;margin-right:10px"></h3>
                    </a>
                    <h3 style="float:left;">Edit &nbsp;<u><b>{{ucfirst($user->name)}}'s</b></u>&nbsp; information.</h3>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">

                            <form method="post" id="editUserForm" data-parsley-validate
                                  class="form-horizontal form-label-left">
                                {{csrf_field()}}
                                {{--                                <div class="form-group">--}}
                                {{--                                    <label--}}
                                {{--                                        class="control-label col-md-3 col-sm-3 col-xs-12">Add new images</label>--}}
                                {{--                                    <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                {{--                                        <input type="file" name="photos[]" multiple--}}
                                {{--                                               class="form-control col-md-6 col-sm-6 col-xs-12">--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}

                                <div class="form-group">
                                    <label for="name"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Name *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="name"
                                               class="form-control col-md-6 col-sm-6 col-xs-12" name="name"
                                               value="{{$user->name}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="surname"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Surname</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="surname"
                                               class="form-control col-md-6 col-sm-6 col-xs-12" name="surname"
                                               @if($user->surname)
                                               value="{{$user->surname}}"
                                               @else
                                               placeholder='Does not exist'
                                            @endif >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Email *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="email" name="email" id="email" value="{{$user->email}}"
                                               class="form-control col-md-6 col-sm-6 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phone"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="phone" id="phone"
                                               class="form-control col-md-6 col-sm-6 col-xs-12"
                                               @if($user->phone)
                                               value="{{$user->phone}}"
                                               @else
                                               placeholder='Does not exist'
                                            @endif >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="userStatus"
                                           class="control-label col-md-3 col-sm-3 col-xs-12">Status *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="status" id="status"
                                                class="form-control col-md-6 col-sm-6 col-xs-12">
                                            <option value="{{$user->status}}">{{$uStatus}}</option>
                                            @foreach($allStatuses as $key)
                                                @if($key->status_name != $uStatus)
                                                    <option value="{{$key->status}}">{{$key->status_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-success">Update user
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
            $('#editUserForm').ajaxForm({
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
@endsection
