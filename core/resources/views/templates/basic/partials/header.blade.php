@php
    $contact = getContent('contact_us.content', true);
@endphp
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row align-items-center gy-2">
                <div class="col-lg-6 col-md-8 col-sm-9">
                    <ul class="header__info-list d-flex flex-wrap align-items-center justify-content-sm-start justify-content-center">
                        <li><a href="tel:{{__($contact->data_values->contact_number)}}"><i class="las la-phone"></i> {{__($contact->data_values->contact_number)}}</a></li>
                        <li><a href="mailto:{{__($contact->data_values->email_address)}}"><i class="las la-envelope"></i> {{__($contact->data_values->email_address)}}</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-4 col-sm-3 text-sm-end text-center">
                    <div class="header-lang">
                        <div class="custom--dropdown">
                            <div class="custom--dropdown__selected dropdown-list__item">
                                <a href="http://bitlab.test/change/en" class="thumb">
                                    <img src="http://bitlab.test/assets/images/language/660b94fa876ac1712035066.png" alt="image">
                                    <span class="text"> English</span>
                                </a>
                            </div>
                            <ul class="dropdown-list">
                                <li class="dropdown-list__item langSel selected" data-value="en">
                                    <a href="http://bitlab.test/change/en" class="thumb">
                                        <img src="http://bitlab.test/assets/images/language/660b94fa876ac1712035066.png" alt="image">
                                        <span class="text"> English</span>
                                    </a>
                                </li>
                                <li class="dropdown-list__item langSel" data-value="bn">
                                    <a href="http://bitlab.test/change/bn" class="thumb">
                                        <img src="http://bitlab.test/assets/images/language/669391c2d13271720947138.png" alt="image">
                                        <span class="text"> Bengali</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
{{--                    <select class="language-select langSel">--}}
{{--                        @foreach($language as $item)--}}
{{--                            <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}

{{--                    @if (gs('multi_language'))--}}
{{--                        @php--}}
{{--                            $language = App\Models\Language::all();--}}
{{--                            $selectLang = $language->where('code', session('lang'))->first();--}}
{{--                        @endphp--}}
{{--                        <div class="custom--dropdown">--}}
{{--                            <div class="custom--dropdown__selected dropdown-list__item">--}}
{{--                                <div class="thumb">--}}
{{--                                    <img src="{{ getImage(getFilePath('language') . '/' . $selectLang->image, getFileSize('language')) }}" alt="@lang('image')">--}}
{{--                                </div>--}}
{{--                                <span class="text"> {{ __(@$selectLang->name) }} </span>--}}
{{--                            </div>--}}
{{--                            <ul class="dropdown-list">--}}
{{--                                @foreach ($language as $item)--}}
{{--                                    <li class="dropdown-list__item langSel  @if (session('lang') == $item->code) selected @endif" data-value="{{ $item->code }}">--}}
{{--                                        <a href="{{ route('lang', $item->code) }}" class="thumb">--}}
{{--                                            <img src="{{ getImage(getFilePath('language') . '/' . $item->image, getFileSize('language')) }}" alt="@lang('image')">--}}
{{--                                            <span class="text"> {{ __($item->name) }}</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </div>
            </div>
        </div>
    </div>

    <div class="header__bottom">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0 align-items-center">
                <a class="site-logo site-title" href="{{route('home')}}">
                    <img src="{{getImage(getFilePath('logoIcon') .'/logo.png')}}" alt="@lang('logo')">
                </a>
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu ms-auto">
                        @foreach($pages as $k => $data)
                            <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                        @endforeach
                    </ul>
                    <div class="nav-right">
                        <a href="{{route('apply.donor')}}" class="btn btn-md btn--base d-flex align-items-center"><i class="las la-user fs--18px me-2"></i> @lang('Apply as a Donor')</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
