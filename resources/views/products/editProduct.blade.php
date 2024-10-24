@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Edit products')

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
    <livewire:common.page-header pageTitle="Edit product"/>
    <div class="col-lg-12">

        @include('includes/error')
        @section('plugins.Select2', true)

            <form action="{{ route('update-product', $product) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
            <div class="card mb-3 p-4">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include('products.includes.productForm')
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                Save
            </button>
        </form>
    </div>
</div>
@stop

{{-- Create a common footer --}}

@include('/components/layouts/footer_bottom')

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script>

    $(document).ready(function() {
        $('#allPayrollsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
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
