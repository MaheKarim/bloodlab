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
                                <th>@lang('Group')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Last Update')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($bloods as $blood)
                                <tr>
                                    <td>{{ $blood->name }}</td>
                                    <td> @php echo $blood->statusBadge @endphp</td>
                                    <td>{{ showDateTime($blood->updated_at) }}</td>
                                    <td>
                                        <div class="button-group">
                                            <button class="btn btn-outline--primary cuModalBtn btn-sm"
                                                    data-modal_title="@lang('Edit Blood Group')"
                                                    data-resource="{{ $blood }}"
                                            >
                                                <i class="las la-pen"></i>@lang('Edit')
                                            </button>

                                            @if ($blood->status == Status::ENABLE)
                                                <button
                                                    class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                    data-question="@lang('Are you sure to disable this blood group?')"
                                                    data-action="{{ route('admin.blood-group.status',$blood->id) }}">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @else
                                                <button
                                                    class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                    data-question="@lang('Are you sure to enable this blood group?')"
                                                    data-action="{{ route('admin.blood-group.status',$blood->id) }}">
                                                    <i class="la la-eye"></i> @lang('Enable')
                                                </button>
                                            @endif
                                        </div>
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
                @if ($bloods->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($bloods) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>


    <!-- Confirmation Modal Start -->
    <div class="modal fade" id="cuModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Add Blood Group')</span></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.blood-group.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="required">@lang('Blood Group')</label>
                            <input name="name" type="text" class="form-control bg--white pe-2"
                                   placeholder="@lang('Blood Group')" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary h-45 w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Confirmation Modal End -->
    <x-confirmation-modal/>
@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--primary float-sm-end cuModalBtn"
            data-modal_title="@lang('Create New Blood Group')" type="button">
        <i class="las la-plus"></i>@lang('Add new blood group')
    </button>
@endpush
