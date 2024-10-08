@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Employees')

{{-- Extend and customize the page content header --}}

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title', 'adminlte')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
 <div class="row p-4">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <a href="{{ route('leave') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Requests" text="{{ App\Models\Leaves::get()->count() }}" theme="secondary" />
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('leave') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Approved" text="{{ App\Models\Leaves::where('is_approved', 1)->count() }}" theme="secondary" />
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('leave') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Rejected" text="{{ App\Models\Leaves::where('is_approved', 0)->count() }}" theme="secondary" />
                            </a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- Create a common footer --}}

@include('/components/layouts/footer_bottom')

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script>

    $(document).ready(function() {
        // Add your common script logic here...
    });

</script>
@endpush

{{-- Add common CSS customizations --}}

@push('css')
<style type="text/css">

    {{-- You can add AdminLTE customizations here --}}

    .card {
        border-radius: none;
    }
    .card-title {
        font-weight: 600;
    }


</style>
@endpush
