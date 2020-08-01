@extends('backend.app')
@section('icerik')


    <title>Admin Panel | Edit User</title>

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title">
                    <a href="{{route('adminMessagesPage')}}"><h3 class="fa fa-arrow-circle-left"
                                                                 style="font-size: 25px;float: left;margin-right:10px"></h3>
                    </a>
                    <h3 style="float:left;">Edit &nbsp;<u><b>{{ucfirst($message->name)}}'s</b></u>&nbsp; message.</h3>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <row>
                                <div style="margin-bottom: 18px"><span
                                        style="font-size: 18px">{{$message->name}}</span>
                                    <span>- {{$message->created_at->formatLocalized('%d')}} {{$message->created_at->formatLocalized('%b')}},{{$message->created_at->formatLocalized('%Y')}}</span>
                                </div>
                                <div>
                                    <span id="messageContent">{{$message->message}}</span>
                                </div>
                            </row>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        #messageContent {
            color: #000;
            letter-spacing: 0.2px;
            line-height: 20px;
        }
    </style>
@endsection

@section('js')

@endsection
