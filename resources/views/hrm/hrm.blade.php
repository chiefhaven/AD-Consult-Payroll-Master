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
<div class="row" id="hrm" v-cloak>
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
                            <button class="nav-link btn btn-link" @click="getLeaves()">Leaves</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link btn btn-link" @click="getHolidays()">Holidays</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link btn btn-link" @click="getAttendances()">Attendances</button>
                        </li>
                        {{--  <li class="nav-item">
                            <button class="nav-link btn btn-link" @click="getSettings()">Settings</button>
                        </li>  --}}
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
                            <button class="btn btn-default" @click="openForm(buttonName, modalTitle, pageTitle)">
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
            const showAddLeaveTypeModal = ref(false);
            const showAddHolidayModal = ref(false);
            const leaveId = ref('');

            const state = ref({
                name: '',
                description: '',
                modalTitle:'',
                buttonName:'Add',
                modalFunction:'',
                designationId: null,
                leaveTypeId: null,
                leaveHolidayId: null,
                date:'',
                recurring: true,
            });

            onMounted(() => {
                getDesignations(); // Default behavior on mount

                $("#date").datepicker({
                    format: "dd MM yyyy",
                    autoclose: true
                }).on("changeDate", (e) => {
                    // Update Vue model when date changes
                    state.value.date = e.format(); // Adjust according to the datepicker's output format
                });

            });

            onBeforeUnmount(() => {
                $("#date").datepicker('destroy'); // Clean up on component unmount
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

            const getDesignations = () => {
                NProgress.start();

                link.value = "add-designation"
                buttonName.value = "Add designation"
                pageTitle.value = "Designations"
                toggleView(fetchDesignations, showDesignations);
            };

            const getLeaveTypes = () => {
                NProgress.start();

                link.value = "add-leave-type"
                buttonName.value = "Add leave type"
                pageTitle.value = "Leave types"
                toggleView(fetchLeaveTypes, showLeaveTypes);
            };

            const getHolidays = () => {
                NProgress.start();

                link.value = "add-holidays"
                buttonName.value = "Add holiday"
                pageTitle.value = "Holidays"
                toggleView(fetchHolidays, showHolidays);
            };

            const getAttendances = () => {
                NProgress.start();
                link.value = null
                buttonName.value = null
                pageTitle.value = "Attendances"
                toggleView(fetchAttendances, showAttendances);
            };

            const getLeaves = () => {
                NProgress.start();

                link.value = null
                buttonName.value = null
                pageTitle.value = "Leaves"
                toggleView(fetchLeaves, showLeaves);
            };

            const getSettings = () => {
                NProgress.start();

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
                } catch (err) {
                    error.value = "Failed to fetch designations.";
                } finally {
                    loading.value = false;
                    NProgress.done();
                }
            };

            const fetchLeaveTypes = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/hrm/leave-types`);
                    leaveTypes.value = response.data.length > 0 ? response.data : [];
                    initializeDataTable();
                } catch (err) {
                    error.value = "Failed to fetch leave types.";
                } finally {
                    loading.value = false;
                    NProgress.done();
                }
            };

            const fetchHolidays = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/holidays`);
                    holidays.value = response.data.length > 0 ? response.data : [];
                    initializeDataTable();
                } catch (err) {
                    error.value = "Failed to fetch holidays.";
                } finally {
                    loading.value = false;
                    NProgress.done();
                }
            };

            const fetchAttendances = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/attendances`);
                    attendances.value = response.data.length > 0 ? response.data : [];
                    initializeDataTable();
                } catch (err) {
                    error.value = "Failed to fetch attendances.";
                } finally {
                    loading.value = false;
                    NProgress.done();
                }
            };

            const fetchLeaves = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/hrm/leaves`);
                    leaves.value = response.data.length > 0 ? response.data : [];
                    initializeDataTable();
                } catch (err) {
                    error.value = "Failed to fetch leaves.";
                } finally {
                    loading.value = false;
                    NProgress.done();
                }
            };

            const fetchSettings = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/hrm/settings`);
                    settings.value = response.data.length > 0 ? response.data : [];
                    initializeDataTable();
                } catch (err) {
                    error.value = "Failed to fetch settings.";
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

            const addLeaveType = async (leavetype) => {
                NProgress.start();

                try {
                    if (leavetype === null) {
                        const response = await axios.post('/storeLeaveType', {
                            name: state.value.name,
                            description: state.value.description,
                        });

                        if (response.status === 200) {
                            notification('Leave type added successfully', 'success');
                            getLeaveTypes();
                            state.value = { name: '', description: '', buttonName:'Save', leavetypeId: null  }; // Reset the form
                        }
                    }
                    if(leavetype !== null) {
                        const response = await axios.post(`/updateLeaveType/${leavetype}`, {
                            name: state.value.name,
                            description: state.value.description,
                        });

                        if (response.status === 200) {
                            notification('Leave type updated successfully', 'success');
                            getLeaveType();
                            state.value = { name: '', description: '', buttonName:'Update', }; // Reset the form
                            showAddLeaveTypeModal.value = false;
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
                finally{
                    NProgress.done();
                }
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

            const addLeave = async (leave) => {
                NProgress.start();

                try {
                    if (leave === null) {
                        const response = await axios.post('/storeLeave', {
                            name: state.value.name,
                            description: state.value.description,
                        });

                        if (response.status === 200) {
                            notification('Leave type added successfully', 'success');
                            getLeaves();
                            state.value = { name: '', description: '', buttonName:'Save', leaveId: null  }; // Reset the form
                        }
                    }
                    if(leave !== null) {
                        const response = await axios.post(`/updateLeave/${leave}`, {
                            name: state.value.name,
                            description: state.value.description,
                        });

                        if (response.status === 200) {
                            notification('Leave type updated successfully', 'success');
                            getLeave();
                            state.value = { name: '', description: '', buttonName:'Update', }; // Reset the form
                            showAddLeaveModal.value = false;
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
                finally{
                    NProgress.done();
                }
            };

            const addHoliday = async (holiday) => {
                NProgress.start();

                console.log(state.value.name, state.value.description, state.value.date, state.value.recurring, state.value.holiday_type)

                try {
                    if (holiday === null) {
                        const response = await axios.post('/storeHoliday', {
                            name: state.value.name,
                            description: state.value.description,
                        });

                        if (response.status === 200) {
                            notification('Holiday added successfully', 'success');
                            getHolidays();
                            state.value = { name: '', description: '', buttonName:'Save', holidayId: null  }; // Reset the form
                        }
                    }
                    if(holiday !== null) {
                        const response = await axios.post(`/updateHoliday/${holiday}`, {
                            name: state.value.name,
                            description: state.value.description,
                        });

                        if (response.status === 200) {
                            notification('Holiday updated successfully', 'success');
                            getHoliday();
                            state.value = { name: '', description: '', buttonName:'Update', }; // Reset the form
                            showAddHolidayModal.value = false;
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
                finally{
                    NProgress.done();
                }
            };

            const deleteDesignation = async (designation) => {
                loading.value = true;
                NProgress.start();

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
                    NProgress.done();
                }
            };

            const confirmLeaveTypeDelete = async(leaveTypeId) => {
                Swal.fire({
                    title: 'Delete leave type?',
                    text: 'Do you want to delete this leavetype? This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteLeaveType(leaveTypeId);
                    }
                });
            };

            const confirmHolidayDelete = async(holidayId) => {
                Swal.fire({
                    title: 'Delete holiday?',
                    text: 'Do you want to delete this holiday? This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteHoliday(holidayId);
                    }
                });
            };


            const confirmLeaveDelete = async(LeaveId) => {
                Swal.fire({
                    title: 'Delete leave?',
                    text: 'Do you want to delete this Leave? This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteLeave(LeaveId);
                    }
                });
            };

            const deleteLeaveType = async (leaveType) => {
                NProgress.start();

                try {
                    const response = await axios.delete(`/deleteLeaveType/${leaveType}`, {});

                    if (response.status === 200) {
                        notification('LeaveType deleted successfully', 'success');
                        getLeaveTypes();
                    }
                } catch (error) {
                    const errorMessage = error.response.data.message || 'An unexpected error occurred';
                    notification(errorMessage, 'error');
                } finally {
                    loading.value = false;
                    NProgress.done();
                }
            };

            const deleteHoliday = async (holiday) => {
                NProgress.start();

                try {
                    const response = await axios.delete(`/deleteLeaveType/${leaveType}`, {});

                    if (response.status === 200) {
                        notification('LeaveType deleted successfully', 'success');
                        getLeaveTypes();
                    }
                } catch (error) {
                    const errorMessage = error.response.data.message || 'An unexpected error occurred';
                    notification(errorMessage, 'error');
                } finally {
                    loading.value = false;
                    NProgress.done();
                }
            };

            const deleteLeave = async (Leave) => {
                NProgress.start();

                try {
                    const response = await axios.delete(`/deleteLeave/${Leave}`, {});

                    if (response.status === 200) {
                        notification('Leave deleted successfully', 'success');
                        getLeaves();
                    }
                } catch (error) {
                    const errorMessage = error.response.data.message || 'An unexpected error occurred';
                    notification(errorMessage, 'error');
                } finally {
                    loading.value = false;
                    NProgress.done();
                }
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

            const closeForm = async() => {
                showAddDesignationModal.value = false;
                showAddLeaveTypeModal.value = false;
                showAddHolidayModal.value = false;
            }

            const leaveApproval = async (leaveId) => {
                const result = await Swal.fire({
                    title: 'Change leave status?',
                    text: `You are about to change the leave status. This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Approve',
                    denyButtonText: 'Reject',
                    cancelButtonText: 'Cancel',
                });

                if (result.isConfirmed) {
                    // Approve action
                    await updateLeaveStatus('approved', leaveId);
                } else if (result.isDenied) {
                    // Reject action
                    await updateLeaveStatus('rejected', leaveId);
                } else if (result.isDismissed) {
                    // Optional: Handle cancel action if needed
                    Swal.fire('Cancelled', 'No changes were made.', 'info');
                }
            };

            function updateLeaveStatus(status, leaveId) {
                console.log(`Status updated to: ${status}, Leave ID: ${leaveId}`);

                // Make an API call to change the status
                axios.patch(`/leaves/${leaveId}/approval`, { status: status })
                    .then(response => {
                        // Display a success notification
                        notification(response.data.message, 'success');
                        // Refresh the leaves list after the status update
                        getLeaves();
                    })
                    .catch(error => {
                        // Display an error notification
                        const errorMessage = error.response?.data?.message || 'Failed to update leave status.';
                        notification(errorMessage, 'error');
                        console.error('Error updating leave status:', error);
                    });
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
                addHoliday,
                showAddDesignationModal,
                openForm,
                state,
                deleteDesignation,
                editDesignation,
                designationDetails,
                confirmDelete,
                showAddLeaveTypeModal,
                closeForm,
                addLeaveType,
                confirmLeaveTypeDelete,
                confirmLeaveDelete,
                showAddHolidayModal,
                leaveApproval
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
