@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Adminitrators')

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
    <!-- Page Header -->
    <livewire:common.page-header
        pageTitle="Administrators"
        buttonName="Add Admin"
        link="add-admin"
    />

    <!-- Admin List Section -->
    <div class="col-lg-12" id="admins" v-cloak>
        <div class="card mb-3 p-4">
            <!-- Card Header -->
            <h4 class="pb-4">All Administrators</h4>
            <!-- Admin Table -->
            <div v-if="!loading && admins.length > 0">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="adminsTable" class="table table-bordered table-striped" style="min-width: 100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="admin in admins" :key="admin.id">
                                        <td>@{{ admin.first_name }} @{{ admin.middle_name }} @{{ admin.sirname }}</td>
                                        <td>@{{ admin.user.email }}</td>
                                        <td>@{{ admin.phone }}</td>
                                        <td>
                                            <div v-for="role in admin.user.roles" :key="role.id">
                                                <div v-if="role.name === 'it_admin'">
                                                    IT admin
                                                </div>
                                                <div v-if="role.name === 'finance_admin'">
                                                    Finance admin
                                                </div>
                                                <div v-if="role.name === 'hr_admin'">
                                                    HR admin
                                                </div>
                                                <div v-if="role.name === 'super_admin'">
                                                    Super admin
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            <span v-if="admin.is_active == 1">Active</span>
                                            <span v-else>Inactive</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown d-inline-block">
                                                <button type="button" class="btn btn-default" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="d-sm-inline-block">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end p-0">
                                                    <div class="p-2">
                                                        <!-- View -->
                                                        <button class="dropdown-item nav-main-link" @click="viewAdmin(admin.id)">
                                                            <i class="nav-main-link-icon fas fa-eye"></i>
                                                            <span class="btn">View</span>
                                                        </button>

                                                        <!-- Edit role -->
                                                        <button class="dropdown-item nav-main-link btn" @click="editAdmin(admin.id)">
                                                            <i class="nav-main-link-icon fas fa-pencil-alt"></i>
                                                            <span class="btn">Edit</span>
                                                        </button>

                                                        <!-- Delete -->
                                                        <button class="dropdown-item nav-main-link btn delete-designation-confirm" type="button" @click="confirmDelete(admin.id)">
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
        @include('/admins/includes/editAdminModal')
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

    const admins = createApp({
        setup() {

            const admins = ref([]);
            const adminData = ref({});
            const loading = ref(false);
            const error = ref('');

            const errors = ref({});
            const isSubmitting = ref(false);

            const showEditAdminModal = ref(false);

            const form = ref({
                first_name: '',        // first_name'
                middle_name: '',       // Optional field
                sirname: '',           // Required field
                profile_picture: null, // File upload (initially null)
                phone: '',             // Optional field
                alt_phone: '',         // Optional field
                street_address: '',    // Optional field
                district: '',          // Optional field
                country: '',           // Optional field
                role: '',              // Default value
                is_active: true,       // Default active status
                username:'',
                password:'',
                buttonName:'Update',
            });

            const storeAdmin = async () => {
                NProgress.start();

                isSubmitting.value = true;
                errors.value = {}; // Clear previous errors

                // Prepare FormData
                const formData = new FormData();

                // Populate FormData
                Object.keys(form.value).forEach((key) => {
                  if (key === 'profile_picture' && form.value[key]) {
                    formData.append(key, form.value[key]); // File handling
                  } else {
                    formData.append(key, form.value[key]);
                  }
                });

                // Debug: Log contents of FormData
                for (const [key, value] of formData.entries()) {
                  console.log(`${key}:`, value);
                }

                try {
                  const response = await axios.put('/update-admin', formData, {
                    headers: {
                      'Content-Type': 'multipart/form-data',
                    },
                  });

                  // Reset form after successful submission
                  form.value = {
                    first_name: '',
                    middle_name: '',
                    sirname: '',
                    profile_picture: null,
                    phone: '',
                    alt_phone: '',
                    street_address: '',
                    district: '',
                    country: '',
                    department: '',
                    role: '',
                    is_active: true,
                  };

                  // Success message or redirect
                  notification('Admin added successifully, page redirecting...', 'success');

                  window.location.href = '/admins';

                } catch (error) {
                  if (error.response && error.response.data.errors) {
                    // Capture validation errors from the backend
                    errors.value = error.response.data.errors;
                    console.log('Admin created successfully:', errors.value);

                  } else {
                    console.error('An error occurred:', error);
                  }
                } finally {
                  isSubmitting.value = false;
                  NProgress.done();
                }
            };


            const handleFileUpload = (event) => {
                form.value.profile_picture = event.target.files[0];
            };

            const editAdmin = (admin) => {
                NProgress.start();
                // If admin is an index, this works as it is.
                // If admin is an ID, you might want to search the array for the corresponding admin
                if (typeof admin === 'number') {
                    // If `admin` is an index, access the item directly
                    adminData.value = admins.value[admin];
                } else {
                    // If `admin` is an ID or another property, search the admins array
                    adminData.value = admins.value.find(item => item.id === admin);
                }

                // Check if admin data exists, then merge it into the form
                if (adminData.value) {
                    Object.assign(form.value, adminData.value);

                    console.log(adminData.value);

                    // Ensure username and password are taken from admin.user
                    if (adminData.value.user) {
                        form.value.username = adminData.value.user.username || '';
                        form.value.email = adminData.value.user.email || '';  // Assuming password is required for edit
                    }
                }
                showEditAdminModal.value = true;
                NProgress.done();

            };

            const confirmDelete = async(adminId) => {
                Swal.fire({
                    title: 'Delete admin?',
                    text: 'Do you want to delete this admin? This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteAdmin(adminId);
                    }
                });
            };

            const fetchAdmins = async () => {
                loading.value = true;
                error.value = null;
                try {
                    const response = await axios.get(`/adminData`);
                    admins.value = response.data.length > 0 ? response.data : [];
                    console.log(admins.value);
                    initializeDataTable();
                } catch (err) {
                    error.value = "Failed to fetch admins.";
                } finally {
                    loading.value = false;
                    NProgress.done();

                }
            };

            onMounted(() => {
                NProgress.start();
                fetchAdmins();
            });

            const deleteAdmin = async (admin) => {
                loading.value = true;
                NProgress.start();

                try {
                    const response = await axios.delete(`/delete-admin/${admin}`, {});

                    if (response.status === 200) {
                        // Remove the deleted admin from Admins.value array
                        admins.value = admins.value.filter(item => item.id !== admin)

                        notification('Admin deleted successfully', 'success');
                    }
                } catch (error) {
                    console.log(error)
                    const errorMessage = error.response.data.message || 'An unexpected error occurred';
                    notification(errorMessage, 'error');
                } finally {
                    loading.value = false;
                    NProgress.done();
                }
            };

            // Function to initialize DataTable after Vue has rendered the table
            const initializeDataTable = () => {
                setTimeout(() => {
                    $('#adminsTable').DataTable({
                        dom: 'Bfrtip',
                        buttons: ['copy', 'excel', 'pdf', 'print'],
                        scrollX: true,
                        scrollY: true,
                    });
                }, 0); // Timeout ensures the DOM is ready
            };

            const closeModal = async() => {
                showEditAdminModal.value = false;
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

            return{
                admins,
                confirmDelete,
                loading,
                storeAdmin,
                editAdmin,
                showEditAdminModal,
                adminData,
                form,
                errors,
                error,
                handleFileUpload,
                isSubmitting,
                closeModal,
            }

        }
    });

    admins.mount('#admins');

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
