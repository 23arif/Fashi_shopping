@extends('backend.app')
@section('icerik')
    <title>Admin Panel | Users Table</title>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Users Table<small> user count</small></h3>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>E-mail</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{is_null($user->surname) ? '-': $user->surname}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{is_null($user->phone) ? '-': $user->phone}}</td>
                                            <td>
                                                @if ($user->status == '9')
                                                    {{'Super Admin'}}
                                                @elseif ($user->status == '8')
                                                    {{'Admin'}}
                                                @elseif ($user->status == '2')
                                                    {{'Staff'}}
                                                @elseif ($user->status == '1')
                                                    {{'Editor'}}
                                                @elseif ($user->status == '0')
                                                    {{'User'}}
                                                @endif
                                            </td>
                                            <td class="td-align">
                                                <a href="{{route('getEditUser',['getUser'=>$user->slug])}}">
                                                    <i class="fa fa-cogs" style="color:green;font-size: 18px;"
                                                       data-toggle="tooltip" data-placement="left" title="Edit"></i>
                                                </a>
                                            </td>
                                            <td class="td-align"><i class="fa fa-trash"
                                                                    style="color:red;font-size: 18px;cursor:pointer"
                                                                    data-toggle="tooltip" data-placement="left"
                                                                    title="Delete"></i></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .td-align {
            /*display: flex;*/
            /*justify-content: center;*/
            text-align: center;
        }
    </style>
@endsection

@section('js')
@endsection
