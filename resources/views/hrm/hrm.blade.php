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
                            <button class="nav-link btn btn-link" @click="getLeave()">Leaves</button>
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
                        @include('hrm.leaveTypes')
                        @include('hrm.designations')
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
            const showLeaveTypes = ref(false);
            const designations = ref([]);
            const leaveTypes = ref([]);
            const loading = ref(false);
            const error = ref(null);

            onMounted(() => {
                showLeaveTypes.value = false;
                showDesignations.value = false;
                getDesignations();
            });

            // Toggle function to show designations
            const getDesignations = () => {
                showLeaveTypes.value = false;
                showDesignations.value = true;
                fetchDesignations()
            };

            // Toggle function to show leave types (if needed)
            const getLeaveTypes = () => {
                showDesignations.value = false;
                showLeaveTypes.value = true;
                fetchLeaveTypes()
            };

            const fetchDesignations = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/hrm/designations`);
                    if (response.data && response.data.length > 0) {
                        designations.value = response.data;

                    } else {
                        error.value = "No data found.";
                    }
                } catch (err) {
                    error.value = "Failed to fetch payroll data";
                } finally {
                    loading.value = false;
                }
            };

            const fetchLeaveTypes = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/hrm/leave-types`);
                    if (response.data && response.data.length > 0) {
                        leaveTypes.value = response.data;

                    } else {
                        error.value = "No data found.";
                    }
                } catch (err) {
                    error.value = "Failed to fetch data";
                } finally {
                    loading.value = false;
                }
            };

            const fetchLeaves = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/hrm/leave`);
                    if (response.data && response.data.length > 0) {
                        leave.value = response.data;

                    } else {
                        error.value = "No data found.";
                    }
                } catch (err) {
                    error.value = "Failed to fetch data";
                } finally {
                    loading.value = false;
                }
            };

            return {
                showDesignations,
                showLeaveTypes,
                designations,
                getDesignations,
                leaveTypes,
                getLeaveTypes,
                loading,
                error
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
