@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title', 'Edit employee')

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
    <livewire:common.page-header pageTitle="Edit employee"/>
    <div class="col-lg-12">
        @include('includes/error')
        @section('plugins.Select2', true)
        <div class="card mb-3 p-4">
            <div class="box-body">
                <h3>For Client: <strong>{{ $employee->client->client_name }}</strong></h3>
            </div>
        </div>
        <form action="{{ route('update-employee', $employee) }}" method="POST" autocomplete="off">
            @csrf
            @method('PUT')
            <x-adminlte-input type="text" name="client" id="client" value="{{ $employee->client->id }}" autocomplete="off" hidden/>
            <div class="card mb-3 p-4">
                <div class="box-body">
                    <p>Employee Details</p>
                    <div class="row">
                        <x-adminlte-input type="text" name="prefix" label="Prefix" placeholder="Mr. Ms. Mrs"
                            fgroup-class="col-md-1" class="{{ $errors->has('prefix') ? 'is-invalid' : '' }}"
                            id="prefix" value="{{ old('prefix', $employee->prefix) }}" autocomplete="off"/>

                        <x-adminlte-input type="text" name="firstname" label="First name:*" placeholder="Firstname"
                            fgroup-class="col-md-4" class="{{ $errors->has('firstname') ? 'is-invalid' : '' }}"
                            id="firstname" value="{{ old('firstname', $employee->fname) }}" autocomplete="off" required/>

                        <x-adminlte-input type="text" name="middlename" label="Middle name:" placeholder="Middlename"
                            fgroup-class="col-md-3" class="{{ $errors->has('middlename') ? 'is-invalid' : '' }}"
                            id="middlename" value="{{ old('middlename', $employee->mname) }}" autocomplete="off"/>

                        <x-adminlte-input type="text" name="lastname" label="Lastname:*" placeholder="Lastname"
                            fgroup-class="col-md-4" class="{{ $errors->has('lastname') ? 'is-invalid' : '' }}"
                            id="lastname" value="{{ old('lastname', $employee->sname) }}" autocomplete="off" required/>

                        <x-adminlte-input type="email" name="email" label="Email:*" placeholder="Email address"
                            fgroup-class="col-md-3" class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                            id="email" value="{{ old('email', optional($employee->user)->email ?? '') }}" autocomplete="off" required/>

                        <x-adminlte-input type="tel" name="phone" label="Phone:*" placeholder="Phone"
                            fgroup-class="col-md-3" class="{{ $errors->has('phone') ? 'is-invalid' : '' }}"
                            id="phone" value="{{ old('phone', $employee->phone) }}" autocomplete="off" required/>

                        <x-adminlte-input type="text" name="employee_number" label="Employee number:*" placeholder="Employee number"
                            fgroup-class="col-md-3" class="{{ $errors->has('employee_number') ? 'is-invalid' : '' }}"
                            id="employee_number" value="{{ old('employee_no', $employee->employee_no) }}" autocomplete="off" required/>

                        <x-adminlte-select2 name="status" label="Status:*" data-placeholder="Select an option..."
                            fgroup-class="col-md-3" class="{{ $errors->has('status') ? 'is-invalid' : '' }}" autocomplete="off" required>
                            <option value="" selected disabled>Please select an option...</option>
                            <option value="Pending" {{ (old('status', optional($employee)->status) == 'Pending') ? 'selected' : '' }}>Pending</option>
                            <option value="Active" {{ (old('status', optional($employee)->status) == 'Active') ? 'selected' : '' }}>Active</option>
                            <option value="Contract terminated" {{ (old('status', optional($employee)->status) == 'Contract terminated') ? 'selected' : '' }}>Contract terminated</option>
                            <option value="Contract ended" {{ (old('status', optional($employee)->status) == 'Contract ended') ? 'selected' : '' }}>Contract ended</option>
                            <option value="Suspended" {{ (old('status', optional($employee)->status) == 'Suspended') ? 'selected' : '' }}>Suspended</option>
                            <option value="On Probation" {{ (old('status', optional($employee)->status) == 'On Probation') ? 'selected' : '' }}>On Probation</option>
                        </x-adminlte-select2>
                    </div>
                </div>
            </div>
            <div class="card mb-3 p-4">
                <div class="box-body">
                    <p>More information</p>
                    <div class="row">
                        <x-adminlte-input type="text" name="birthdate" label="Date of birth:*" placeholder="Date of birth"
                            fgroup-class="col-md-2" class="{{ $errors->has('birthdate') ? 'is-invalid' : '' }}"
                            id="birthdate" value="{{ old('birthdate', optional($employee)->birthdate) }}" autocomplete="off" required/>

                        <x-adminlte-select2 name="gender" label="Gender:*" data-placeholder="Select an option..."
                            fgroup-class="col-md-2" class="{{ $errors->has('gender') ? 'is-invalid' : '' }}" autocomplete="off" required>
                            <option value="" selected disabled>Please select an option...</option>
                            <option value="Male" {{ (old('gender', optional($employee)->gender) == 'Male') ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ (old('gender', optional($employee)->gender) == 'Female') ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ (old('gender', optional($employee)->gender) == 'Other') ? 'selected' : '' }}>Other</option>
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="marital_status" label="Marital status:*" data-placeholder="Select an option..."
                            fgroup-class="col-md-2" class="{{ $errors->has('marital_status') ? 'is-invalid' : '' }}" autocomplete="off" required>
                            <option value="" selected disabled>Please select an option...</option>
                            <option value="Married" {{ (old('marital_status', optional($employee)->marital_status) == 'Married') ? 'selected' : '' }}>Married</option>
                            <option value="Single" {{ (old('marital_status', optional($employee)->marital_status) == 'Single') ? 'selected' : '' }}>Single</option>
                            <option value="Divorced" {{ (old('marital_status', optional($employee)->marital_status) == 'Divorced') ? 'selected' : '' }}>Divorced</option>
                            <option value="Other" {{ (old('marital_status', optional($employee)->marital_status) == 'Other') ? 'selected' : '' }}>Other</option>
                            <option value="Widow" {{ (old('marital_status', optional($employee)->marital_status) == 'Widow') ? 'selected' : '' }}>Widow</option>
                        </x-adminlte-select2>

                        <x-adminlte-input name="employee_alt_number" label="Alternate phone number:"
                            placeholder="Alternate phone number" fgroup-class="col-md-3" class="{{ $errors->has('employee_alt_number') ? 'is-invalid' : '' }}"
                            id="employee_alt_number" value="{{ old('employee_alt_number', optional($employee)->employee_alt_number) }}" autocomplete="off"/>

                        <x-adminlte-select2 name="nationality" label="Nationality:*" data-placeholder="Select an option..."
                            fgroup-class="col-md-3" class="{{ $errors->has('nationality') ? 'is-invalid' : '' }}" autocomplete="off" required>
                            <option value="" selected disabled>Please select an option...</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->name }}" {{ (old('nationality', optional($employee)->nationality_id) == $country->name) ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="id_type" label="ID Type:*" data-placeholder="Select an option..."
                            fgroup-class="col-md-2" class="{{ $errors->has('id_type') ? 'is-invalid' : '' }}" autocomplete="off" required>
                            <option value="" selected disabled>Please select an option...</option>
                            @foreach ($idTypes as $idType)
                                <option value="{{ $idType }}" {{ (old('id_type', optional($employee)->id_type) == $idType) ? 'selected' : '' }}>
                                    {{ $idType }}
                                </option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-input name="id_number" label="ID number:*" placeholder="ID number"
                            fgroup-class="col-md-2" class="{{ $errors->has('id_number') ? 'is-invalid' : '' }}"
                            id="id_number" value="{{ old('id_number', optional($employee)->id_number) }}" autocomplete="off" required/>

                        <x-adminlte-input name="resident_street" label="Resident street:*" placeholder="Resident street"
                            fgroup-class="col-md-2" class="{{ $errors->has('resident_street') ? 'is-invalid' : '' }}"
                            id="resident_street" value="{{ old('resident_street', optional($employee)->resident_street) }}" autocomplete="off" required/>

                        <x-adminlte-input name="resident_city" label="Resident city:*" placeholder="Resident city"
                            fgroup-class="col-md-2" class="{{ $errors->has('resident_city') ? 'is-invalid' : '' }}"
                            id="resident_city" value="{{ old('resident_city', optional($employee)->resident_city) }}" autocomplete="off" required/>

                        <x-adminlte-input name="resident_state" label="Resident state:*" placeholder="Resident state"
                            fgroup-class="col-md-2" class="{{ $errors->has('resident_state') ? 'is-invalid' : '' }}"
                            id="resident_state" value="{{ old('resident_state', optional($employee)->resident_state) }}" autocomplete="off" required/>

                        <x-adminlte-select2 name="resident_country" label="Resident country:*" data-placeholder="Select an option..."
                            fgroup-class="col-md-2" class="{{ $errors->has('resident_country') ? 'is-invalid' : '' }}" autocomplete="off" required>
                            <option value="" selected disabled>Please select an option...</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->name }}" {{ (old('resident_country', optional($employee)->resident_country) == $country->name) ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-input name="permanent_street" label="Permanent street:" placeholder="Permanent street"
                            fgroup-class="col-md-3" class="{{ $errors->has('permanent_street') ? 'is-invalid' : '' }}"
                            id="permanent_street" value="{{ old('permanent_street', optional($employee)->permanent_street) }}" autocomplete="off"/>

                        <x-adminlte-input name="permanent_city" label="Permanent city:" placeholder="Permanent city"
                            fgroup-class="col-md-3" class="{{ $errors->has('permanent_city') ? 'is-invalid' : '' }}"
                            id="permanent_city" value="{{ old('permanent_city', optional($employee)->permanent_city) }}" autocomplete="off"/>

                        <x-adminlte-input name="permanent_state" label="Permanent state:" placeholder="Permanent state"
                            fgroup-class="col-md-3" class="{{ $errors->has('permanent_state') ? 'is-invalid' : '' }}"
                            id="permanent_state" value="{{ old('permanent_state', optional($employee)->permanent_state) }}" autocomplete="off"/>

                        <x-adminlte-select2 name="permanent_country" label="Permanent country:" data-placeholder="Select an option..."
                            fgroup-class="col-md-3" class="{{ $errors->has('permanent_country') ? 'is-invalid' : '' }}" autocomplete="off">
                            <option value="" selected disabled>Please select an option...</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->name }}" {{ (old('permanent_country', optional($employee)->permanent_country) == $country->name) ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-input name="family_contact_name" label="Family contact name:" placeholder="Family contact name"
                            fgroup-class="col-md-4" class="{{ $errors->has('family_contact_name') ? 'is-invalid' : '' }}"
                            id="family_contact_name" value="{{ old('family_contact_name', optional($employee)->family_contact_name) }}" autocomplete="off" required/>

                        <x-adminlte-input name="family_contact_number" label="Family contact number:" placeholder="Family contact number"
                            fgroup-class="col-md-4" class="{{ $errors->has('family_contact_number') ? 'is-invalid' : '' }}"
                            id="family_contact_number" value="{{ old('family_contact_number', optional($employee)->family_contact_number) }}" autocomplete="off" required/>

                        <x-adminlte-input name="family_contact_alt_number" label="Family contact alt number:" placeholder="Family contact alt number"
                            fgroup-class="col-md-4" class="{{ $errors->has('family_contact_alt_number') ? 'is-invalid' : '' }}"
                            id="family_contact_alt_number" value="{{ old('family_contact_alt_number', optional($employee)->family_contact_alt_number) }}" autocomplete="off" required/>
                    </div>
                </div>
            </div>

            <div class="card mb-3 p-4">
                <div class="box-body">
                    <p>Employment details</p>
                        <div class="row">
                            <x-adminlte-input type="text" name="hiredate" label="Date Hired:" placeholder="Date hired" fgroup-class="col-md-4"
                                class="{{ $errors->has('hiredate') ? 'is-invalid' : '' }}"
                                id="hiredate"
                                autocomplete="off"
                                value="{{ old('hiredate', optional($employee)->hiredate) }}" />

                            <x-adminlte-input type="text" name="contract_end_date" label="Contract end date:"
                                placeholder="Contract end date" fgroup-class="col-md-4" class="{{ $errors->has('contract_end_date') ? 'is-invalid' : '' }}" id="contract_end_date" value="{{ old('hiredate', optional($employee)->contract_end_date) }}" autocomplete="off" required/>

                            <x-adminlte-select2 name="education_level" label="Education Level:"
                                data-placeholder="Select an option..."
                                fgroup-class="col-md-4"
                                class="{{ $errors->has('education_level') ? 'is-invalid' : '' }}"
                                autocomplete="off">
                                <option value="" selected disabled>Please select an option...</option>
                                @foreach ($educationLevels as $educationLevel)
                                    <option value="{{ $educationLevel }}" {{ (old('education_level', optional($employee)->education_level) == $educationLevel) ? 'selected' : '' }}>
                                        {{ $educationLevel }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>

                            <x-adminlte-select2 name="project" id="project" label="Project:" data-placeholder="Select an option..." fgroup-class="col-md-4" class="{{ $errors->has('project') ? 'is-invalid' : '' }}" autocomplete="off">
                                <option value="" selected disabled>Please select an option...</option>
                                @foreach (\App\Models\Projects::where('client_id', $employee->client_id)->get() as $project)
                                    <option value="{{ $project->id }}" {{ (old('project_id', optional($employee)->project_id) == $project->id) ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>

                            <x-adminlte-select2 name="designation" id="designation" label="Designation:"
                                data-placeholder="Select an option..."
                                fgroup-class="col-md-4"
                                class="{{ $errors->has('designation') ? 'is-invalid' : '' }}"
                                autocomplete="off">
                                <option value="" selected disabled>Please select an option...</option>
                                @foreach (App\Models\Designation::all() as $designation)
                                    <option value="{{ $designation->id }}" {{ (old('designation', optional($employee)->designation_id) == $designation->id) ? 'selected' : '' }}>
                                        {{ $designation->name }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>

                            <x-adminlte-select2 name="contract_type" label="Contract type:"
                                data-placeholder="Select an option..."
                                fgroup-class="col-md-4"
                                class="{{ $errors->has('contract_type') ? 'is-invalid' : '' }}"
                                autocomplete="off">
                                <option value="" selected disabled>Please select an option...</option>
                                <option value="Permanent" {{ (old('contract_type', optional($employee)->contract_type) == 'Permanent') ? 'selected' : '' }}>Permanent</option>
                                <option value="Part time" {{ (old('contract_type', optional($employee)->contract_type) == 'Part time') ? 'selected' : '' }}>Part time</option>
                                <option value="Contract" {{ (old('contract_type', optional($employee)->contract_type) == 'Contract') ? 'selected' : '' }}>Contract</option>
                            </x-adminlte-select2>

                            <div class="col-md-4">
                                <div class="row input-group form-group-lg group-side-padding">
                                    <x-adminlte-input name="probation_period" label="Probation period:"
                                        placeholder="Probation period"
                                        fgroup-class="col-md-8 pr-0"
                                        class="{{ $errors->has('probation_period') ? 'is-invalid' : '' }}"
                                        id="probation_period"
                                        value="{{ old('probation_period', optional($employee)->probation_period) }}"
                                        autocomplete="off"
                                        required/>

                                    <x-adminlte-select2 name="probation_period_type" label="Period type"
                                        fgroup-class="col-md-4 px-0"
                                        class="{{ $errors->has('probation_period_type') ? 'is-invalid' : '' }}"
                                        data-placeholder="Select an option..."
                                        autocomplete="off">
                                        <option value="" selected disabled>Please select an option...</option>
                                        @foreach ($terminationPeriodTypes as $terminationPeriodType)
                                            <option value="{{ $terminationPeriodType }}"
                                                {{ (old('probation_period_type', optional($employee)->probation_period_type) == $terminationPeriodType) ? 'selected' : '' }}>
                                                {{ $terminationPeriodType }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row input-group form-group-lg">
                                    <x-adminlte-input name="termination_notice_period" label="Notice period:"
                                        placeholder="Termination notice period" fgroup-class="col-md-8 pr-0"
                                        class="{{ $errors->has('termination_notice_period') ? 'is-invalid' : '' }}"
                                        id="termination_notice_period"
                                        value="{{ old('termination_notice_period', optional($employee)->termination_notice_period) }}"
                                        autocomplete="off" required/>

                                    <x-adminlte-select2 name="termination_notice_period_type" label="Period type"
                                        fgroup-class="col-md-4 pl-0"
                                        class="{{ $errors->has('termination_notice_period_type') ? 'is-invalid' : '' }}"
                                        data-placeholder="Select an option..."
                                        autocomplete="off">
                                        <option value="" selected disabled>Please select an option...</option>
                                        @foreach ($terminationPeriodTypes as $terminationPeriodType)
                                            <option value="{{ $terminationPeriodType }}"
                                                {{ (old('termination_notice_period_type', optional($employee)->termination_notice_period_type) == $terminationPeriodType) ? 'selected' : '' }}>
                                                {{ $terminationPeriodType }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                            </div>

                            <x-adminlte-select2 id="designated_location" name="designated_location" label="Designated Location" data-placeholder="Select an option..." fgroup-class="col-md-4" class="{{ $errors->has('designated_location') ? 'is-invalid' : '' }}" autocomplete="off">
                                <option value="" selected disabled>Please select an option...</option>
                                @foreach (HavenPlus\Districts\Models\District::orderBy('name', 'ASC')->get() as $district)
                                    <option value="{{ $district->iso_code }}" {{ $district->iso_code === $employee->designated_location ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>

                            <x-adminlte-input name="designated_location_specifics" label="Designated location other specifics:" placeholder="Designated location other specifics" fgroup-class="col-md-4" class="{{ $errors->has('designated_location_specifics') ? 'is-invalid' : '' }}" id="designated_location_specific" autocomplete="off"/>
                        </div>
                </div>
            </div>
            <div class="card mb-3 p-4">
                <div class="box-body">
                    <p>Payroll details</p>
                    <div class="row">
                        <x-adminlte-input
                            name="basic_pay"
                            label="Basic pay:"
                            placeholder="Basic pay"
                            fgroup-class="col-md-4 pr-0"
                            class="{{ $errors->has('basic_pay') ? 'is-invalid' : '' }}"
                            id="basic_pay"
                            value="{{ old('basic_pay', optional($employee)->salary) }}"
                            autocomplete="off"
                            required
                        />

                        <x-adminlte-select2
                            name="pay_period"
                            label="Pay period:"
                            fgroup-class="col-md-2 pl-0"
                            class="{{ $errors->has('pay_period') ? 'is-invalid' : '' }}"
                            autocomplete="off"
                        >
                            <option value="" selected disabled>Please select an option...</option>
                            @foreach ($payPeriods as $payPeriod)
                                <option value="{{ $payPeriod }}" {{ (old('pay_period', optional($employee)->pay_period) == $payPeriod) ? 'selected' : '' }}>
                                    {{ $payPeriod }}
                                </option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-input
                            type="checkbox"
                            name="paye"
                            label="Paye:"
                            fgroup-class="checkbox"
                            class="{{ $errors->has('paye') ? 'is-invalid' : '' }}"
                            id="paye"
                            {{ old('paye', optional($employee)->paye) ? 'checked' : '' }}
                            autocomplete="off"
                        />
                    </div>
                </div>
            </div>

            <div class="card mb-3 p-4">
                <div class="box-body">
                    <p>Login details <figcaption class="blockquote-footer">
                        Do not edit if you dont want to change credentials!
                    </figcaption></p>
                    <div class="row">
                        <!-- Username Input -->
                        <x-adminlte-input type="text" name="username" label="Username" placeholder="Username" fgroup-class="col-md-3" id="username" autocomplete="off" value="{{ old('username', $employee->user->username ?? '') }}" class="{{ $errors->has('username') ? 'is-invalid' : '' }}" />

                        <!-- Password Input -->
                        <x-adminlte-input
                            type="password"
                            name="password"
                            label="Password"
                            placeholder="Password"
                            fgroup-class="col-md-3"
                            id="password"
                            autocomplete="off"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        />

                        <!-- Confirm Password Input -->
                        <x-adminlte-input
                            type="password"
                            name="confirm_password"
                            label="Confirm Password"
                            placeholder="Password"
                            fgroup-class="col-md-3"
                            id="confirm_password"
                            autocomplete="off"
                            class="{{ $errors->has('confirm_password') ? 'is-invalid' : '' }}"
                        />

                        <x-adminlte-input
                            type="checkbox"
                            name="allow_login"
                            id="allow_login"
                            label="Allow Login:*"
                            fgroup-class="checkbox"
                            class="{{ $errors->has('allow_login') ? 'is-invalid' : '' }}"
                            autocomplete="off" />
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Save
            </button>
        </form>
    </div>
</div>
@stop

@include('/components/layouts/footer_bottom')

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script>

    $(document).ready(function() {
        $("#hiredate, #contract_end_date, #birthdate").datepicker({
            format: "dd MM yyyy", // Format to display day, month, and year
        });
    });

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
