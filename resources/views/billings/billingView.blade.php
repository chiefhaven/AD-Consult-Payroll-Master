@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Billing')

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

    {{-- <div class="row p-4">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <a href="{{ route('employees') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Employee Directory" text="{{ App\Models\Employee::get()->count() }}" theme="secondary" />
                            </a>
                        </div>

                         <div class="col-md-4">
                            <a href="{{ route('payrolls') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Payroll" text="{{ App\Models\Payroll::get()->count() }}" theme="secondary" />
                            </a>
                        </div>

                         <div class="col-md-4">
                            <a href="{{ route('billing') }}" style="text-decoration: none;">
                            <x-adminlte-small-box title="Billings" text="{{ App\Models\Billing::get()->count() }}" theme="secondary" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

      <div class="row p-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body ">
                    {{-- <canvas id="salesChart" style="height: 250px;"></canvas> --}}
                    <div class="row">
                        <div class="col md-6">
                            <div class="title">
                                <p>Companany Name</p>
                                <p>Ginery Corner, street 23, zip code 2356</p>
                                <p>+265 999 777 2345</p>
                            </div>
                        </div>

                        <div class="col md-6">
                            <div>
                                
                            </div>
                        </div>
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

{{-- @push('css')
<style type="text/css">

    {{-- You can add AdminLTE customizations here --}}

    {{-- .card {
        border-radius: none;
    }
    .card-title {
        font-weight: 600;
    }


</style>
@endpush --}}

@push('css')
<style type="text/css">

    {{-- Table styles --}}
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        border: 1px solid #dee2e6; /* Border for table cells */
        padding: 8px; /* Padding for content */
        text-align: left; /* Align text to the left */
    }

    table th {
        background-color: #f8f9fa; /* Light background for table headers */
        font-weight: bold; /* Bold font for headers */
    }

    {{-- Custom styles for AdminLTE card component --}}
    .card {
        border-radius: none;
    }
    .card-title {
        font-weight: 600;
    }

</style>
@endpush
