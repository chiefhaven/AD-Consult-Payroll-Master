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
                                <!-- Example Row (to be dynamically populated) -->
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>john.doe@example.com</td>
                                    <td>Super Admin</td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                                <!-- Placeholder for Livewire or Loop -->
                                @foreach($admins as $admin)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->role }}</td>
                                        <td>
                                            <a href="{{ route('edit-admin', $admin->id) }}" class="btn btn-info btn-sm">Edit</a>
                                            <button class="btn btn-danger btn-sm" onclick="deleteAdmin({{ $admin->id }})">Delete</button>
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
