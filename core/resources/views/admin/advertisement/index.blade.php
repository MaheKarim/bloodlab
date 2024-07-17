@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two custom-data-table" id="table">
                            <thead>
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Type')</th>
                                <th>@lang('Size')</th>
                                <th>@lang('Impression')</th>
                                <th>@lang('Click')</th>
                                <th>@lang('Redirect')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($advertisements as $k=> $advertisement)
                                <tr>
                                    <td>
                                        @if ($advertisement->type == \App\Constants\Status::IMAGE)
                                            <div class="user">
                                                <div class="thumb">
                                                    <a href="{{getImage(getFilePath('advertisement').'/'. $advertisement->image)}}" target="__blank">
                                                        <img src="{{getImage(getFilePath('advertisement').'/'. $advertisement->image)}}" alt="@lang('image')">
                                                    </a>
                                                </div>
                                                <span class="name">{{__($advertisement->name)}}</span>
                                            </div>
                                        @else
                                            <span class="name">{{__($advertisement->name)}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(@$advertisement->type== \App\Constants\Status::IMAGE)
                                            <span class="badge badge--primary">@lang('Image')</span>
                                        @elseif(@$advertisement->type== \App\Constants\Status::SCRIPT)
                                            <span class="badge badge--primary">@lang('Script')</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ __(@$advertisement->size) }}
                                    </td>
                                    <td>
                                        <span class="badge badge--success"> {{ @$advertisement->impression }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge--primary">
                                            {{ @$advertisement->click }}
                                        </span>
                                    </td>
                                    <td>
                                        <a target="_blank" href="{{ @$advertisement->redirect_url }}">
                                            {{ @$advertisement->redirect_url }}
                                        </a>
                                    </td>
                                    <td>
                                        @php echo $advertisement->statusBadge @endphp
                                    </td>
                                    <td>
                                        <button
                                            data-advertisement="{{ json_encode($advertisement->only('id','name', 'type', 'script', 'image', 'size', 'redirect_url', 'status')) }}"
                                            class="btn btn-sm btn-outline--primary editBtn">
                                            <i class="la la-pen"></i> @lang('Edit')
                                        </button>
                                        <button class="btn btn-sm ms-1 btn-outline--danger deleteBtn"
                                                data-id="{{ $advertisement->id }}"><i
                                                class="la la-trash"></i> @lang('Delete')
                                        </button>
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
                @if ($advertisements->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($advertisements) }}
                    </div>
                @endif
            </div>
        </div>
    </div>


    {{-- ========Create Modal========= --}}
    <div class="modal   fade " id="modal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel"> @lang('Add Advertisement')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.advertisement.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="font-weight-bold required">@lang('Ad name')</label>
                                    <input type="text" name="name" class="form-control" required value="{{ $advertisement ? $advertisement->name : old('name') }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="font-weight-bold required">@lang('Advertisement Type') </label>
                                    <select class="form-control" name="type">
                                        <option value="" selected disabled>@lang('---Please Select One ---')</option>
                                        <option value="image" @if(@$advertisement->type === \App\Constants\Status::IMAGE) selected @endif>@lang('Image')</option>
                                        <option value="script" @if(@$advertisement->type === \App\Constants\Status::SCRIPT) selected @endif>@lang('Script')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="image-size">
                                        <label for="" class="font-weight-bold">@lang('Size') <strong
                                                class="text-danger">*</strong></label>
                                        <select class="form-control" name="size">
                                            <option value="" selected>@lang('---Please Select One ----')</option>
                                            <option value="220x474">@lang('220X474')</option>
                                            <option value="220x303">@lang('220X303')</option>
                                            <option value="220x315">@lang('220X315')</option>
                                            <option value="220x467">@lang('220X467')</option>
                                            <option value="820x213">@lang('820x213')</option>
                                            <option value="416x554">@lang('416x554')</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="__image">
                                <div class="form-group">
                                    <div class="image-upload mt-3">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <label for="" class="font-weight-bold">@lang('Image') <strong
                                                        class="text-danger">*</strong></label>
                                                <div class="profilePicPreview" style="background-position: center;">
                                                    <button type="button" class="remove-image"><i
                                                            class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" size-validation="" class="profilePicUpload d-none"
                                                       name="image" id="imageUpload" accept=".png, .jpg, .jpeg, .gif">
                                                <label for="imageUpload" class="bg--primary mt-3">@lang('Upload
                                            Image')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'):
                                                    <b>@lang('jpeg,jpg,png,gif') <span id="__image_size"></span></b>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="font-weight-bold">@lang('Redirect Url') <strong
                                            class="text-danger">*</strong> </label>
                                    <input type="text" class="form-control" name="redirect_url"
                                           placeholder="@lang('Redirect Url')">
                                </div>
                            </div>
                            <div class="col-lg-12" id="__script">
                                <div class="form-group">
                                    <label for="" class="font-weight-bold">@lang('Script') <strong
                                            class="text-danger">*</strong> </label>
                                    <textarea name="script" class="form-control" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group statusGroup">
                                    <label class="font-weight-bold">@lang('Status')</label>
                                    <input type="checkbox" data-onstyle="-success" data-offstyle="-danger"
                                           data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')"
                                           data-width="100%" name="status">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block btn-lg w-100" id="btn-save"
                                value="add">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- DELETE MODAL --}}
    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Delete Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.advertisement.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to') <span
                                class="font-weight-bold">@lang('delete')</span> @lang('this advertisement') <span
                                class="font-weight-bold withdraw-user"></span>?</p>
                    </div>
                    <input type="hidden" name="advertisement_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--primary __advertisement"><i
            class="las la-plus"></i>@lang('Add New Advertisement')</button>
@endpush

@push('style')
    <style>
        #__script,
        #__image {
            display: none;
        }

        .max-w-50 {
            max-width: 50px !important;
        }

        .image-upload .thumb .profilePicPreview {
            max-width: 100%;
        }

    </style>
@endpush


@push('script')
    <script>
        (function ($) {

            $(".__advertisement").on('click', function (e) {
                let modal = $("#modal");
                modal.find("#modalLabel").text("@lang('Add Advertisement')")

                // Reset form fields
                modal.find('form')[0].reset();
                modal.find('select[name=type]').prop('disabled', false);
                modal.find('select[name=name]').val('');
                modal.find('.profilePicPreview').css('background-image', 'none');

                $(modal).find('#__image').css('display', 'none');
                $(modal).find('#__script').css('display', 'none');
                $(modal).find('#btn-save').text("@lang('Submit')");
                modal.find('.statusGroup').hide();
                // Reset action to default (for new advertisement)
                modal.find('form').attr('action', "{{ route('admin.advertisement.store') }}");

                modal.modal('show');
            });


            $(document).on('change', '#type', function (e) {
                let value = $(this).val();
                if (value == 'script') {
                    $(document).find('#__image').css('display', 'none');
                    $(document).find('#__script').css('display', 'block');
                } else {
                    $(document).find('#__script').css('display', 'none');
                    let size = $(document).find("#size");
                    if (size) {
                        let placeholderImageUrl = `{{ route('placeholder.image', ':size') }}`;
                        $(document).find('.image-upload').css('display', 'block')
                        $(document).find('.profilePicPreview').css('background-image',
                            `url(${placeholderImageUrl.replace(':size', size.val())})`)
                        $(document).find('#__image_size').text(`, Upload Image Size Must Be ${size.val()} px`);
                        $(document).find("#imageUpload").attr('size-validation', size.val())
                        changeImagePreview();
                    }
                    $(document).find('#__image').css('display', 'block');
                }

            });

            $(document).on('change', '#size', function (e) {
                let size = $(this);
                let type = $("#type").val();
                if (type == null || type.length <= 0) {
                    alert("@lang('Please Type Select First')")
                    $("#type").focus();
                    size.val(" ");
                    return;
                }

                if (type == "image") {
                    let placeholderImageUrl = `{{ route('placeholder.image', ':size') }}`;
                    $(document).find('.image-upload').css('display', 'block')
                    $(document).find('.profilePicPreview').css('background-image',
                        `url(${placeholderImageUrl.replace(':size', size.val())})`)
                    $(document).find('#__image_size').text(`, Upload Image Size Must Be ${size.val()} px`);
                    $(document).find("#imageUpload").attr('size-validation', size.val())
                    changeImagePreview();
                }

            });


            $(document).on('click', '.editBtn', function (e) {
                let advertisement = JSON.parse($(this).attr('data-advertisement'));
                let modal = $("#modal");
                let action = "{{ route('admin.advertisement.update', ':id') }}";

                modal.find('input[name=name]').val(advertisement.name);
                modal.find('#size').val(advertisement.size || "");
                modal.find("#type").val(advertisement.type == "1" ? "image" : "script");

                modal.find('select[name=type]').prop('disabled', true); // Disable the Advertisement Type dropdown

                if (advertisement.type == "1") {
                    let imageSrc = "{{ asset(getFilePath('advertisement')) }}/" + advertisement.image;
                    modal.find('.profilePicPreview').css('background-image', `url(${imageSrc})`);
                    modal.find('#__image').css('display', 'block');
                    modal.find('#__script').css('display', 'none');
                    modal.find('textarea[name=script]').text("");
                    modal.find('input[name=redirect_url]').val(advertisement.redirect_url);
                    changeImagePreview();
                } else {
                    modal.find('#__image').css('display', 'none');
                    modal.find('#__script').css('display', 'block');
                    modal.find('textarea[name=script]').text(advertisement.script);
                    modal.find('.profilePicPreview').css('background-image', 'none');
                    modal.find('input[name=redirect_url]').val('');
                }

                modal.find('form').attr('action', action.replace(":id", advertisement.id));
                modal.find("#modalLabel").text("@lang('Edit Advertisement')");
                modal.find('#btn-save').text("@lang('Update')");
                modal.find('.statusGroup').show();

                if (advertisement.status == 1) {
                    modal.find('input[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=status]').bootstrapToggle('off');
                }

                modal.modal('show');
            });


            $(document).on('click', '.deleteBtn', function (e) {

                var modal = $('#deleteModal');
                $('input[name="advertisement_id"]').val($(this).data('id'));
                modal.modal('show');
            });


            function changeImagePreview() {
                let selectSize = $(document).find("#size").val();
                let size = selectSize.split('x');

                $(document).find('#__image').css('display', 'block');
                $(document).find('#__script').css('display', 'none');

                $(document).find(".profilePicPreview").css({
                    'width': `${size[0]}px`,
                    'height': `${size[1]}px`,
                    'background-size': 'cover',
                    'background-position': 'center'
                });
            }

            $(document).on('change', '#imageUpload', function(e) {
                let file = e.target.files[0];
                let reader = new FileReader();

                reader.onloadend = function() {
                    $(document).find('.profilePicPreview').css('background-image', `url(${reader.result})`);
                }

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    $(document).find('.profilePicPreview').css('background-image', 'none');
                }
            });

            function resetAdvertisementModal() {
                let modal = $("#modal");
                modal.find("#modalLabel").text("@lang('Add Advertisement')");

                // Reset form fields
                modal.find('form')[0].reset();
                modal.find('select[name=type]').prop('disabled', false);
                modal.find('select[name=name]').val('');
                modal.find('.profilePicPreview').css('background-image', 'none');

                $(modal).find('#__image').css('display', 'none');
                $(modal).find('#__script').css('display', 'none');
                $(modal).find('#btn-save').text("@lang('Submit')");
                modal.find('.statusGroup').hide();

                // Reset action to default (for new advertisement)
                modal.find('form').attr('action', "{{ route('admin.advertisement.store') }}");

                modal.modal('show');
            }

        })(jQuery);
    </script>
@endpush
