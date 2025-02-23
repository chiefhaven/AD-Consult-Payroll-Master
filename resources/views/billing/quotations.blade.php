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
    <livewire:common.page-header pageTitle="Quotations" buttonName="Add" link="add-sale"/>
    <div class="col-lg-12">
        <div class="card mb-3 p-4">
            <h4 class="pb-4">All quotations</h4>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('/billing/includes/quotationsTable')
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
        $('.delete-bill-confirm').on('click', function (e) {
            e.preventDefault(); // Prevent default button behavior
            var form = $(this).closest('form'); // Get the closest form element
            Swal.fire({
                title: 'Delete Bill',
                text: 'Do you want to delete this bill? This action cannot be undone!',
                icon: 'warning', // Use warning icon
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });


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
