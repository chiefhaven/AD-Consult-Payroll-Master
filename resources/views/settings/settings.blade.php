@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Settings')

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

@section('plugins.Nprogress', true)

{{-- Rename section content to content_body --}}

@section('content')
<div class="row" id="settings" v-cloak>
    <div class="col-md-12 pt-3">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Settings</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <button class="nav-link btn btn-link" @click="getBusinessInfo()">Business information</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link btn btn-link" @click="getInvoiceSettings()">Invoice settings</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link btn btn-link" @click="getEmailSettings()">Email configration</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link btn btn-link" @click="getSmsSettings()">SMS configuration</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="col-md-12 pt-3">
        @include('settings.partials.settingsHeader')
    </div>

    <div class="col-lg-12">
        <div class="card mb-3 p-4">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('settings.partials.invoiceSettings')
                        @include('settings.partials.emailSettings')
                        @include('settings.partials.smsSettings')
                        @include('settings.partials.businessInfo')
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

    const settings = createApp({
        setup() {
            const data = ref([]);
            const pageTitle = ref("Page Title");
            const buttonName = ref("Click Here");
            const link = ref("/default-link");
            const showBusinessInfo = ref(false);
            const showInvoiceSettings = ref(false);
            const showEmailSettings = ref(false);
            const showSmsSettings = ref(false);
            const loading = ref(false);
            const error = ref(false);

            const state = ref({
                name: '',
                description: '',
                modalTitle:'',
                buttonName:'Add',
                modalFunction:'',
                date:'',
                recurring: true,
            });

            const businessForm = ref({
                business_name: "",
                street_address: "",
                street_address_2: "",
                district: "",
                province_or_region: "",
                country: "",
                business_email: "",
                business_phone: "",
                alt_phone_number: "",
                business_website: "",
                registration_number: "",
                tax_id: "",
            });

            const form = ref({
                prefix: '',
                startNumber: 1,
                taxRate: 0,
                terms: '',
                header: '',
                footer: '',
                seperator: '-',
                invoiceNumberIncludeClientName: true,
                invoiceNumberIncludeYear: true,
            })

            const emailForm = ref({
                mail_host: '',
                mail_port: null,
                mail_username: '',
                mail_password: null,
                mail_encryption: '',
                mail_from_address: '',
                mail_from_name: '',
            })

            const smsForm = ref({
                sms_gateway: "",
                sms_api_key: "",
                sms_api_secret: "",
                sms_sender_id: "",
                sms_country_code: "",
                sms_message_type: "",
            })

            const initializeDatePicker = () => {
                $(state.value.datePickerInput).datepicker({
                    format: "MM yyyy",
                    viewMode: "months",
                    minViewMode: "months",
                    autoclose: true,
                }).on('changeDate', function(e) {
                    // Update the Vue state when a date is selected
                    state.value.date = $(this).datepicker('getFormattedDate');
                });
            };

            onMounted(() => {
                fetchBusinessInfo(); // Default behavior on mount
                toggleView(getBusinessInfo, showBusinessInfo);
            });

            // Generic toggle function to handle showing sections
            const toggleView = (fetchFunction, showVar, title = "") => {
                // Reset all views (assuming showBusinessInfo, showInvoiceSettings, etc. are refs)
                resetViews();

                // Set the current view
                showVar.value = true;

                // Update page title if provided
                if (title) {
                    pageTitle.value = title;
                }

                // Fetch data
                fetchFunction();
            };

            const resetViews = () => {
                showBusinessInfo.value = false;
                showInvoiceSettings.value = false;
                showEmailSettings.value = false;
                showSmsSettings.value = false;
            };

            const getBusinessInfo = () => {
                NProgress.start();

                resetViews()
                pageTitle.value = "Business Information";
                showBusinessInfo.value = true;

                NProgress.done();
            };

            const getInvoiceSettings = () => {
                NProgress.start();

                resetViews()
                pageTitle.value = "Invoice Settings";
                showInvoiceSettings.value = true;
                fetchInvoiceSettings();
                NProgress.done();
            };

            const getEmailSettings = () => {
                NProgress.start();

                resetViews();
                pageTitle.value = "Email Settings";
                showEmailSettings.value = true;
                fetchEmailSettings();
                NProgress.done();
            };

            const getSmsSettings = () => {
                NProgress.start();

                resetViews()
                pageTitle.value = "SMS Settings";
                showSmsSettings.value = true;

                NProgress.done();
            };

            const fetchBusinessInfo = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/settings/business-info`);
                    data.value = response.data ? response.data : [];

                    if (response.data) {
                        Object.assign(businessForm.value, response.data);
                    }
                    console.log(data.value)

                } catch (err) {
                    error.value = "Failed to fetch business information.";
                } finally {
                    loading.value = false;
                    NProgress.done();

                }
            };

            // Function to initialize DataTable after Vue has rendered the table
            const initializeDataTable = () => {
                setTimeout(() => {
                    $('#designationsTable, #leaveTypesTable, #leavesTable, #attendancesTable').DataTable({
                        dom: 'Bfrtip',
                        buttons: ['copy', 'excel', 'pdf', 'print'],
                        scrollX: true,
                        scrollY: true,
                    });
                }, 0); // Timeout ensures the DOM is ready
            };

            const confirmDelete = async(designationId) => {
                Swal.fire({
                    title: 'Delete Designation?',
                    text: 'Do you want to delete this designation? This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteDesignation(designationId);
                    }
                });
            };

            // Helper function to reset form values
            const resetForm = () => {
                state.value = {
                    name: '',
                    description: '',
                    date: '',
                    recurring: false,
                    holiday_type: '',
                    buttonName: 'Save',
                    holidayId: null, };
            };

            const openForm = async(name, title, type) => {
                state.value = {
                    buttonName: name,
                    modalTitle: name,
                    designationId: null,
                    leaveTypeId: null,
                    holidayId: null,
                };

                if(type === 'Designations'){
                    showAddDesignationModal.value = true;
                }
                else if(type === 'Leave types'){
                    showAddLeaveTypeModal.value = true;
                }
                else if(type === 'Holidays'){
                    showAddHolidayModal.value = true;
                }
            }

            const closeForm = async() => {
                showAddDesignationModal.value = false;
                showAddLeaveTypeModal.value = false;
                showAddHolidayModal.value = false;
            }

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

            const submitForm = async () => {
                try {

                    // Post the form data to the endpoint
                    const response = await axios.post('/save-settings', form);

                    // Handle successful response
                    console.log('Settings saved successfully:', response.data);

                    // Show success notification if needed
                    alert('Settings saved successfully!');
                } catch (err) {
                    // Handle errors
                    console.error('Error saving settings:', err);
                    error.value = 'Failed to save settings. Please try again.';
                }
            };

            const submitInvoiceForm = async () => {
                try {
                    const response = await axios.post('/update-invoice-settings', form.value);

                    // Check response status
                    if (response.status === 200) {
                        console.log(response)
                        notification('Settings saved successfully', 'success');
                    } else {
                        notification('Unexpected response from the server.', 'warning');
                    }
                } catch (err) {
                    console.error('Error saving settings:', err);
                    error.value = 'Failed to save settings. Please try again.';
                    notification(error.value, 'error');
                }
            };

            // Function to fetch email settings
            const fetchEmailSettings = async () => {
                loading.value = true;
                error.value = null;

                try {
                const response = await axios.get('/email-settings');
                    if (response.data) {
                        // Populate form with fetched data
                        Object.assign(emailForm.value, response.data);
                    }
                    console.log(emailForm.value);
                } catch (err) {
                error.value = 'Failed to fetch email settings.';
                console.error('Fetch Error:', err.response?.data || err.message);
                // Assuming you have a notification function in place
                notification(error.value, 'error');
                } finally {
                loading.value = false;
                NProgress.done();
                }
            };

            const fetchInvoiceSettings = async () => {
                loading.value = true;
                error.value = null;

                try {
                    const response = await axios.get(`/invoice-settings`);

                    // Populate the form with the response data
                    if (response.data) {
                        Object.assign(form.value, response.data);
                    }

                    console.log(form.value);

                } catch (err) {
                    // Display error message
                    error.value = "Failed to fetch invoice settings.";
                    console.error('Fetch Error:', err.response?.data || err.message);

                    // Optionally display a user notification
                    notification(error.value, 'error');
                } finally {
                    loading.value = false;
                    NProgress.done();
                }
            };

            const submitEmailForm = async () => {
                try {
                    const response = await axios.post('/update-email-settings', emailForm.value);

                    // Check response status
                    if (response.status === 200) {
                        console.log(response)
                        notification('Settings saved successfully', 'success');
                    } else {
                        notification('Unexpected response from the server.', 'warning');
                    }
                } catch (err) {
                    console.error('Error saving settings:', err);
                    error.value = 'Failed to save settings. Please try again.';
                    notification(error.value, 'error');
                }
            }

            const submitSmsForm = async () => {
                try {
                    this.loading = true;
                    this.error = null;

                    // Submit logic (e.g., API call)
                    console.log("SMS Configuration:", this.smsForm);

                    // Example success message
                    alert("SMS Configuration saved successfully!");
                } catch (err) {
                    this.error = "Failed to save SMS configuration.";
                } finally {
                    this.loading = false;
                }
            };

            const submitBusinessInfo = async () => {
                try {
                    this.loading = true;
                    this.error = null;

                    // Example submission logic
                    console.log("Business Information:", this.businessForm);

                    // Example success message
                    alert("Business Information saved successfully!");
                } catch (err) {
                    this.error = "Failed to save business information.";
                } finally {
                    this.loading = false;
                }
            };

            return {

                getBusinessInfo,
                getInvoiceSettings,
                getEmailSettings,
                getSmsSettings,
                pageTitle,
                link,
                buttonName,
                openForm,
                state,
                showBusinessInfo,
                data,
                loading,
                error,
                showInvoiceSettings,
                submitForm,
                form,
                showEmailSettings,
                submitEmailForm,
                submitInvoiceForm,
                emailForm,
                showSmsSettings,
                submitSmsForm,
                smsForm,
                businessForm,
                submitBusinessInfo
            };

        }

    });
    settings.mount('#settings')

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
