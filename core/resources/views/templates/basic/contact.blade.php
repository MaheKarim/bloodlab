@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-5">
            <div class="text-end">
                <a href="{{ route('home') }}" class="fw-bold home-link"> <i class="las la-long-arrow-alt-left"></i> @lang('Go to Home')</a>
            </div>
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-title">{{ __($pageTitle) }}</h5>
                </div>
                <div class="card-body">
                    <form method="post" class="verify-gcaptcha">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">@lang('Name')</label>
                            <input name="name" type="text" class="form-control form--control" value="{{ old('name',@$user->fullname) }}" @if($user && $user->profile_complete) readonly @endif required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Email')</label>
                            <input name="email" type="email" class="form-control form--control" value="{{  old('email',@$user->email) }}" @if($user) readonly @endif required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Subject')</label>
                            <input name="subject" type="text" class="form-control form--control" value="{{old('subject')}}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Message')</label>
                            <textarea name="message" class="form-control form--control" required>{{old('message')}}</textarea>
                        </div>
                        <x-captcha />
                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@if(@$sections->secs != null)
    @foreach(json_decode($sections->secs) as $sec)
        @include($activeTemplate.'sections.'.$sec)
    @endforeach
@endif
@endsection
