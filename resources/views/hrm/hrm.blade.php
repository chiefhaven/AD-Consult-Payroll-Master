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
    <div class="col-lg-12 pt-5">
        <div class="card mb-3 p-4">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
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
        $('#clientsTable').DataTable({
            dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ],
            scrollX: true,
            scrollY: true,
        });
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
                toggleView(fetchDesignations, showDesignations);
            };

            const getLeaveTypes = () => {
                toggleView(fetchLeaveTypes, showLeaveTypes);
            };

            const getHolidays = () => {
                toggleView(fetchHolidays, showHolidays);
            };

            const getAttendances = () => {
                toggleView(fetchAttendances, showAttendances);
            };

            const getLeaves = () => {
                toggleView(fetchLeaves, showLeaves);
            };

            const getSettings = () => {
                toggleView(fetchSettings, showSettings);
            };

            // Fetch functions (already implemented)
            const fetchDesignations = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/hrm/designations`);
                    designations.value = response.data.length > 0 ? response.data : [];
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

            // Additional fetch functions for holidays, attendances, leaves, and settings...


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
                getSettings
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
