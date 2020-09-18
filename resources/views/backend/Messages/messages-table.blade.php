@extends('backend.app')
@section('icerik')
    <title>Admin Panel | Messages Table</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Messages Table</h3>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <table id="messageTable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th style="width: 400px">Message</th>
                                        <th>Date</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($messages as $message)
                                        <tr>

                                            <td @if($message->check_message == 0) class="unreadMessage" @endif>
                                                <a href="{{route('readMessage',['slug'=>$message->slug])}}">{{$message->name}}</a>
                                            </td>
                                            <td @if($message->check_message == 0) class="unreadMessage" @endif>
                                                <a href="{{route('readMessage',['slug'=>$message->slug])}}">{{$message->email}}</a>
                                            </td>
                                            <td @if($message->check_message == 0) class="unreadMessage" @endif>
                                                <a href="{{route('readMessage',['slug'=>$message->slug])}}">{{\Illuminate\Support\Str::limit($message->message,300,$end='...')}}</a>
                                            </td>
                                            <td @if($message->check_message == 0) class="unreadMessage" @endif>
                                                <a href="{{route('readMessage',['slug'=>$message->slug])}}">{{$message->created_at}}</a>
                                            </td>

                                            <td class="td-align"><i class="fa fa-trash"
                                                                    style="color:red;font-size: 18px;cursor:pointer"
                                                                    data-toggle="tooltip" data-placement="left"
                                                                    title="Delete"
                                                                    onclick="dlt(this,'{{$message->slug}}')"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @if(isset($message))
                                    <div style="display:flex;justify-content:center">
                                        {{$message->paginate(10)->links('vendor/pagination/default')}}
                                    </div>
                                @endif
                            </div>
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

    <style>
        .td-align {
            text-align: center;
        }

        .unreadMessage, .unreadMessage a {
            font-weight: 700;
            font-size: 14px;
            /*color: rgba(7, 7, 7, 0.73);*/
            color: #2974b9;
        }
    </style>
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script !src="">
        function dlt(r, slug) {
            var row = r.parentNode.parentNode.rowIndex;
            Swal.fire({
                title: 'Are you sure?',
                text: "The message will delete!",
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
                        url: '{{route('deleteMessage')}}',
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
                            if (response.processStatus == 'success') {
                                document.getElementById('messageTable').deleteRow(row);
                            }
                            Swal.fire(
                                response.processTitle,
                                response.processDesc,
                                response.processStatus
                            ).then(() => {
                                location.reload();
                            })
                        }
                    })
                }
            })
        }
    </script>
@endsection
