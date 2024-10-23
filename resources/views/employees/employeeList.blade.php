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
    <livewire:common.page-header pageTitle="Employees" buttonName="Add Employee"/>
    <div class="col-lg-12">
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>All employees</p>
                <div class="table-responsive">
                    @if( !$employees->isEmpty())
                      <table id="employeeTable" class="table table-bordered table-striped table-vcenter">
                          <thead>
                              <tr>
                                <th style="min-width: 150px;">Full name</th>
                                <th>Company/Organisation</th>
                                <th>Designation</th>
                                <th style="min-width: 150px;">Phone</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Resident Country</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 100px;">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach ($employees as $employee)
                              <tr>
                                <td class="font-w600">
                                    {{$employee->fname}}
                                    {{$employee->sname}}
                                    {{$employee->mname}}
                                </td>
                                <td>
                                    {{ $employee->client ? $employee->client->client_name : 'Not assigned yet' }}
                                </td>
                                <td>
                                    <div class="text-bold">{{ $employee->designation->name ?? 'N/A' }}</div>

                                </td>
                                <td>
                                    {{$employee->phone}}
                                </td>
                                <td>
                                    @if(isset($employee->user->email))

                                        {{$employee->user->email}}

                                    @else

                                    @endif
                                </td>
                                <td>
                                    {{$employee->resident_city}}
                                </td>
                                <td>
                                    {{$employee->resident_country}}
                                </td>
                                <td>
                                    {{$employee->status}}
                                </td>
                                <td class="text-center">
                                    <div class="dropdown d-inline-block">
                                        <button type="button" class="btn btn-primary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="d-sm-inline-block">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end p-0">
                                        <div class="p-2">
                                            <a class="dropdown-item nav-main-link" href="{{ url('/view-employee', $employee) }}">
                                            <i class="nav-main-link-icon fa fa-eye"></i><div class="btn">Profile</div>
                                            </a>
                                            <form method="GET" class="dropdown-item nav-main-link" action="{{ url('/edit-employee', $employee) }}">
                                                {{ csrf_field() }}
                                                <i class="nav-main-link-icon fa fa-pencil-alt"></i>
                                                <button class="btn" type="submit">Edit</button>
                                            </form>
                                            <form class="dropdown-item nav-main-link" method="POST" action="{{ url('delete-employee', $employee->id) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <i class="nav-main-link-icon fa fa-trash"></i>
                                                <button class="btn delete-employee-confirm" type="submit">Delete</button>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>

                    @else
                        <p class="p-5">No employees yet for this client!</p>
                    @endif
                </div>
                <x-livewire-alert::scripts />
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
        $('#employeeTable').DataTable({
            scrollX: true,
            scrollY: true,
        }); // Add your common script logic here...
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
