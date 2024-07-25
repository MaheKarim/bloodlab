@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.donor.store', $donor ? $donor->id : '')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-edit">
                                                <x-image-uploader name="image" type="donor" class="w-100" image="{{ @$donor->image }}" :required="false"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="name" class="font-weight-bold">@lang('Name')</label>
                                    <input type="text" name="name" id="name" value="{{ $donor ? $donor->name : old('name') }}" class="form-control form-control-lg" placeholder="@lang('Enter Full Name')" maxlength="80" required="">
                                </div>

                                <div class="form-group">
                                    <label for="blood_id" class="font-weight-bold">@lang('Blood Group')</label>
                                    <select name="blood_id" id="blood_id" class="form-control form-control-lg select2" required="">
                                        <option value="" selected="" disabled="">@lang('Select One')</option>
                                        @foreach($bloods as $blood)
                                            <option value="{{$blood->id}}" {{ @$donor->blood_id == $blood->id ? 'selected' : '' }}>{{__($blood->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="city" class="font-weight-bold">@lang('City')</label>
                                    <select name="city_id" id="city" class="form-control form-control-lg select2" required="">
                                        <option value="" selected="" disabled="">@lang('Select One')</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}"
                                                    data-locations="{{ json_encode($city->locations) }}"
                                                @selected(@$donor->city_id == $city->id)>
                                                {{ __($city->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="location" class="font-weight-bold">@lang('Location')</label>
                                    <select name="location_id" id="location" class="form-control form-control-lg select2" required="">
                                        <option value="" selected="" disabled="">@lang('Select One')</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="gender" class="font-weight-bold">@lang('Gender')</label>
                                    <select name="gender" id="gender" class="form-control form-control-lg select2" required="">
                                        <option value="" selected="" disabled="">@lang('Select One')</option>
                                        <option value="1" @if(@$donor->gender == Status::MALE) selected @endif>@lang('Male')</option>
                                        <option value="2" @if(@$donor->gender == Status::FEMALE) selected @endif>@lang('Female')</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="facebook" class="form-control-label font-weight-bold">@lang('Facebook Url')</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="facebook" class="form-control form-control-lg" value="{{ $donor ? @$donor->socialMedia->facebook :old('facebook')}}" placeholder="@lang('Enter Facebook Url')" name="facebook" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                            <span class="input-group-text" id="basic-addon2"><i class="lab la-facebook-f"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="twitter" class="form-control-label font-weight-bold">@lang('Twitter Url')</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="twitter" value="{{ $donor ? @$donor->socialMedia->twitter : old('twitter')}}" class="form-control form-control-lg" placeholder="@lang('Enter Twitter Url')" name="twitter" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                            <span class="input-group-text" id="basic-addon2"><i class="lab la-twitter"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="linkedinIn" class="form-control-label font-weight-bold">@lang('LinkedinIn Url')</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="linkedinIn" value="{{$donor ? @$donor->socialMedia->linkedinIn :old('linkedinIn')}}" class="form-control form-control-lg" placeholder="@lang('Enter LinkedinIn Url')" name="linkedinIn" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                            <span class="input-group-text" id="basic-addon2"><i class="lab la-linkedin-in"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="instagram" class="form-control-label font-weight-bold">@lang('Instagram Url')</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="instagram"  value="{{ $donor ? @$donor->socialMedia->instagram : old('instagram')}}" class="form-control form-control-lg" placeholder="@lang('Enter Instagram Url')" name="instagram" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                            <span class="input-group-text" id="basic-addon2"><i class="lab la-instagram"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="font-weight-bold">@lang('Phone')</label>
                                    <input type="text" id="phone" name="phone" value="{{ $donor ? $donor->phone : old('phone')}}" class="form-control form-control-lg" placeholder="@lang('Enter Phone')" maxlength="40" required="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email" class="font-weight-bold">@lang('Email')</label>
                                    <input type="email" id="email" name="email" value="{{ $donor ? $donor->email : old('email')}}" class="form-control form-control-lg" placeholder="@lang('Enter Email')" maxlength="60" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="profession" class="font-weight-bold">@lang('Profession')</label>
                                    <input type="text" id="profession" name="profession" value="{{ $donor ? $donor->profession : old('profession')}}" class="form-control form-control-lg" placeholder="@lang('Enter Profession')" maxlength="80" required="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="religion" class="font-weight-bold">@lang('Religion')</label>
                                    <input type="text" name="religion" id="religion" value="{{ $donor ? $donor->religion : old('religion')}}" class="form-control form-control-lg" placeholder="@lang('Enter Religion')" maxlength="40" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="address" class="font-weight-bold">@lang('Address')</label>
                                    <input type="text" name="address" id="address" value="{{ $donor ? $donor->address : old('address')}}" class="form-control form-control-lg" placeholder="@lang('Enter Address')" maxlength="255" required="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="donate" class="font-weight-bold">@lang('Total Donate')</label>
                                    <input type="number" name="total_donate" id="total_donate" value="{{ $donor ? $donor->total_donate : old('total_donate')}}" class="form-control form-control-lg" placeholder="@lang('Enter Total Blood Donate')" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="birth_date" class="font-weight-bold">@lang('Date Of Birth')</label>
                                    <input type="date" name="birth_date" id="birth_date" value="{{ $donor?$donor->birth_date : old('birth_date')}}" data-language="en" class="form-control form-control-lg datepicker-here" placeholder="@lang('Enter Date Of Birth')" required="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="last_donate" class="font-weight-bold">@lang('Last Donate')</label>
                                    <input type="date" name="last_donate" id="last_donate" value="{{ $donor? $donor->last_donate : old('last_donate') }}" data-language="en" class="form-control form-control-lg datepicker-here" placeholder="@lang('Enter Last Donate Date')" required="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="about_donor" class="font-weight-bold">@lang('About Donor')</label>
                                    <textarea name="details" id="about_donor" class="form-control form-control-lg" placeholder="@lang('Enter About Donor')">{{
                                        $donor ? $donor->details : old('details')}}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                           data-bs-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Banned')" name="status"
                                           @if (@$donor->status) checked @endif>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn--primary w-100 h-45">
                                <i class="fa fa-fw fa-paper-plane"></i> @lang('Submit')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.donor.index') }}" />
@endpush
@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/daterangepicker.css') }}">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
@endpush
@push('script')
    <script>
        "use strict";
        $(document).ready(function() {
            $('select[name=city_id]').on('change', function() {
                var locations = $(this).find(':selected').data('locations');
                locationHtml(locations);
            });
        });

        @if(@$donor->city_id)
            let cities=@json($cities);
            let cityId="{{@$donor->city_id}}"
            let city=cities.find(city=>city.id== cityId);
            locationHtml(city.locations);
        @endif

        function locationHtml(locations){
            let selectedLocationId="{{old('location_id',@$donor->location_id)}}";
            console.log(selectedLocationId)
            let html=`<option value="" selected disabled>@lang('Select One')</option>`;
            $.each(locations, function(index, location) {
                let isSelected=location.id == selectedLocationId ? 'selected' : '';
                html+=`<option  ${isSelected} value="${location.id}">${location.name}</option>`
            });
            $('select[name=location_id]').html(html);
        }
    </script>
@endpush

