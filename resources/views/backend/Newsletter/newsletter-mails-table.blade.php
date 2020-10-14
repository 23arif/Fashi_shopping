@extends('backend.app')
@section('icerik')
    <title>Admin Panel | Newsletter Table</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Newsletter Table</h3>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <form action="{{route('adminSelectEmailsForBulk')}}" method="post" id="bulkProcess">
                                    @csrf
                                    <table id="messageTable" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="width: 40px"><input type="checkbox" id="selectAll"
                                                                           onchange="slctAll()"></th>
                                            <th>Email</th>
                                            <th>Join Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($newsletterEmails as $newsletterEmail)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td><input type="checkbox" name="bulk[]"
                                                           value="{{$newsletterEmail->email}}"></td>
                                                <td>{{$newsletterEmail->email}}</td>
                                                <td>{{$newsletterEmail->created_at}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary pull-right">Select</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('js')
    <script !src="">
        // Select All checkbox
        function slctAll() {
            if ($('#selectAll').prop('checked') == true) {
                $('input[name="bulk[]"]').prop('checked', true)
            } else {
                $('input[name="bulk[]"]').prop('checked', false)
            }
        }

        $('input[name="bulk[]"]').on('click', function () {
            $('#selectAll').prop('checked', false)
        })

    </script>
@endsection
