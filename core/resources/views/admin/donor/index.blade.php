@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Name - Profession')</th>
                                <th>@lang('Email - Phone')</th>
                                <th>@lang('Blood Group - Location')</th>
                                <th>@lang('Religion - Address')</th>
                                <th>@lang('Gender - Age')</th>
                                <th>@lang('Featured Donor')</th>
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
                                        <span>{{__(@$donor->profession)}}</span>
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
                                        <span>{{__($donor->religion)}}</span><br>
                                        <span>{{__($donor->address)}}</span>
                                    </td>
                                    <td>
                                        <span>@if($donor->gender == 1) @lang('Male') @else @lang('Female') @endif</span><br>
                                        <span>{{Carbon\Carbon::parse($donor->birth_date)->age}} @lang('Years')</span>
                                    </td>
                                    <td>
                                        @if($donor->featured == 1)
                                            <span class="badge badge--success">@lang('Included')</span>
                                            <a href="javascript:void(0)" class="icon-btn btn--info ml-2 notInclude" data-toggle="tooltip" title="" data-original-title="@lang('Not Include')" data-id="{{ $donor->id }}">
                                                <i class="las la-arrow-alt-circle-left"></i>
                                            </a>
                                        @else
                                            <span class="badge badge--warning">@lang('Not included')</span>
                                            <a href="javascript:void(0)" class="icon-btn btn--success ml-2 include text-white" data-toggle="tooltip" title="" data-original-title="@lang('Include')" data-id="{{ $donor->id }}">
                                                <i class="las la-arrow-alt-circle-right"></i>
                                            </a>
                                        @endif
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
                                    <td data-label="@lang('Action')">
                                        @if($donor->status == 2)
                                            <a href="javascript:void(0)" class="icon-btn btn--success ml-1 approved" data-toggle="tooltip" data-original-title="@lang('Approve')" data-id="{{$donor->id}}"><i class="las la-check"></i></a>
                                        @elseif($donor->status == 1)
                                            <a href="javascript:void(0)" class="icon-btn btn--danger ml-1 cancel" data-toggle="tooltip" data-original-title="@lang('Banned')" data-id="{{$donor->id}}"><i class="las la-times"></i></a>
                                        @elseif($donor->status == 0)
                                            <a href="javascript:void(0)" class="icon-btn btn--success ml-1 approved" data-toggle="tooltip" data-original-title="@lang('Approve')" data-id="{{$donor->id}}"><i class="las la-check"></i></a>
                                            <a href="javascript:void(0)" class="icon-btn btn--danger ml-1 cancel" data-toggle="tooltip" data-original-title="@lang('Banned')" data-id="{{$donor->id}}"><i class="las la-times"></i></a>
                                        @endif
                                        <a href="{{route('admin.donor.edit', $donor->id)}}" class="icon-btn btn--primary ml-1"><i class="las la-pen"></i></a>
                                    </td>
{{--                                    <td>--}}
{{--                                        <div class="button-group">--}}
{{--                                            <button class="btn btn-outline--primary cuModalBtn btn-sm"--}}
{{--                                                    data-modal_title="@lang('Edit City')"--}}
{{--                                                    data-resource="{{ $city }}"--}}
{{--                                            >--}}
{{--                                                <i class="las la-pen"></i>@lang('Edit')--}}
{{--                                            </button>--}}

{{--                                            @if ($city->status == Status::ENABLE)--}}
{{--                                                <button--}}
{{--                                                    class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"--}}
{{--                                                    data-question="@lang('Are you sure to disable this city?')"--}}
{{--                                                    data-action="{{ route('admin.city.status',$city->id) }}">--}}
{{--                                                    <i class="la la-eye-slash"></i> @lang('Disable')--}}
{{--                                                </button>--}}
{{--                                            @else--}}
{{--                                                <button--}}
{{--                                                    class="btn btn-sm btn-outline--success ms-1 confirmationBtn"--}}
{{--                                                    data-question="@lang('Are you sure to enable this city?')"--}}
{{--                                                    data-action="{{ route('admin.city.status',$city->id) }}">--}}
{{--                                                    <i class="la la-eye"></i> @lang('Enable')--}}
{{--                                                </button>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
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
                @if ($donors->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($donors) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
    <x-confirmation-modal/>
@endsection
@push('breadcrumb-plugins')
    <a href="{{ route('admin.donor.create') }}" class="btn btn-sm btn-outline--primary float-sm-end"
            data-modal_title="@lang('Add New Donor')" type="button">
        <i class="las la-plus"></i>@lang('Add new donor')
    </a>
@endpush
