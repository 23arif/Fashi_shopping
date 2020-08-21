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
                            <button id="mobileVersionBtn" class="btn btn-info pull-right" onclick="sH()">Menu</button>
                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="mobileVersion" role="tablist">
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
                                <ul id="myTab" class="nav nav-tabs bar_tabs hidden-md hidden-sm hidden-xs" role="tablist">
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
                                                        Header / Footer logo</label>
                                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                                        <img src="/uploads/img/Logo/{{$settings[0]->header_logo}}" style="border:2px solid #ddd;padding:10px">
                                                    </div>

                                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                                        <img src="/uploads/img/Logo/{{$settings[0]->footer_logo}}" style="border:2px solid #ddd;padding:10px">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                    >Change Header Logo</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="file" id="header_logo" name="header_logo"
                                                               class="form-control col-md-7 col-xs-12">
                                                        <input type="hidden" name="prevLogo" value="{{$settings[0]->header_logo}}">
                                                    </div>
                                                </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                >Change Footer Logo</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input type="file" id="footer_logo" name="footer_logo"
                                                           class="form-control col-md-7 col-xs-12">
                                                    <input type="hidden" name="prevFooterLogo" value="{{$settings[0]->footer_logo}}">
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

                                            <div class="form-group">
                                                <label for="instagram"
                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Instagram</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="instagram" class="form-control col-md-7 col-xs-12"
                                                           type="instagram" name="instagram"
                                                           value="{{$settings[0]->instagram}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="facebook"
                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Facebook</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="facebook" class="form-control col-md-7 col-xs-12"
                                                           type="facebook" name="facebook"
                                                           value="{{$settings[0]->facebook}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="twitter"
                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Twitter</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="twitter" class="form-control col-md-7 col-xs-12"
                                                           type="twitter" name="twitter"
                                                           value="{{$settings[0]->twitter}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="linkedin"
                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Linkedin</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="linkedin" class="form-control col-md-7 col-xs-12"
                                                           type="linkedin" name="linkedin"
                                                           value="{{$settings[0]->linkedin}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="youtube"
                                                       class="control-label col-md-3 col-sm-3 col-xs-12">Youtube</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="youtube" class="form-control col-md-7 col-xs-12"
                                                           type="youtube" name="youtube"
                                                           value="{{$settings[0]->youtube}}">
                                                </div>
                                            </div>

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

    <style>
        #mobileVersionBtn {
            display: none;
            z-index: 100;
        }

        .mobileVersion {
            width: 100%;
            height: auto;
            right: 20px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            margin-top: 40px;
            padding: 0;
            display: none;

        }

        .mobileVersion li {
            border-bottom: 1px solid #eee;
            background: #4da5df;
            list-style: none;
            display: flex;
            justify-content: center;
            padding: 10px;
            font-size: 15px;
            font-weight: 700;
        }

        .mobileVersion a {
            color: #fff !important;
        }

        .mobileVersion a:hover, .mobileVersion a:focus {
            text-decoration: underline;
        }

        @media screen and (max-width: 1200px) {
            .dt-buttons, #datatable-buttons_filter {
                display: none;
            }

            #mobileVersionBtn {
                display: block;
            }
        }
    </style>

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
                    ).then(()=>{
                        location.reload();
                    })

                }
            })
        })
    </script>

    {{--Product page mobile version menu btn function--}}
    <script !src="">
        function sH() {
            $('.mobileVersion').fadeToggle()
        }

        $('.mobileVersion  li a').on('click', function () {
            $('.mobileVersion').fadeOut()
        })
    </script>
    {{--/Product page mobile version menu btn function--}}

@endsection
