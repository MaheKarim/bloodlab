@extends('admin.layouts.app')

@section('panel')

    <div class="row gy-4">

        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="6"
                link="{{ route('admin.donor.index') }}"
                icon="las la-users"
                title="Total Donor"
                value="{{ $donor['all'] }}"
                bg="primary"
            />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="6"
                link="{{ route('admin.donor.pending') }}"
                icon="las la-spinner"
                title="Total Pending Donor"
                value="{{ $donor['pending'] }}"
                bg="warning"
            />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="6"
                link="{{route('admin.donor.approved')}}"
                icon="las la-user-slash"
                title="Total Banned Donor"
                value="{{ $donor['banned'] }}"
                bg="danger"
            />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="6"
                link="{{ route('admin.donor.banned') }}"
                icon="las la-user-plus"
                title="Total Approved Donor"
                value="{{ $donor['approved'] }}"
                bg="success"
            />
        </div>
    </div><!-- row end-->

    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="6"
                link="{{route('admin.blood-group.index')}}"
                title="Total Blood Group"
                icon="las la-tint"
                value="{{ $blood }}"
                bg="success"
            />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="6"
                link="{{route('admin.city.index')}}"
                title="Total City"
                icon="las la-city"
                value="{{ __($city) }}"
                bg="info"
            />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="6"
                link="{{route('admin.location.index')}}"
                title="Total Location"
                icon="las la-map"
                value="{{__($locations)}}"
                bg="secondary"
            />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                style="6"
                link="#"
                title="Total Advertisement"
                icon="las la-ad"
                value="{{__($ads)}}"
                bg="dark"
            />
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->


@endsection

