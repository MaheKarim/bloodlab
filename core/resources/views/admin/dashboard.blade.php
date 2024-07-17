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

    <div class="row gy-4 mt-3 ">
        <div class="card px-0">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                        <tr>
                            <th>@lang('Name - Profession')</th>
                            <th>@lang('Email - Phone')</th>
                            <th>@lang('Blood Group - Location')</th>
                            <th>@lang('Gender - Age')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Last Update')</th>
                            <th>@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($donors as $donor)
                            <tr>
                                <td>
                                    <span>{{__($donor->name)}}</span><br>
                                    <span>{{__(Str::limit(@$donor->profession, 20))}}</span>
                                </td>
                                <td>
                                    <span>{{__(@$donor->email)}}</span><br>
                                    <span>{{__($donor->phone)}}</span>
                                </td>
                                <td>
                                    <span>{{__($donor->blood->name)}}</span><br>
                                    <span>{{__($donor->location->name)}}</span>
                                </td>
                                <td>
                                    <span>@if($donor->gender == 1) @lang('Male') @else @lang('Female') @endif</span><br>
                                    <span>{{Carbon\Carbon::parse($donor->birth_date)->age}} @lang('Years')</span>
                                </td>


                                <td data-label="@lang('Status')">
                                    @if($donor->status == 1)
                                        <span class="badge badge--success">@lang('Active')</span>
                                    @elseif($donor->status == 2)
                                        <span class="badge badge--danger">@lang('Banned')</span>
                                    @else
                                        <span class="badge badge--primary">@lang('Pending')</span>
                                    @endif
                                </td>
                                <td>
                                    {{ showDateTime($donor->updated_at) }}<br> {{ diffForHumans($donor->updated_at) }}
                                </td>
                                <td>
                                    @if($donor->status == 2)
                                        <a href="javascript:void(0)" class="btn btn-outline--success ml-1 approved text--white btn-sm" data-toggle="tooltip" data-original-title="@lang('Approve')" data-id="{{$donor->id}}"><i class="las la-check">
                                            </i> @lang('Approve')</a>
                                    @elseif($donor->status == 1)
                                        <a href="javascript:void(0)" class="btn btn-outline--danger ml-1 cancel btn-sm" data-toggle="tooltip" data-original-title="@lang('Banned')" data-id="{{$donor->id}}"><i class="las la-times"></i>
                                            @lang('Banned')
                                        </a>
                                    @elseif($donor->status == 0)
                                        <a href="javascript:void(0)" class="btn btn-outline--success ml-1 approved" data-toggle="tooltip" data-original-title="@lang('Approve')" data-id="{{$donor->id}}"><i class="las la-check"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-outline--danger ml-1 cancel" data-toggle="tooltip" data-original-title="@lang('Banned')" data-id="{{$donor->id}}"><i class="las la-times"></i></a>
                                    @endif
                                    <a href="{{route('admin.donor.edit', $donor->id)}}" class="btn btn-outline--primary btn-sm ml-1"><i class="las la-pen"></i> @lang('Edit')
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table><!-- table end -->

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="approvedby" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Approval Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{route('admin.donor.approved.status')}}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to approved this donor?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancelBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Banned Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{ route('admin.donor.banned.status') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to banned this donor?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        $('.approved').on('click', function () {
            var modal = $('#approvedby');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.modal('show');
        });
        $('.cancel').on('click', function () {
            var modal = $('#cancelBy');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.modal('show');
        });
    </script>
@endpush

