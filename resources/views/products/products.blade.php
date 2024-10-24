@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Products')

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
<div class="row" id="products">
    <livewire:common.page-header pageTitle="All Products" buttonName="Add Product" link="/add-product"/>
    <div class="col-lg-12">
        <div class="card mb-3 p-4">
            <div class="box-body">
                <div class="row">
                        @include('/products/includes/allProductsTable')
                </div>
            </div>
        </div>

        @include('products.includes.viewProductModal')
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

        $('.delete-product-confirm').on('click', function (e) {
            e.preventDefault(); // Prevent default button behavior
            var form = $(this).closest('form'); // Get the closest form element
            Swal.fire({
                title: 'Delete Product',
                text: 'Do you want to delete this product? This action cannot be undone!',
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
    });
</script>
<script>
    const products = createApp({
        setup() {
            const showProductModal = ref(false);
            const loading = ref(false);    // Manage loading state
            const error = ref(null);
            const data = ref(null);        // Store product data
            const productData = ref(null);        // Store product data


            // Close the modal
            const closeProductModal = () => {
                data.value = null
                showProductModal.value = false;
            };

            // Open the payroll details modal and fetch payroll data
            const fetchProductDetails = (product) => {
                showProductModal.value = true;
                fetchData(product);  // Fetch data when the modal opens
            };

            // Fetch Payroll details
            const fetchData = async (product) => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/view-product/${product}`);
                    if (response.data) {
                        data.value = response.data;  // Directly assign the product object
                    } else {
                        error.value = "No data found for the provided product ID.";
                    }
                } catch (err) {
                    error.value = "Failed to fetch payroll data";
                } finally {
                    loading.value = false;
                }
            };

            const formatCurrency = (value) => {
                return `K ${Number(value).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            };

            return {
                showProductModal,
                fetchProductDetails,
                closeProductModal,
                data,
                productData,
                loading,
                error,
                formatCurrency,
            };
        }
    });
    products.mount('#products');

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
