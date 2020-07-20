@extends('backend.app')
@section('icerik')
    <title>Admin Panel | Orders Table</title>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Orders Table</h3>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <table id="userTable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Buyer</th>
                                        <th>Total</th>
                                        <th>Order Type</th>
                                        <th>Purchase</th>
                                        <th>Date</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{$order->order_no}}</td>
                                            <td>{{ucfirst($order->getUserNameFromOrder->name).' '.ucfirst($order->getUserNameFromOrder->surname )}}</td>
                                            <td>${{number_format((float)$order->order_total,2,'.','')}}</td>
                                            <td></td>
                                            <td>
                                                @if($order->order_purchase == 0)
                                                    <span  class="btn btn-danger ">not paid</span>
                                                @else
                                                    <span class="btn btn-success">paid</span>
                                                @endif
                                            </td>
                                            <td>{{$order->created_at}}</td>
                                            <td class="td-align">
                                                <a href="">
                                                    <i class="fa fa-cogs" style="color:green;font-size: 18px;"
                                                       data-toggle="tooltip" data-placement="left" title="Edit"></i>
                                                </a>
                                            </td>

                                            <meta name="csrf-token" content="{{ csrf_token() }}">
                                            <td class="td-align"><i class="fa fa-trash"
                                                                    style="color:red;font-size: 18px;cursor:pointer"
                                                                    data-toggle="tooltip" data-placement="left"
                                                                    title="Delete" onclick="dlt(this)"></i>
                                            </td>
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
    {{--Sweet Alert--}}
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    <link rel="stylesheet" href="/css/projectCustom.css">
    {{--/Sweet Alert--}}

    <style>
        .td-align {
            text-align: center;
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
                text: "The user will delete!",
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
                        url: '{{route('deleteUser')}}',
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
                                document.getElementById('userTable').deleteRow(row);
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
@endsection
