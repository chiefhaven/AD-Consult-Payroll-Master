@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'View Client')

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
<div class="row">
    <div>
        <div class="card p-5 employee-profile-header">
            <div class="row">
                <div class="col-md-3">
                    @if (isset($client->logo))
                    <img class="" src="/img/$client->logo" height="auto" width="100%">
                @else
                    <img class="" src="/img/logo-placeholder-png-2.png" height="auto" width="100%">
                @endif
                </div>
                <div class="col-md-1"><p>&nbsp;</p></div>
                <div class="col-md-8">
                    <h2 class="text-white fw-bold">{{ $client->client_name }}</h2>
                    <div class="text-bold">Sologan</div>
                    <p class="text-white">
                        <div class="text-white">Address: {{ $client->client_name }}</div>
                        <div class="text-white">Phone: {{ $client->phone }}</div>
                        <div class="text-white">Email:
                            @if(isset( $client->user->email))
                                {{ $client->user->email }}
                            @else
                                No email set!
                            @endif
                        </div>
                    </p>
                </div>
            </div>
        </div>
        <div class="row m-4">
            <div class="col-md-4">
                <x-adminlte-small-box title="{{ $client->Employee->count() }}" text="Employees" icon="fas fa-users"
                theme="information"/>
            </div>
            <div class="col-md-4">
                <x-adminlte-small-box title="K0.00" text="Unpaid Invoices" icon="fas fa-file-invoice"
                theme="information"/>
            </div>
            <div class="col-md-4">
                <x-adminlte-small-box title="0" text="Tickets" icon="fa-regular fas fa-file-invoice"
                theme="information"/>
            </div>
        </div>
        <div class="row m-4">
            <div class="col-md-8 card p-3">
                <div class="container d-flex justify-content-end">
                    <a class="btn btn-primary mb-4" href="{{ route('add-employee', $client) }}">Add Employee</a>
                </div>
                @include('../employees/includes/employeeTable')
            </div>
            <div class="col-md-1">
                &nbsp;
            </div>
            <div class="col-md-3 card p-5">
                Upcoming events
            </div>
        </div>
    </div>

</div>
@stop

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
