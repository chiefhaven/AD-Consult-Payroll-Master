@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Add adminitrator')

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
<div class="row" id="addAdmins">
    <!-- Page Header -->
    <livewire:common.page-header
        pageTitle="Add administrator"
    />

    <!-- Admin List Section -->
    <div class="col-lg-12">
        @include('admins/includes/adminForm')
    </div>
</div>
@stop

{{-- Create a common footer --}}

@include('/components/layouts/footer_bottom')

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script>

    const addAdmins = createApp({
        setup() {

            const errors = ref({});
            const isSubmitting = ref(false);

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
                buttonName:'Add admin',
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
                  const response = await axios.post('/admin-store', formData, {
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

            const deleteAdmin = async (admin) => {
                loading.value = true;
                NProgress.start();

                try {
                    const response = await axios.delete(`/deleteAdmin/${admin}`, {});

                    if (response.status === 200) {
                        notification('Admin deleted successfully', 'success');
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
                form,
                errors,
                isSubmitting,
                storeAdmin,
                handleFileUpload,
                confirmDelete,
            }

        }
    });

    addAdmins.mount('#addAdmins');

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
