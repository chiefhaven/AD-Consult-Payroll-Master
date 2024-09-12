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
<div class="row">
    <livewire:common.page-header pageTitle="Add payroll" buttonName="Go back" link="/view-client/{{ $client->id }}" buttonClass="btn btn-warning"/>
    <div class="col-lg-12">
        @include('includes/error')
        @section('plugins.Select2', true)
        <div class="card mb-3 p-4">
            <div class="box-body">
                <h3>For Client: <strong>{{ $client->client_name }}</strong></h3>
            </div>
        </div>
        <form wire:submit="save" autocomplete="off">
            <x-adminlte-input type="text" name="client" id="client" wire:model="client" autocomplete="false" hidden/>
            <div class="card mb-3 p-4">
                <div class="box-body">
                    <p>Options</p>
                    <div class="row">
                        <x-adminlte-input type="text" name="group" label="Group" placeholder="Month/Year" fgroup-class="col-12" class="{{ $errors->has('form.group') ? 'is-invalid' : '' }}" id="group" wire:model="form.group" autocomplete="off"/>

                        <x-adminlte-input type="text" name="employees" label="Select employees" placeholder="Employees" fgroup-class="col-12" class="{{ $errors->has('form.employees') ? 'is-invalid' : '' }}" id="employees" wire:model="form.employees" autocomplete="off"/>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                Save
                <div wire:loading>
                    @include('livewire/common/spinner')
                </div>
            </button>
        </form>
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
