@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Add adminitrator')

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
    <!-- Page Header -->
    <livewire:common.page-header
        pageTitle="Add administrator"
    />

    <!-- Admin List Section -->
    <div class="col-lg-12" id="sales">
        <div class="card mb-3 p-4">
            <form action="{{ route('admin-store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- First Name -->
                    <x-adminlte-input
                        name="first_name"
                        label="First Name"
                        placeholder="Enter First Name"
                        fgroup-class="col-md-4"
                        required
                    />

                    <!-- Middle Name -->
                    <x-adminlte-input
                        name="middle_name"
                        label="Middle Name"
                        placeholder="Enter Middle Name"
                        fgroup-class="col-md-4"
                    />

                    <!-- Sirname -->
                    <x-adminlte-input
                        name="sirname"
                        label="Sirname"
                        placeholder="Enter Sirname"
                        fgroup-class="col-md-4"
                        required
                    />
                </div>

                <!-- Profile Picture -->
                <div class="mb-3">
                    <label for="profile_picture" class="form-label">Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror">
                    @error('profile_picture')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Phone -->
                    <x-adminlte-input
                        name="phone"
                        label="Phone"
                        placeholder="Enter Phone Number"
                        fgroup-class="col-md-4"
                    />
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <!-- Alternative Phone -->
                    <x-adminlte-input
                        name="alt_phone"
                        label="Alternative Phone"
                        placeholder="Enter Alternative Phone Number"
                        fgroup-class="col-md-4"
                    />
                    @error('alt_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Street Address -->
                    <x-adminlte-input
                        name="street_address"
                        label="Street Address"
                        placeholder="Enter Street Address"
                        fgroup-class="col-md-4"
                    />
                    @error('street_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <!-- District -->
                        <x-adminlte-input
                            name="district"
                            label="District"
                            placeholder="Enter District"
                            fgroup-class="col-md-4"
                        />
                        @error('district')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    <!-- Country -->
                    <x-adminlte-input
                        name="country"
                        label="Country"
                        placeholder="Enter Country"
                        fgroup-class="col-md-4"
                    />
                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Role -->
                    <x-adminlte-select
                        name="role"
                        label="Role"
                        fgroup-class="col-md-6"
                    >
                        <option value="it_admin">IT Admin</option>
                        <option value="hr_admin">HR Admin</option>
                        <option value="finance_admin">Finance Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </x-adminlte-select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <!-- Is Active Checkbox -->
                    <div class="form-check">
                        <x-adminlte-input
                            type="checkbox"
                            name="is_active"
                            id="is_active"
                            label="Is Active"
                            class="form-check-input"
                        />
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Create Admin</button>
            </form>

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
        $('#invoicesSalesTable').DataTable({
            dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ],
            scrollX: true,
            scrollY: true,
        });

        $('#quotationsSalesTable').DataTable({
            dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ],
            scrollX: true,
            scrollY: true,
        });
    });

    const admins = createApp({
        setup() {

        }
    });

    admins.mount('#admins');

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
