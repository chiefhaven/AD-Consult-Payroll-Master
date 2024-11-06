{{-- @extends('adminlte::page')

{{-- Extend and customize the browser title --}}

{{-- @section('title', 'Leave') --}}

{{-- Extend and customize the page content header --}}
{{--
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

@stop --}}

{{-- Rename section content to content_body --}}

{{-- @section('content')

<div class="row p-2">

        <button type="button" class="btn"> <a href="{{ route('leave', ['year' => $year - 1]) }}">Previous Year ({{ $year - 1 }})</a> </button>
        <button type="button" class="btn"> <a href="{{ route('leave', ['year' => $year + 1]) }}">Next Year ({{ $year + 1 }})</a></button>
</div>

<div class="row ">

    <table id="myTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Month</th>
            <th>Total Requests</th>
        </tr>
    </thead>
    <tbody>
         @foreach($monthlyRequests as $month => $totalRequests)
                <tr onclick="window.location='{{ route('leaveView', ['year' => $year, 'month' => $month]) }}'" style="cursor: pointer;">
                    <td>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</td> <!-- Get month name from the number -->
                    <td>{{ $totalRequests }}</td>
                </tr>
            @endforeach
    </tbody>
</table>
</div> --}}

{{-- @push('js')
    <script src="https://cdn.datatables.net/2.1.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.min.js"></script>
@endpush --}}
{{--
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
@endpush --}}


{{-- @stop

 --}} 
