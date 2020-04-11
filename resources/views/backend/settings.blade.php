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

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Current Logo</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <img src="/uploads/img/{{$settings->logo}}" alt="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                       for="logo">Logo</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input type="file" id="logo" name="logo"
                                                           class="form-control col-md-7 col-xs-12">
                                                    <input type="hidden" name="prevLogo" value="{{$settings->logo}}">
                                                </div>
                                            </div>

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"--}}
                                            {{--                                                       for="title">Web Page Title </label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input type="text" id="title" name="title"--}}
                                            {{--                                                           class="form-control col-md-7 col-xs-12">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('title','Web Page Title',$settings->title)}}

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"--}}
                                            {{--                                                       for="keywords">Keywords--}}
                                            {{--                                                </label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input type="text" id="keywords" name="keywords"--}}
                                            {{--                                                           class="form-control col-md-7 col-xs-12">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('keywords','Keywords',$settings->keywords)}}

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label for="description"--}}
                                            {{--                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input id="description" class="form-control col-md-7 col-xs-12"--}}
                                            {{--                                                           type="text" name="description">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('description','Description',$settings->description)}}

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label for="url"--}}
                                            {{--                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Url</label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input id="url" class="form-control col-md-7 col-xs-12"--}}
                                            {{--                                                           type="text" name="url">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('url','Url',$settings->url)}}

                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="tab_contact"
                                             aria-labelledby="contact-tab">


                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"--}}
                                            {{--                                                       for="phone">Phone </label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input type="phone" id="title" name="phone"--}}
                                            {{--                                                           class="form-control col-md-7 col-xs-12">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('phone','Phone',$settings->phone)}}

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"--}}
                                            {{--                                                       for="gsm">Gsm--}}
                                            {{--                                                </label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input type="text" id="gsm" name="gsm"--}}
                                            {{--                                                           class="form-control col-md-7 col-xs-12">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('mail','Mail',$settings->mail)}}

                                            {{Form::bsText('gsm','Gsm',$settings->gsm)}}

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label for="faks"--}}
                                            {{--                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Faks</label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input id="faks" class="form-control col-md-7 col-xs-12"--}}
                                            {{--                                                           type="text" name="faks">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('faks','Faks',$settings->faks)}}

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label for="address"--}}
                                            {{--                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input id="address" class="form-control col-md-7 col-xs-12"--}}
                                            {{--                                                           type="text" name="address">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('address','Address',$settings->address)}}

                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="tab_sm"
                                             aria-labelledby="sm-tab">


                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"--}}
                                            {{--                                                       for="facebook">Facebook </label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input type="facebook" id="title" name="facebook"--}}
                                            {{--                                                           class="form-control col-md-7 col-xs-12">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('facebook','Facebook',$settings->facebook)}}

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"--}}
                                            {{--                                                       for="twitter">Twitter--}}
                                            {{--                                                </label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input type="text" id="twitter" name="twitter"--}}
                                            {{--                                                           class="form-control col-md-7 col-xs-12">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('twitter','Twitter',$settings->twitter)}}

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label for="instagram"--}}
                                            {{--                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Instagram</label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input id="instagram" class="form-control col-md-7 col-xs-12"--}}
                                            {{--                                                           type="text" name="instagram">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('instagram','Instagram',$settings->instagram)}}

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label for="youtube"--}}
                                            {{--                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Youtube</label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input id="youtube" class="form-control col-md-7 col-xs-12"--}}
                                            {{--                                                           type="text" name="youtube">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('youtube','Youtube',$settings->youtube)}}

                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="tab_google"
                                             aria-labelledby="google-tab">

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label for="recapctha"--}}
                                            {{--                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Recapctha</label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input id="recapctha" class="form-control col-md-7 col-xs-12"--}}
                                            {{--                                                           type="text" name="recapctha">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('recapctha','Recapctha',$settings->recapctha)}}

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label for="maps"--}}
                                            {{--                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Maps</label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input id="maps" class="form-control col-md-7 col-xs-12"--}}
                                            {{--                                                           type="text" name="map">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('map','Map',$settings->map)}}

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label for="analystic"--}}
                                            {{--                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Analystic</label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input id="analystic" class="form-control col-md-7 col-xs-12"--}}
                                            {{--                                                           type="text" name="analystic">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('analystic','Analystic',$settings->analystic)}}

                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="tab_mail"
                                             aria-labelledby="mail-tab">

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label for="smtp_user"--}}
                                            {{--                                                       class="control-label col-md-3 col-sm-3 col-xs-12">User--}}
                                            {{--                                                    name</label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input id="smtp_user" class="form-control col-md-7 col-xs-12"--}}
                                            {{--                                                           type="text" name="smtp_user">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('smtp_user','Smtp User',$settings->smtp_user)}}

                                            <div class="form-group">
                                                <label for="smtp_password"
                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="smtp_password" class="form-control col-md-7 col-xs-12"
                                                           type="password" name="smtp_password"
                                                           value="{{$settings->smtp_password}}">
                                                </div>
                                            </div>

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label for="smtp_host"--}}
                                            {{--                                                       class="control-label col-md-3 col-sm-3 col-xs-12">SMTP--}}
                                            {{--                                                    Host</label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input id="smtp_host" class="form-control col-md-7 col-xs-12"--}}
                                            {{--                                                           type="text" name="smtp_host">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('smtp_host','Smtp Host',$settings->smtp_host)}}

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label for="smtp_port"--}}
                                            {{--                                                       class="control-label col-md-3 col-sm-3 col-xs-12">SMTP--}}
                                            {{--                                                    Port</label>--}}
                                            {{--                                                <div class="col-md-6 col-sm-6 col-xs-12">--}}
                                            {{--                                                    <input id="smtp_port" class="form-control col-md-7 col-xs-12"--}}
                                            {{--                                                           type="text" name="smtp_port">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            {{Form::bsText('smtp_port','Smtp Port',$settings->smtp_port)}}

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
    </div>

    <!-- /page content -->
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    <link rel="stylesheet" href="/css/projectCustom.css">

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
@endsection
