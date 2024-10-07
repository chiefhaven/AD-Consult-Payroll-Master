@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Billing')

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
    <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Client Name</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Issue Date</th>
            <th>Due Date</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($billings as $billing)
        <tr>
            <td>{{ $billing->id }}</td>
            <td>{{ $billing->client->name }}</td>
            <td>{{ $billing->type->name }}</td> <!-- Assuming 'type' is a relationship -->
            <td>{{ $billing->amount }}</td>
            <td>{{ $billing->issue_date }}</td>
            <td>{{ $billing->due_date }}</td>
            <td>{{ $billing->description }}</td>
            <td>{{ $billing->status->name }}</td> <!-- Assuming 'status' is a relationship -->
            <td>
                <!-- Actions like edit, delete, etc. -->
                <a href="{{ route('billings.billingView', $billing->id) }}">View</a>
                <a href="{{ route('billings.billingEdit', $billing->id) }}">Edit</a>
                <form action="{{ route('billings.destroy', $billing->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
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
