@extends('frontend.app')
@section('icerik')
    <title>Fashi | Add FAQs</title>

    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 row">
                    <div class="breadcrumb-text col-md-9">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <a href="/faq"> FAQs</a>
                        <span>Add FAQ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Faq Section Begin -->
    <div class="faq-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-11 offset-lg-1">
                    <div class="contact-form">
                        <div class="leave-comment">
                            <h4>Create new FAQ</h4>
                            <form class="comment-form" id="faqForm" method="post">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-lg-12">
                                        <select id="faqTopic" class="col-lg-12" name="prime_title">
                                            <option disabled selected value>Choose a topic</option>
                                            @foreach($topics as $topic)
                                                <option value="{{$topic->id}}">{{$topic->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-12">
                                        <input type="text" placeholder="Title" name="title">
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea placeholder="Your question" name="content" class="ckeditor"></textarea>
                                        <button type="submit" class="site-btn">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Faq Section End -->


@endsection

@section('css')
    {{--Sweet Alert--}}
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
    {{--/Sweet Alert--}}
    <style>
        #faqTopic {
            height: 50px;
            margin: 30px 0;
            font-size: 16px;
            color: #636363;
            border: 1px solid #ebebeb;

        }

    </style>
@endsection

@section('js')
    {{--Sweet Alert--}}
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>
    {{-----------}}
    {{--Ckeditor--}}
    <script src="/js/ckeditor/ckeditor.js"></script>
    {{--/Ckeditor--}}

    <script>
        $(document).ready(function () {
            $('#faqForm').ajaxForm({
                beforeSubmit: function () {
                    Swal.fire({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                        text: 'Loading please wait!',
                        showConfirmButton: false
                    })
                },
                beforeSerialize: function () {
                    for (instance in CKEDITOR.instances) CKEDITOR.instances[instance].updateElement();
                },
                success: function (response) {
                    Swal.fire(
                        response.processTitle,
                        response.processDesc,
                        response.processStatus
                        ).then(() => {
                        if (response.processStatus == "success") {
                            location.href='/faq';
                        }
                    })
                }
            })
        })
    </script>

@endsection
