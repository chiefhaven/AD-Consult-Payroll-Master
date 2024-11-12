@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Leave')

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
            @push('css')
                <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.min.css">
            @endpush
@stop

{{-- Rename section content to content_body --}}

@section('content')

<!-- Vue app container for Leave View component -->
<div id="app">
    <leave-view :initial-year="{{ $year }}" :initial-month="{{ $month }}"></leave-view>
</div>

<div class="row">

 <div class="row p-4">
    <div class="col-md-12">
        <h1>{{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</h1>
    </div>
</div>
</div>

<div class="row p-4">
    <div class="col-md-4">
        <!-- Total Requests Card -->
        <div class="card text-white bg-secondary mb-1">
            <div class="card-body">
                <h5 class="card-title">Total</h5>
                <p class="card-text">{{ $pendingRequests }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Approved Requests Card -->
        <div class="card text-white bg-secondary mb-1">
            <div class="card-body">
                <h5 class="card-title">Approved</h5>
                <p class="card-text">{{ $approvedRequests }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Disapproved Requests Card -->
        <div class="card text-white bg-secondary mb-1">
            <div class="card-body">
                <h5 class="card-title">Disapproved</h5>
                <p class="card-text">{{ $disapprovedRequests }}</p>
            </div>
        </div>
    </div>
    </div>


<div class="row p-4">
    <!-- Mass Approve and Disapprove Buttons -->
    <div class="col-md-12 mb-3">
        <form action="{{ route('api.massApprove', ['year' => $year, 'month' => $month]) }}" method="POST" style="display: inline;">
        {{-- <form action="{{ route('api.massApprove', ['uuid' => $uuid]) }}" method="POST" style="display: inline;"> --}}
            @csrf
            <button @click="massApprove" type="submit" class="btn btn-success">Mass Approve</button>
        </form>

        <form action="{{ route('api.massDisapprove', ['year' => $year, 'month' => $month]) }}" method="POST" style="display: inline;">
        {{-- <form action="{{ route('api.massDisapprove', ['uuid' => $uuid]) }}" method="POST" style="display: inline;"> --}}
            @csrf
            <button @click="massDisapprove" type="submit" class="btn btn-danger">Mass Disapprove</button>
        </form>
    </div>
</div>


<div class="row p-4 mt-1">

    <table id="myTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>First Name</th>
            <th>Surname Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Type </th>
            <th>Status </th>
            <th>Reason</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($leaves as $leave)
        <tr>

            <td>{{ $leave->employee_no }}</td>
            <td>{{ $leave->Name }}</td>
            <td>{{ $leave->Surname }}</td>
            <td>{{ $leave->start_date }}</td>
            <td></td>
            <td>{{ $leave->Type }}</td>
            <td>{{ $leave->Status }}</td>
            <td>{{ $leave->Reason }}</td>
            <td>
                {{-- <a href="{{ route('billingView', ['id' => $billing->id]) }}">View</a> --}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>



</div>
@stop

{{-- Create a common footer --}}

@include('/components/layouts/footer_bottom')

{{-- Add common Javascript/Jquery code --}}
 @push('js')
    <script src="https://cdn.datatables.net/2.1.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.min.js"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                autoWidth: false,
                responsive: true
                // paging: true,
                // search: true,
                // ordering: true,
                // info: true,
                // lengthChange: true,
                // pageLength: 10,
            });
        });
    </script>
@endpush

@push('js')
    <!-- Include Vue, Axios, and the main Vue component logic in app.js -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush

