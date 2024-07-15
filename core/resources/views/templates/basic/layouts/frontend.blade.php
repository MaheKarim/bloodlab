<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ gs()->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    @stack('style-lib')

    @stack('style')
    <style>
        :root{
            --main: 115, 103, 240;
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-flow: column;
            background-color: #f6f6f6;
            min-height: 100vh;
        }
        body > div,body > section {
            width: 100%;
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-flow: column;
            background-color: #f6f6f6;
            min-height: 100vh;
        }
        body > div,body > section {
            width: 100%;
        }
        .custom--card {
            box-shadow: 0 3px 35px rgba(0,0,0, .1);
            border: 0;
        }
        .custom--card .card-header,.custom--card .card-footer  {
            padding: 13px 25px;
            text-align: center;
            background-color: rgb(var(--main));
            border: 0;
        }
        .custom--card .card-header .title {
            margin-bottom: 0;
            color: #fff
        }
        .custom--card .card-body {
            padding: 25px;
            border: 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-label {
            font-size: 15px;
            font-weight: 500;
            color: #555;
        }
        .form--control.input,.form--control.select{
            height: 45px;
        }
        .form--control {
            border-width: 2px;
            border-color: #dce1e6;
        }
        .form--control:focus {
            border-color: rgb(var(--main));
            box-shadow: 0 0 25px rgba(var(--main) 0.071);
            outline: 0;
        }
        .forgot-pass {
            font-size: 14px;
        }
        .btn--base {
            color: #fff;
            background-color: rgb(var(--main));
        }
        .btn--base:hover {
            color: #fff;
        }
        .btn {
            padding: 10px 30px;
            font-weight: 500;
        }
        .home-link{
            text-decoration: none
        }

        label.required:after{
            content: '*';
            color: #DC3545!important;
            margin-left: 2px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php') }}?color={{ gs('base_color') }}&secondColor={{ gs('secondary_color') }}">
</head>
@php echo loadExtension('google-analytics') @endphp
<body>

@stack('fbComment')

@yield('content')

@php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp
@if(($cookie->data_values->status == Status::ENABLE) && !\Cookie::get('gdpr_cookie'))
    <!-- cookies dark version start -->
    <div class="cookies-card text-center hide">
      <div class="cookies-card__icon bg--base">
        <i class="las la-cookie-bite"></i>
      </div>
      <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }} <a href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a></p>
      <div class="cookies-card__btn mt-4">
        <a href="javascript:void(0)" class="btn btn--base w-100 policy">@lang('Allow')</a>
      </div>
    </div>
  <!-- cookies dark version end -->
  @endif


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('assets/global/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>

@stack('script-lib')

@php echo loadExtension('tawk-chat') @endphp

@include('partials.notify')

@if(gs('pn'))
@include('partials.push_script')
@endif
@stack('script')



<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });

        $('.policy').on('click',function(){
            $.get('{{route('cookie.accept')}}', function(response){
                $('.cookies-card').addClass('d-none');
            });
        });

        setTimeout(function(){
            $('.cookies-card').removeClass('hide')
        },2000);

        var inputElements = $('[type=text],select,textarea');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for',element.attr('name'));
            element.attr('id',element.attr('name'))
        });

        $.each($('input, select, textarea'), function (i, element) {
            var elementType = $(element);
            if(elementType.attr('type') != 'checkbox'){
                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }
            }

        });


        let disableSubmission = false;
        $('.disableSubmission').on('submit',function(e){
            if (disableSubmission) {
            e.preventDefault()
            }else{
            disableSubmission = true;
            }
        });

    })(jQuery);
</script>

</body>
</html>
