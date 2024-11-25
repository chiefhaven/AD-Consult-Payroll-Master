@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Roles')

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
        pageTitle="Roles"
        buttonName="Add role"
        link="add-role"
    />

    <!-- Admin List Section -->
    <div class="col-lg-12" id="sales">
        <div class="card mb-3 p-4">
            <!-- Card Header -->
            <h4 class="pb-4">All roles</h4>

            <!-- Admin Table -->
            <div class="box-body">
                <div class="row">
                    <div class="container">
                        <h1>Assign Permissions to Role: {{ $role->name }}</h1>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('roles.update-permissions', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <h4>Permissions</h4>
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                       name="permissions[]"
                                                       value="{{ $permission->id }}"
                                                       id="permission-{{ $permission->id }}"
                                                       @if(in_array($permission->id, $rolePermissions)) checked @endif>
                                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Permissions</button>
                        </form>
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
