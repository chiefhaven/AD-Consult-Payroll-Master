@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'HRM')

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
<div class="row" id="hrm">
    <div class="col-md-12 pt-3">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">HRM</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <button class="nav-link btn btn-link" @click="getDesignations()">Designations</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link btn btn-link" @click="getLeaveTypes()">Leave Types</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link btn btn-link" @click="getLeaves()">Leaves</button> <!-- Corrected from getLeave -->
                        </li>
                        <li class="nav-item">
                            <button class="nav-link btn btn-link" @click="getHolidays()">Holidays</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link btn btn-link" @click="getAttendances()">Attendances</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link btn btn-link" @click="getSettings()">Settings</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="col-md-12 pt-3">
        @include('hrm.partials.hrmHeader')
    </div>

    <div class="col-lg-12">
        <div class="card mb-3 p-4">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div v-if="buttonName" class="col-sm-12 d-flex justify-content-end pb-5">
                            <button class="btn btn-default" @click="openForm()">
                                @{{ buttonName }}
                            </button>
                        </div>
                        @include('hrm.partials.leaveTypes')
                        @include('hrm.partials.designations')
                        @include('hrm.partials.holidays')
                        @include('hrm.partials.leaves')
                        @include('hrm.partials.settings')
                        @include('hrm.partials.attendances')
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

    });

    const hrm = createApp({
        setup() {
            const showDesignations = ref(false);
            const showLeaves = ref(false);
            const showSettings = ref(false);
            const showAttendances = ref(false);
            const showHolidays = ref(false);
            const showLeaveTypes = ref(false);
            const designations = ref([]);
            const leaveTypes = ref([]);
            const leaves = ref([]);
            const holidays = ref([]);
            const attendances = ref([]);
            const settings = ref([]);
            const loading = ref(false);
            const error = ref(null);
            const pageTitle = ref("Page Title");
            const buttonName = ref("Click Here");
            const link = ref("/default-link");
            const showAddDesignationModal = ref(false);
            const state = ref({
                name: '',
                description: '',
                modalTitle:'',
                buttonName:'Add',
                modalFunction:'',
                designationId: null,
            });

            onMounted(() => {
                getDesignations(); // Default behavior on mount
            });

            // Generic toggle function to handle showing sections
            const toggleView = (fetchFunction, showVar) => {
                // Reset visibility for all sections
                showLeaveTypes.value = false;
                showDesignations.value = false;
                showLeaves.value = false;
                showSettings.value = false;
                showAttendances.value = false;
                showHolidays.value = false;

                // Set the current view
                showVar.value = true;

                // Fetch data
                fetchFunction();
            };

            // Example usage for fetching and displaying different sections
            const getDesignations = () => {
                link.value = "add-designation"
                buttonName.value = "Add designation"
                pageTitle.value = "Designations"
                toggleView(fetchDesignations, showDesignations);
            };

            const getLeaveTypes = () => {
                link.value = "add-leave-type"
                buttonName.value = "Add leave type"
                pageTitle.value = "Leave types"
                toggleView(fetchLeaveTypes, showLeaveTypes);
            };

            const getHolidays = () => {
                link.value = "add-holidays"
                buttonName.value = "Add holiday"
                pageTitle.value = "Holidays"
                toggleView(fetchHolidays, showHolidays);
            };

            const getAttendances = () => {
                link.value = null
                buttonName.value = null
                pageTitle.value = "Attendances"
                toggleView(fetchAttendances, showAttendances);
            };

            const getLeaves = () => {
                link.value = null
                buttonName.value = null
                pageTitle.value = "Leaves"
                toggleView(fetchLeaves, showLeaves);
            };

            const getSettings = () => {
                link.value = null
                buttonName.value = null
                pageTitle.value = "Settings"
                toggleView(fetchSettings, showSettings);
            };

            // Fetch functions (already implemented)
            const fetchDesignations = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/hrm/designations`);
                    designations.value = response.data.length > 0 ? response.data : [];
                    initializeDataTable();
                    console.log(designations.value);
                } catch (err) {
                    error.value = "Failed to fetch designations.";
                } finally {
                    loading.value = false;
                }
            };

            const fetchLeaveTypes = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/hrm/leave-types`);
                    leaveTypes.value = response.data.length > 0 ? response.data : [];
                } catch (err) {
                    error.value = "Failed to fetch leave types.";
                } finally {
                    loading.value = false;
                }
            };

            const fetchHolidays = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/hrm/holidays`);
                    holidays.value = response.data.length > 0 ? response.data : [];
                } catch (err) {
                    error.value = "Failed to fetch holidays.";
                } finally {
                    loading.value = false;
                }
            };

            const fetchAttendances = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/hrm/attendances`);
                    attendances.value = response.data.length > 0 ? response.data : [];
                } catch (err) {
                    error.value = "Failed to fetch attendances.";
                } finally {
                    loading.value = false;
                }
            };

            const fetchLeaves = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/hrm/leaves`);
                    leaves.value = response.data.length > 0 ? response.data : [];
                } catch (err) {
                    error.value = "Failed to fetch leaves.";
                } finally {
                    loading.value = false;
                }
            };

            const fetchSettings = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/hrm/settings`);
                    settings.value = response.data.length > 0 ? response.data : [];
                } catch (err) {
                    error.value = "Failed to fetch settings.";
                } finally {
                    loading.value = false;
                }
            };

            // Function to initialize DataTable after Vue has rendered the table
            const initializeDataTable = () => {
                setTimeout(() => {
                    $('#designationsTable').DataTable({
                        dom: 'Bfrtip',
                        buttons: ['copy', 'excel', 'pdf', 'print'],
                        scrollX: true,
                        scrollY: true,
                    });
                }, 0); // Timeout ensures the DOM is ready
            };

            const addDesignation = async (designation) => {
                try {
                    if (designation === null) {
                        const response = await axios.post('/storeDesignation', {
                            name: state.value.name,
                            description: state.value.description,
                        });

                        if (response.status === 200) {
                            notification('Designation added successfully', 'success');
                            getDesignations();
                            state.value = { name: '', description: '', buttonName:'Save', designationId: null  }; // Reset the form
                        }
                    }
                    if(designation !== null) {
                        const response = await axios.post(`/updateDesignation/${designation}`, {
                            name: state.value.name,
                            description: state.value.description,
                        });

                        if (response.status === 200) {
                            notification('Designation updated successfully', 'success');
                            getDesignations();
                            state.value = { name: '', description: '', buttonName:'Update', }; // Reset the form
                            showAddDesignationModal.value = false;
                        }
                    }
                } catch (error) {
                    if (error.response && error.response.status === 422) {
                        const errorMessage = error.response.data.message || 'An error occurred';
                        notification(errorMessage, 'error');
                    } else {
                        notification('An unexpected error occurred', 'error');
                    }
                }
            };

            const deleteDesignation = async (designation) => {
                loading.value = true;

                try {
                    const response = await axios.delete(`/deleteDesignation/${designation}`, {});

                    if (response.status === 200) {
                        notification('Designation deleted successfully', 'success');
                        getDesignations();
                    }
                } catch (error) {
                    const errorMessage = error.response.data.message || 'An unexpected error occurred';
                    notification(errorMessage, 'error');
                } finally {
                    loading.value = false;
                }
            };

            const openForm = async() => {
                state.value = {
                    buttonName:'Save',
                    modalTitle:'Add designation',
                    designationId: null,

                };
                showAddDesignationModal.value = true;
            }

            const editDesignation = async(designation) => {
                state.value = {
                    name: designation.name,
                    description: designation.description,
                    buttonName:'Update',
                    modalTitle:'Edit designation',
                    designationId: designation.id,
                };

                showAddDesignationModal.value = true;
            }

            const designationDetails = async() => {
                state.value = {
                    name: '', description: ''
                }
                showAddDesignationModal.value = false;
            }

            const closeDesignationForm = async() => {
                showAddDesignationModal.value = false;
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

            return {
                showDesignations,
                showLeaveTypes,
                showLeaves,
                showHolidays,
                showAttendances,
                showSettings,
                designations,
                leaveTypes,
                leaves,
                holidays,
                attendances,
                settings,
                loading,
                error,
                getDesignations,
                getLeaveTypes,
                getLeaves,
                getHolidays,
                getAttendances,
                getSettings,
                pageTitle,
                link,
                buttonName,
                addDesignation,
                showAddDesignationModal,
                openForm,
                closeDesignationForm,
                state,
                deleteDesignation,
                editDesignation,
                designationDetails
            };

        }

    });

    hrm.mount('#hrm')

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
