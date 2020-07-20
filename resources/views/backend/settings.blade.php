@extends('backend.app')
@section('icerik')
    <title>Admin Panel | Settings</title>

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>General Elements</h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">


                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#tab_general" id="general-tab"
                                                                              role="tab" data-toggle="tab"
                                                                              aria-expanded="true">General Settings</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_contact" role="tab" id="contact-tab"
                                                                        data-toggle="tab"
                                                                        aria-expanded="false">Contact Settings</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_sm" role="tab"
                                                                        id="sm-tab" data-toggle="tab"
                                                                        aria-expanded="false">Social Media Settings</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_google" role="tab"
                                                                        id="google-tab" data-toggle="tab"
                                                                        aria-expanded="false">Google API</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_mail" role="tab"
                                                                        id="mail-tab" data-toggle="tab"
                                                                        aria-expanded="false">Mail Settings</a>
                                    </li>
                                </ul>


                                <form method="post" id="settingsForm" data-parsley-validate
                                      class="form-horizontal form-label-left">

                                    {{csrf_field()}}

                                    <div id="myTabContent" class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="tab_general"
                                             aria-labelledby="general-tab">
                                            @if($errors->any())
                                                <ul>
                                                    @foreach($errors->all() as $error)
                                                        <li>{{$error}}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Current
                                                    Logo</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <img src="/uploads/img/{{$settings[0]->logo}}" alt="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                >Logo</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input type="file" id="logo" name="logo"
                                                           class="form-control col-md-7 col-xs-12">
                                                    <input type="hidden" name="prevLogo" value="{{$settings[0]->logo}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                >Slider</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="check" type="checkbox" name="slider" class="js-switch"
                                                           @if($settings[0]->slider == '1')
                                                           checked @endif />
                                                </div>
                                            </div>
                                            {{Form::bsText('title','Web Page Title',$settings[0]->title)}}
                                            {{Form::bsText('keywords','Keywords',$settings[0]->keywords)}}
                                            {{Form::bsText('description','Description',$settings[0]->description)}}
                                            {{Form::bsText('url','Url',$settings[0]->url)}}

                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="tab_contact"
                                             aria-labelledby="contact-tab">
                                            {{Form::bsText('phone','Phone',$settings[0]->phone)}}
                                            {{Form::bsText('mail','Mail',$settings[0]->mail)}}
                                            {{Form::bsText('gsm','Gsm',$settings[0]->gsm)}}
                                            {{Form::bsText('faks','Faks',$settings[0]->faks)}}
                                            {{Form::bsText('address','Address',$settings[0]->address)}}

                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="tab_sm"
                                             aria-labelledby="sm-tab">
                                            {{Form::bsText('facebook','Facebook',$settings[0]->facebook)}}
                                            {{Form::bsText('twitter','Twitter',$settings[0]->twitter)}}
                                            {{Form::bsText('instagram','Instagram',$settings[0]->instagram)}}
                                            {{Form::bsText('youtube','Youtube',$settings[0]->youtube)}}
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="tab_google"
                                             aria-labelledby="google-tab">
                                            {{Form::bsText('recapctha','Recapctha',$settings[0]->recapctha)}}
                                            {{Form::bsText('map','Map',$settings[0]->map)}}
                                            {{Form::bsText('analystic','Analystic',$settings[0]->analystic)}}
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="tab_mail"
                                             aria-labelledby="mail-tab">

                                            {{Form::bsText('smtp_user','Smtp User',$settings[0]->smtp_user)}}

                                            <div class="form-group">
                                                <label for="smtp_password"
                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="smtp_password" class="form-control col-md-7 col-xs-12"
                                                           type="password" name="smtp_password"
                                                           value="{{$settings[0]->smtp_password}}">
                                                </div>
                                            </div>


                                            {{Form::bsText('smtp_host','Smtp Host',$settings[0]->smtp_host)}}
                                            {{Form::bsText('smtp_port','Smtp Port',$settings[0]->smtp_port)}}

                                        </div>

                                    </div>

                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button type="submit" class="btn btn-success">Save changes
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

    <!-- /page content -->
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    <link rel="stylesheet" href="/css/projectCustom.css">

    <!-- Switchery -->
    <link href="/backend/vendors/switchery/dist/switchery.min.css" rel="stylesheet">

@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#settingsForm').ajaxForm({
                beforeSubmit: function () {

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

    {{--Slider switch--}}
    <script src="/backend/vendors/switchery/dist/switchery.min.js"></script>
    {{--/Slider switch--}}

@endsection
