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
    <livewire:common.page-header pageTitle="Sales" buttonName="Add Sale" link="add-sale"/>
    <div class="col-lg-12" id="sales">
        <div class="card mb-3 p-4">
            <h4 class="pb-4">All sales</h4>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('/billing/includes/invoicesTable')

                        @include('billing/includes/viewBillModal')

                        @include('billing/includes/addPaymentModal')
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

    const sales = createApp({
        setup() {
            // Reactive references
            const billData = ref();
            const showBillModal = ref(false);
            const showAddPaymentModal = ref(false);
            const state = ref({
                notes: '',
                payment_method: '',
                amountToPay: 0,
                paidAmount: 0,
                chequeAccountNumber: '',
                payment_date: new Date().toISOString().split('T')[0],
            })


            const confirmBillDelete = async(billId) => {
                Swal.fire({
                    title: 'Delete bill?',
                    text: 'Do you want to delete this bill? This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteBill(billId);
                    }
                });
            };

            const formatCurrency = (value) => {
                return `K ${Number(value).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            };

            const formatDate = (date) => {
                if (!date) return '';
                return new Intl.DateTimeFormat('en-US', {
                  year: 'numeric',
                  month: 'long',
                  day: 'numeric',
                }).format(new Date(date));
            };

            const deleteBill = async (bill) => {
                NProgress.start();

                try {
                    const response = await axios.delete(`/delete-bill/${bill}`);

                    if (response.status === 200) {
                        notification('Bill deleted successfully', 'success');
                        window.location.reload();
                    }
                } catch (error) {
                    const errorMessage = error.response.data.message || 'An unexpected error occurred';
                    notification(errorMessage, 'error');
                } finally {
                    NProgress.done();
                }
            };

            const viewBill = async(bill) => {

                NProgress.start();
                try {
                    const response = await axios.get(`/view-bill/${bill}`);
                    console.log(response)
                    if (response.data) {
                        billData.value = response.data;
                        showBillModal.value = true;

                    } else {
                        notification('No data found.', 'error');
                    }
                } catch (err) {
                    notification('Failed to fetch data', 'error');
                } finally {
                    NProgress.done();
                }
            }

            const addPayment = async(bill) => {
                NProgress.start();
                try {
                    const response = await axios.get(`/view-bill/${bill}`);
                    console.log(response)
                    if (response.data) {
                        billData.value = response.data;
                        showAddPaymentModal.value = true;
                    } else {
                        notification('Shit happened.', 'error');
                    }
                } catch (err) {
                    notification('Failed to fetch data', 'error');
                } finally {
                    NProgress.done();
                }
            }

            const savePayment = async (bill) => {
                NProgress.start();
                try {
                    const response = await axios.post(`/store-payment`, {
                        bill: bill,
                        state: state.value
                    });

                    console.log(response);

                    if (response.data) {
                        state.value = {
                            notes: '',
                            payment_method: '',
                            amountToPay: 0,
                            paidAmount: 0,
                            chequeAccountNumber: '',
                        };

                        showAddPaymentModal.value = false;
                        notification('Bill updated successfully', 'success');
                        window.location.reload();

                    } else {
                        notification('No data found.', 'error');
                    }
                } catch (err) {
                    notification(erro, 'error');
                    console.error(err); // Log the error for debugging
                } finally {
                    NProgress.done();
                }
            };


            // Fetch Payroll details
            const fetchData = async (payroll) => {

            };

            const closeForm = async() =>{
                showBillModal.value = false;
                showAddPaymentModal.value = false;
            }

            onMounted(() => {

            });

            const totalAmount = computed(() => {
                if (Array.isArray(billData.value.products) && billData.value.products.length > 0) {
                  // Sum up the total from each product's pivot data
                  return billData.value.products.reduce((sum, product) => {
                    // Convert `total` to a number to ensure arithmetic operation
                    return sum + (parseFloat(product.pivot.price*product.pivot.quantity) || 0);
                  }, 0);
                } else {
                  console.warn("No products found");
                  return 0;
                }
            });

            const totalTax = computed(() => {
                // Check if products array exists and has items
                if (Array.isArray(billData.value.products) && billData.value.products.length > 0) {
                    // Sum up the tax from each product's pivot data
                    return billData.value.products.reduce((sum, product) => {
                    // Convert `tax` to a number to ensure arithmetic operation
                    return sum + (parseFloat(product.pivot.tax) || 0);
                    }, 0);
                } else {
                    console.warn("No products found in billData.");
                    return 0;
                }
            });

            const totalDiscount = computed(() => {
                // Check if products array exists and has items
                if (Array.isArray(billData.value.products) && billData.value.products.length > 0) {
                  // Sum up the discount from each product's pivot data
                  return billData.value.products.reduce((sum, product) => {
                    // Convert `item_discount` to a number to ensure arithmetic operation
                    return sum + (parseFloat(product.pivot.item_discount) || 0);
                  }, 0);
                } else {
                  console.warn("No products found");
                  return 0;
                }
            });

            const balance = computed(() => {
                return totalPayable.value - state.value.amountToPay;
            });

            const totalPayable = computed(() => {
                if (Array.isArray(billData.value.products) && billData.value.products.length > 0) {

                    const totalPayment = billData.value.payments.reduce((sum, payment) => sum + parseFloat(payment.payment_amount), 0);

                    console.log(totalPayment);
                    // Calculate subtotal by summing all product totals
                    const subtotal = billData.value.products.reduce((sum, product) => {
                        return sum + (parseFloat(product.pivot.price*product.pivot.quantity) || 0);
                    }, 0);

                    // Calculate total discount
                    const totalDiscount = billData.value.products.reduce((sum, product) => {
                        return sum + (parseFloat(product.pivot.item_discount) || 0);
                    }, 0);

                    // Calculate total tax
                    const totalTax = billData.value.products.reduce((sum, product) => {
                        return sum + (parseFloat(product.pivot.tax) || 0);
                    }, 0);

                    // Calculate total payable: (Subtotal - Discount) + Tax
                    return subtotal - totalDiscount + totalTax - totalPayment;
                } else {
                    console.warn("No products found");
                    return 0;
                }
            });

            const totalPayments = computed(() => {
                if (Array.isArray(billData.value.payments) && billData.value.payments.length > 0) {
                  // Calculate total payments by summing up all payment amounts
                  return billData.value.payments.reduce((sum, payment) => {
                    return sum + (parseFloat(payment.payment_amount) || 0);
                  }, 0);
                } else {
                  return 0;
                }
              });

            const notification = ($text, $icon) =>{
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    html: $text,
                    showConfirmButton: false,
                    timer: 5500,
                    timerProgressBar: true,
                    icon: $icon,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                      }
                  });
            }

            // Helper function to calculate the due date with flexible terms units
            const calculateDueDate = (billingDate, paymentTerms, termsUnit) => {
                const billingDateObj = new Date(billingDate);

                if (termsUnit === 'Months') {
                    // Add months to the date
                    billingDateObj.setMonth(billingDateObj.getMonth() + paymentTerms);
                } else {
                    // Default to days if not 'months'
                    billingDateObj.setDate(billingDateObj.getDate() + paymentTerms);
                }

                return formatDate(billingDateObj);
            };

            const printBill = async (bill, action) => {
                NProgress.start();

                try {
                    // Open the download route in a new window
                    window.open(`/print-bill/${bill}/${action}`, '_blank');

                } catch (err) {
                    error.value = "Failed to fetch data";
                } finally {
                    NProgress.done();
                }
            };

            return {
                confirmBillDelete,
                billData,
                printBill,
                viewBill,
                showBillModal,
                closeForm,
                formatCurrency,
                totalAmount,
                totalTax,
                totalDiscount,
                totalPayable,
                totalPayments,
                balance,
                formatDate,
                calculateDueDate,
                addPayment,
                showAddPaymentModal,
                state,
                savePayment,
            };
        }
    });

    sales.mount('#sales');

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
