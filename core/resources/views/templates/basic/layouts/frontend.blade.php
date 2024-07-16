<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ gs()->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')
    <link rel="icon" type="image/png" href="{{getImage(getFilePath('logoIcon') . '/'. 'favicon.png')}}" sizes="16x16">

    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lightcase.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lib/slick.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    @stack('style-lib')
    @stack('style')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php') }}?color={{ gs('base_color') }}&secondColor={{ gs('secondary_color') }}">

</head>
<body>
@stack('fbComment')
<div class="scroll-to-top">
            <span class="scroll-icon">
                <i class="las la-arrow-up"></i>
            </span>
</div>
<div class="preloader-holder">
    <div class="preloader">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
@include($activeTemplate . 'partials.header')
<div class="main-wrapper">
    @yield('content')
</div>

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

@include($activeTemplate . 'partials.footer')
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('assets/global/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/global/js/select2.min.js') }}"></script>

<script src="{{asset($activeTemplateTrue.'js/lib/slick.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/lib/wow.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/lib/lightcase.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/app.js')}}"></script>

@stack('script-lib')
@stack('script')

<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function () {
            window.location.href = "{{route('home')}}/change/" + $(this).val();
        });
        $('.policy').on('click',function(){
            $.get('{{route('cookie.accept')}}', function(response){
                $('.cookies-card').addClass('d-none');
            });
        });

        setTimeout(function(){
            $('.cookies-card').removeClass('hide')
        },2000);

    })(jQuery);
</script>
</body>
</html>
