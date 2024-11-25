@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Adminitrators')

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
        pageTitle="Administrators"
        buttonName="Add Admin"
        link="add-admin"
    />

    <!-- Admin List Section -->
    <div class="col-lg-12" id="sales">
        <div class="card mb-3 p-4">
            <!-- Card Header -->
            <h4 class="pb-4">All Administrators</h4>

            <!-- Admin Table -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($admins as $admin)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $admin->first_name }}
                                            {{ $admin->middle_name }}
                                            {{ $admin->sirname }}
                                        </td>
                                        <td>{{ $admin->user->email }}</td>
                                        <td>
                                            {{ optional($admin->user->role)->name ?? 'No Role Assigned' }}
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown d-inline-block">
                                                <button type="button" class="btn btn-default" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="d-sm-inline-block">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end p-0">
                                                    <div class="p-2">
                                                        <!-- View -->
                                                        <button class="dropdown-item nav-main-link" @click="viewRole($admin->id)">
                                                            <i class="nav-main-link-icon fas fa-eye"></i>
                                                            <span class="btn">View</span>
                                                        </button>

                                                        <!-- Edit role -->
                                                        <button class="dropdown-item nav-main-link btn" @click="editRole($admin->id)">
                                                            <i class="nav-main-link-icon fas fa-pencil-alt"></i>
                                                            <span class="btn">Edit</span>
                                                        </button>

                                                        <button class="dropdown-item nav-main-link btn delete-designation-confirm" type="button" @click="confirmDelete($admin->id)">
                                                            <i class="nav-main-link-icon fas fa-trash-alt"></i>
                                                            <span class="btn">Delete</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
