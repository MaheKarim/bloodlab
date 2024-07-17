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
                                        <span>@if($donor->gender == 1) @lang('Male') @else @lang('Female') @endif</span><br>
                                        <span>{{Carbon\Carbon::parse($donor->birth_date)->age}} @lang('Years')</span>
                                    </td>
                                    <td>
                                        @if($donor->featured == 1)
                                            <span class="badge badge--success">@lang('Included')</span>
                                            <a href="javascript:void(0)" class="btn btn-outline--info btn-sm ml-2 notInclude" data-toggle="tooltip" title="" data-original-title="@lang('Not Include')" data-id="{{ $donor->id }}">
                                                <i class="las la-arrow-alt-circle-left"></i>
                                            </a>
                                        @else
                                            <span class="badge badge--warning">@lang('Not included')</span>
                                            <a href="javascript:void(0)" class="btn btn-outline--success btn-sm ml-2 include text-white" data-toggle="tooltip" title="" data-original-title="@lang('Include')" data-id="{{ $donor->id }}">
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
                @if ($donors->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($donors) }}
                    </div>
                @endif
            </div><!-- card end -->
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
                        <button type="button" class="btn btn--secondary" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Confirm')</button>
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
                        <span aria-hidden="true">&times;</span>
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
                        <button type="button" class="btn btn--secondary" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="includeFeatured" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Featured Item Include')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.donor.featured.include') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure include this donor featured list?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="NotincludeFeatured" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Featured Item Remove')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.donor.featured.remove') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure remove this donor featured list?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-confirmation-modal/>
@endsection
@push('breadcrumb-plugins')
    <a href="{{ route('admin.donor.create') }}" class="btn btn-sm btn-outline--primary float-sm-end"
            data-modal_title="@lang('Add New Donor')" type="button">
        <i class="las la-plus"></i>@lang('Add New Donor')
    </a>
@endpush
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

        $('.include').on('click', function () {
            var modal = $('#includeFeatured');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.modal('show');
        });

        $('.notInclude').on('click', function () {
            var modal = $('#NotincludeFeatured');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.modal('show');
        });
    </script>
@endpush
