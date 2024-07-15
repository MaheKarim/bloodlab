<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ gs()->siteName(__($pageTitle)) }}</title>

    @include('partials.seo')



    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{asset('assets/global/css/all.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php') }}?color={{ gs('base_color') }}&secondColor={{ gs('secondary_color') }}">
    @stack('style-lib')

    @stack('style')


    <style>

        :root{
            --main: 115, 103, 240;
        }

        body {
            background-color: #f6f6f6;
        }

        .page-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-flow: column;
            background-color: #f6f6f6;
            min-height: 100vh;
        }
        .page-wrapper > div,.page-wrapper > section {
            width: 100%;
        }

        .navbar {
            width: 100%;
        }

        .custom--card {
            box-shadow: 0 3px 35px rgba(0, 0, 0, .1);
            border: 0;
        }

        .custom--card .card-header{
            padding: 13px 25px;
            text-align: center;
            background-color: rgb(var(--main));
            border: 0;
        }

        .custom--card .card-footer{
            background: #fff
        }

        .custom--card .card-header .title {
            margin-bottom: 0;
            color: #fff
        }

        .custom--card .card-body {
            padding: 25px;
            border: 0;
        }

        .pagination{
            margin-bottom: 0px;
        }

        .custom--card .card-footer p{
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            font-size: 15px;
            font-weight: 500;
            color: #555;
        }

        .form--control {
            border-width: 2px;
            border-color: #dce1e6;
        }

        input.form--control, select.form--control {
            height: 45px;
        }

        .form--control:focus {
            border-color: rgb(var(--main));
            box-shadow: 0 0 25px rgba(var(--main), 0.071);
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
            padding: 12px 30px;
            font-weight: 500;
        }

        /* table Css */
        .custom--table {
            background-color: #fff;
        }

        .custom--table thead {
            background-color: rgb(var(--main))
        }

        .custom--table thead tr th {
            color: #fff
        }

        .custom--table tbody tr td,
        .custom--table thead tr th {
            vertical-align: middle;
            padding: 10px 20px
        }

        .custom--table tbody tr td:last-child {
            text-align: right
        }

        .custom--table thead tr th:last-child {
            text-align: right
        }

        .custom--table tbody tr:last-child {
            border-bottom: none;
            border-bottom: 1px solid rgb(255, 255, 255);
        }

        .btn-sm {
            padding: 0.25rem 0.5rem !important;
        }

        .navbar-brand img{
            max-width: 220px;
        }

        label.required:after{
            content: '*';
            color: #DC3545!important;
            margin-left: 2px;
        }


        .badge--pending,
.badge--warning,
.badge--success,
.badge--primary,
.badge--danger,
.badge--dark {
    border-radius: 999px;
    padding: 2px 15px;
    position: relative;
    border-radius: 999px;
    -webkit-border-radius: 999px;
    -moz-border-radius: 999px;
    -ms-border-radius: 999px;
    -o-border-radius: 999px;
}

.badge--warning {
    background-color: rgba(255, 159, 67, 0.1);
    border: 1px solid #ff9f43;
    color: #ff9f43;
}

.badge--success {
    background-color: rgba(40, 199, 111, 0.1);
    border: 1px solid #28c76f;
    color: #28c76f;
}

.badge--danger {
    background-color: rgba(234, 84, 85, 0.1);
    border: 1px solid #ea5455;
    color: #ea5455;
}

.badge--primary {
    background-color: rgba(115, 103, 240, 0.1);
    border: 1px solid #4634ff;
    color: #4634ff;
}

.badge--dark {
    background-color: rgba(0, 0, 0, 0.1);
    border: 1px solid #000000;
    color: #000000;
}



.select2-dropdown .select2-title {
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0px !important;
        }

        .select2-dropdown .select2-subtitle {
            font-size: 12px;
            margin-bottom: 0px !important;
        }

        .select2-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #e5e5e5;
        }

        .select2-parent{
            position: relative;
        }

    </style>
</head>
@php echo loadExtension('google-analytics') @endphp
<body>


    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ siteLogo() }}" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="@lang('Toggle navigation')">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">

                    @if(gs('multi_language'))
                        @php
                            $language = App\Models\Language::all();
                        @endphp
                        <select class="langSel form-control">
                            @foreach($language as $item)
                                <option value="{{ $item->code }}" @if(session('lang')==$item->code) selected @endif>{{ __($item->name) }}</option>
                            @endforeach
                        </select>
                    @endif



                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">@lang('contact')</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.login') }}">@lang('login')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('user.register') }}">@lang('register')</a>
                        </li>
                        @endguest
                        @auth
                        <li class="nav-item">
                            <a class="nav-link"
                            href="{{ route('user.home') }}">@lang('Dashboard')</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('Support Ticket')
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                            href="{{ route('ticket.open') }}">@lang('Create New')</a>
                            <a class="dropdown-item" href="{{ route('ticket.index') }}">@lang('My
                                    Ticket')</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('Deposit')
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                            href="{{ route('user.deposit.index') }}">@lang('Deposit Money')</a>
                            <a class="dropdown-item"
                            href="{{ route('user.deposit.history') }}">@lang('Deposit
                                    Log')</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @lang('Withdraw')
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                    href="{{ route('user.withdraw') }}">@lang('Withdraw Money')</a>
                                <a class="dropdown-item"
                                    href="{{ route('user.withdraw.history') }}">@lang('Withdraw
                                    Log')</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.transactions') }}">@lang('Transactions')</a>
                        </li>


                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ auth()->user()->fullname }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('user.profile.setting') }}">
                                    @lang('Profile Setting')
                                </a>
                                <a class="dropdown-item" href="{{ route('user.change.password') }}">
                                    @lang('Change Password')
                                </a>
                                <a class="dropdown-item" href="{{ route('user.twofactor') }}">
                                    @lang('2FA Security')
                                </a>


                                <a class="dropdown-item" href="{{ route('user.logout') }}">
                                    @lang('Logout')
                                </a>

                            </div>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    <div class="page-wrapper">
        @yield('content')
    </div>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('assets/global/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>

    @stack('script-lib')

    @include('partials.notify')

    @php echo loadExtension('tawk-chat') @endphp

    @if(gs('pn'))
    @include('partials.push_script')
    @endif


    @stack('script')



    <script>
        (function ($) {
            "use strict";
            $(".langSel").on("change", function () {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });


            function formatState(state) {
                if (!state.id) return state.text;
                let gatewayData = $(state.element).data();
                return $(`<div class="d-flex gap-2">${gatewayData.imageSrc ? `<div class="select2-image-wrapper"><img class="select2-image" src="${gatewayData.imageSrc}"></div>` : '' }<div class="select2-content"> <p class="select2-title">${gatewayData.title}</p><p class="select2-subtitle">${gatewayData.subtitle}</p></div></div>`);
            }

            $('.select2').each(function(index,element){
                $(element).select2();
            });


            $('.select2-basic').each(function(index,element){
                $(element).select2({
                    dropdownParent: $(element).closest('.select2-parent')
                });
            });

        })(jQuery);

    </script>


    <script>
        (function ($) {
            "use strict";

            var inputElements = $('[type=text],[type=password],select,textarea');
            $.each(inputElements, function (index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for',element.attr('name'));
                element.attr('id',element.attr('name'))
            });

            $.each($('input:not([type=checkbox]):not([type=hidden]), select, textarea'), function (i, element) {

                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }

            });


            $('.showFilterBtn').on('click',function(){
                $('.responsive-filter-card').slideToggle();
            });


            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                    Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                        colum.setAttribute('data-label', heading[i].innerText)
                    });
                });
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
