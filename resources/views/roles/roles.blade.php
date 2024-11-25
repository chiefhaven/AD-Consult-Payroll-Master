@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Roles')

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
<div class="row" id="roles" v-cloak>
    <!-- Page Header -->
    <livewire:common.page-header
        pageTitle="Roles"
    />

    <!-- Admin List Section -->
    <div class="col-lg-12">
        <div class="card mb-3 p-4">
            <!-- Card Header -->
            <h4 class="pb-4">All roles</h4>

            <!-- Admin Table -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="rolesTable" class="table table-bordered table-striped" style="min-width: 100%">
                            <thead>
                                <tr>
                                    <th style="min-width: 10em">Name</th>
                                    <th>Description</th>
                                    <th style="min-width: 5em;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="role in roles" :key="role.id">
                                    <td>@{{ role.name }}</td>
                                    <td>@{{ role.description }}</td>
                                    <td class="text-center">
                                        <div class="dropdown d-inline-block">
                                            <button type="button" class="btn btn-default" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="d-sm-inline-block">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end p-0">
                                                <div class="p-2">
                                                    <!-- View -->
                                                    <button class="dropdown-item nav-main-link" @click="viewRole(role.id)">
                                                        <i class="nav-main-link-icon fas fa-eye"></i>
                                                        <span class="btn">View</span>
                                                    </button>

                                                    <!-- Edit role -->
                                                    <button class="dropdown-item nav-main-link btn" @click="editRole(role.id)">
                                                        <i class="nav-main-link-icon fas fa-pencil-alt"></i>
                                                        <span class="btn">Edit</span>
                                                    </button>

                                                    <button class="dropdown-item nav-main-link btn delete-designation-confirm" type="button" @click="confirmDelete(role.id)">
                                                        <i class="nav-main-link-icon fas fa-trash-alt"></i>
                                                        <span class="btn">Delete</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('/roles/includes/editModal')
    </div>
</div>
@stop

{{-- Create a common footer --}}

@include('/components/layouts/footer_bottom')

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script>
    const roles = createApp({
        setup() {

            const showEditModal = ref(false);
            const roleName = ref('');
            const roles = ref([]);
            const role = ref({});
            const loading = ref(false);
            const error = ref(null);
            const selectedPermissions = ref([]);
            const permissions = ref([]);

            const fetchRoles = async () => {
                NProgress.start();
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/get-roles`);

                    roles.value = Array.isArray(response.data.roles) ? response.data.roles : [];
                    permissions.value = Array.isArray(response.data.permissions) ? response.data.permissions : [];
                    initializeDataTable();
                } catch (err) {
                    console.error("Error fetching roles:", err);
                    error.value = "Failed to fetch roles.";
                } finally {
                    loading.value = false;
                    NProgress.done();
                }
            };

            // Function to initialize DataTable after Vue has rendered the table
            const initializeDataTable = () => {
                setTimeout(() => {
                    $('#rolesTable').DataTable({
                        dom: 'Bfrtip',
                        buttons: ['copy', 'excel', 'pdf', 'print'],
                        scrollX: true,
                        scrollY: true,
                    });
                }, 0); // Timeout ensures the DOM is ready
            };

            onMounted(() => {
                fetchRoles();
            });

            const editRole = (roleIndex) => {
                const selectedRole = roles.value[roleIndex];

                if (selectedRole) {
                    role.value = selectedRole; // Set the current role
                    roleName.value = selectedRole.name; // Set the role name

                    // Pre-check permissions that belong to the selected role
                    selectedPermissions.value = selectedRole.permissions.map(permission => permission.id);

                    console.log("Role:", selectedRole);
                    console.log("Selected permissions:", selectedPermissions.value);

                    showEditModal.value = true; // Show the edit modal
                } else {
                    console.error("Invalid role index:", roleIndex);
                }
            };

            const saveRole = async() => {
                // Logic to save changes
                console.log("Role updated to:", roleName);
                showEditModal.value = false;
            };

            return {
                roles,
                loading,
                error,
                showEditModal,
                editRole,
                roleName,
                saveRole,
                role,
                selectedPermissions,
                permissions,
            };
        }
    });

    roles.mount('#roles');

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
