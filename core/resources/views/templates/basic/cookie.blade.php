@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate . 'partials.breadcrumb')
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-12">
                    @php echo $cookie->data_values->description; @endphp
                </div>
            </div>
        </div>
    </section>
@endsection
