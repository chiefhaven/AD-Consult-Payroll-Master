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
@php
    use Carbon\Carbon;
    use App\Http\Controllers\Common\BusinessUtil;

    $estimatedPaye = new BusinessUtil;

    $estimatedPaye = $estimatedPaye->calculatePaye($employee->salary);
    $netSalary = $employee->salary - $estimatedPaye;
    $estimatedTotal =$netSalary + $employee->bonus;


    // Check if both hiredate and contract_end_date exist
    if ($employee->hiredate && $employee->contract_end_date) {
        $hireDate = Carbon::parse($employee->hiredate);
        $endDate = Carbon::parse($employee->contract_end_date);

        // Calculate the difference
        $diff = $hireDate->diff($endDate);

        $contractYears = $diff->y;
        $contractMonths = $diff->m;
        $contractDays = $diff->d;

        // Optional: Format the output string
        $contractDuration = '';
        if ($contractYears > 0) {
            $contractDuration .= $contractYears . ' year' . ($contractYears > 1 ? 's' : '') . ' ';
        }
        if ($contractMonths > 0) {
            $contractDuration .= $contractMonths . ' month' . ($contractMonths > 1 ? 's' : '') . ' ';
        }
        if ($contractDays > 0) {
            $contractDuration .= $contractDays . ' day' . ($contractDays > 1 ? 's' : '') . ' ';
        }
    }
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="row card p-5 mt-3">
            <div class="row">
                <div class="col-md-3">
                    <img class="" src="/img/employee-profile.jpg" height="auto" width="100%">
                </div>
                <div class="col-md-1"><p>&nbsp;</p></div>
                <div class="col-md-8">
                    <h2 class="fw-bold">{{ $employee->fname }} {{ $employee->mname }} {{ $employee->sname }}</h2>
                    <div class="text-bold">{{ $employee->designation->name ?? 'N/A' }}</div>
                    <table class="mt-4">
                        <thead>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr class="fw-bold">
                                <td>Company:</td>
                                <td>{{ $employee->client->client_name }}</td>
                            </tr>
                            <tr class="">

                                    <td>
                                        Address:
                                    </td>
                                    <td>
                                        {{ $employee->resident_street }}, {{ $employee->resident_state }}, {{ $employee->resident_district }}{{ $employee->resident_country }}
                                    </td>
                            </tr>
                            <tr class="">
                                <td>Phone:</td>
                                <td> {{ $employee->phone }}</td>
                            </tr>
                            <tr class="">
                                <td>Email:</td>
                                <td>
                                    @isset($employee->user)
                                        {{ $employee->user->email }}
                                    @else
                                        <i class="text-danger"> not set yet</i>
                                    @endisset
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card collapsed-card p-5">
                    <div class="d-flex justify-content-start">
                        <div class="h5"><strong>HR details</strong></div>
                    </div>
                    <hr>
                    <table>
                        <tr>
                            <th>Employee Number</th>
                            <td>{{ $employee->employee_no }}</td>
                        </tr>
                        <tr>
                            <th>Hire Date</th>
                            <td>{{ $employee->hiredate ? $employee->hiredate->format('j F, Y') : 'Not available' }}</td>
                        </tr>
                        <tr>
                            <th>Contract End Date</th>
                            <td>{{ $employee->contract_end_date ? $employee->contract_end_date->format('j F, Y') : 'Not available' }}</td>
                        </tr>
                        <tr>
                            <th>Contract Period</th>
                            <td>
                                @if(isset($contractDuration))
                                    {{ $contractDuration}}
                                @else
                                    Not available
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Birthdate (Age)</th>
                            <td>
                                @if($employee->birthdate)
                                    {{ Carbon::parse($employee->birthdate)->format('j F, Y') }}
                                    ({{ Carbon::parse($employee->birthdate)->age }} years)
                                @else
                                    Not available
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ $employee->gender }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card p-5">
                    <div class="d-flex justify-content-start">
                        <div class="h5"><strong>Payment structure</strong></div>
                    </div>
                    <hr>
                    <table>
                        <tr>
                            <th>Gross Salary</th>
                            <td>K{{ number_format($employee->salary, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Estimated Paye</th>
                            <td>K{{ number_format($estimatedPaye, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Net Salary</th>
                            <td>K{{ number_format($netSalary, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Insurance</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Other Earnings</th>
                            <td>K{{ number_format($employee->bonus) }}</td>
                        </tr>
                        <tr>
                            <th>Deductions</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Pension</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Benefits</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Estimated Total</th>
                            <td>K{{ number_format($estimatedTotal, 2) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card p-5">
                    <div class="d-flex justify-content-start">
                        <div class="h5"><strong>Payrolls</strong></div>
                    </div>
                    @include('/employees/includes/employeePayrollTable')
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-5">
                    Upcoming events
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
        $('#payrollsTable').DataTable({
            scrollX: true,
            scrollY: true,
        });
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
