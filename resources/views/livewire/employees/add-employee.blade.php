<div class="col-lg-12">
    @if(session()->has('success'))
        <div class="alert alert-success text-center">
            {{ session()->get('success') }}
        </div>
    @endif
    @include('includes/error')
    @section('plugins.Select2', true)
    <form wire:submit="save">
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Employee Details</p>
                <div class="row">
                        <x-adminlte-input type="text" name="prefix" label="Prefix" placeholder="Mr. Ms. Mrs" fgroup-class="col-md-2"
                        id="prefix" wire:model="form.prefix"/>

                        <x-adminlte-input type="text" name="firstname" label="First name:*" placeholder="Firstname" fgroup-class="col-md-4"
                        id="firstname" wire:model="form.firstname" required/>

                        <x-adminlte-input type="text" name="middlename" label="Middle name:" placeholder="Middlename" fgroup-class="col-md-3"
                        id="middlename" wire:model="form.middlename"/>

                        <x-adminlte-input type="text" name="surname" label="Surname:*" placeholder="Surname" fgroup-class="col-md-3"
                        id="surname" wire:model="form.surname" required/>

                        <x-adminlte-input type="email" name="email" label="Email:*" placeholder="Email address" fgroup-class="col-md-4"
                        id="email" wire:model="form.email" required/>

                        <x-adminlte-input type="tel" name="phone" label="Phone:*" placeholder="Phone" fgroup-class="col-md-3"
                        id="phone" wire:model="form.phone" required/>
                </div> 
            </div>
        </div>
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>More information</p>
                <div class="row">
                        <x-adminlte-input type="date" name="date_of_birth" label="Date of birth" placeholder="Date of birth"
                        fgroup-class="col-md-3" id="date_of_birth" wire:model="form.date_of_birth" required/>

                        <x-adminlte-select2 type="text" name="gender" label="Gender:*" wire:model="form.gender" data-placeholder="Select an option..."
                        fgroup-class="col-md-3" required>
                            @foreach ($genderEnums as $genderEnum)
                                <option {{ $genderEnum == 'Male' ? 'selected' : '' }}>{{$genderEnum}}</option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-select2 type="text" name="marital_status" label="Marital status:*" wire:model="form.marital_status"
                        data-placeholder="Select an option..." fgroup-class="col-md-2" required>
                            @foreach ($maritalStatusEnums as $maritalStatusEnum)
                                <option {{ $maritalStatusEnum == 'Single' ? 'selected' : '' }}>{{$maritalStatusEnum}}</option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-input type="text" name="employee_alt_number" label="Alternate phone number:"
                        placeholder="Alternate phone number" fgroup-class="col-md-4"
                        id="employee_alt_number" wire:model="form.employee_alt_number"/>

                        <x-adminlte-select2 type="text" name="nationality" label="Nationality" wire:model="form.nationality" data-placeholder="Select an option..."
                         fgroup-class="col-md-3">
                            @foreach ($countries as $country)
                                <option {{ $country->name == 'Malawi' ? 'selected' : '' }}>{{$country->name}}</option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="id_type" wire:model="form.id_type" label="ID Type" data-placeholder="Select an option..."
                         fgroup-class="col-md-3">
                            @foreach ($idTypes as $idType)
                                <option {{$idType == 'Malawi National ID' ? 'selected' : ''}}>{{$idType}}</option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-input name="id_number" label="ID number:" placeholder="ID number"
                        fgroup-class="col-md-3" id="id_number" wire:model="form.id_number" required/>

                        <x-adminlte-input-file name="id_proof" label="Upload ID proof" placeholder="Choose a file..."
                        fgroup-class="col-md-3" wire:model="form.id_proof" wire:model="form.id_proof"/>

                        <x-adminlte-textarea name="employee_current_address" label="Current Address" rows=5
                            igroup-size="sm" placeholder="Enter employee current residence" fgroup-class="col-md-6" wire:model="form.employee_current_address">
                        </x-adminlte-textarea>

                        <x-adminlte-textarea name="employee_permanent_address" label="Permanent Address" rows=5
                            igroup-size="sm" placeholder="Enter employee permanent/home address" fgroup-class="col-md-6" wire:model="form.employee_permanent_address">
                        </x-adminlte-textarea>


                        <x-adminlte-input name="family_contact_name" label="Family contact name:"
                        placeholder="Family contact name" fgroup-class="col-md-4"
                        id="family_contact_name" wire:model="form.family_contact_name" required wire:model="form.family_contact_name"/>

                        <x-adminlte-input name="family_contact_number" label="Family contact number:"
                        placeholder="Family contact alt number" fgroup-class="col-md-4"
                        id="family_contact_number" wire:model="form.family_contact_number" wire:model="form.family_contact_number" required/>

                        <x-adminlte-input name="family_contact_alt_number" label="Family contact alt number:"
                        placeholder="Family contact alt number" fgroup-class="col-md-4"
                        id="family_contact_alt_number" wire:model="form.family_contact_alt_number" required/>

                </div>
            </div>
        </div>

        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Employment details</p>
                        <div class="row">
                        <x-adminlte-input type="date" name="hiredate" label="Date Hired" placeholder="Date hired"
                        fgroup-class="col-md-3" id="hiredate" wire:model="form.hiredate"/>


                        <x-adminlte-select2 name="company" label="Company/Organization" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="form.company">
                            <option value="United Nation">United Nations</option>
                            <option value="World Bank">World Bank</option>
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="education_level" label="Education Level" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="form.education_level">
                            @foreach ($educationLevels as $educationLevel)
                                <option {{ $educationLevel == 'BSC' ? 'selected' : '' }}>{{$educationLevel}}</option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="project" label="Project" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="form.project">
                            <option>UN Aids</option>
                            <option>Cholera</option>
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="designation" label="Designation" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="form.designation">
                            <option>Accountant</option>
                            <option>Field Officer</option>
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="contract_type" label="Contract type" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="form.contract_type">
                            <option>Permanent</option>
                            <option>Part time</option>
                        </x-adminlte-select2>

                        <x-adminlte-input name="probation_period" label="Probation period:"
                        placeholder="Probation period" fgroup-class="col-md-4"
                        id="probation_period" wire:model="form.probation_period" wire:model="form.probation_period" required/>

                        <div class="col-md-4">
                            <div class="row input-group form-group-lg">
                                <x-adminlte-input name="termination_notice_period" label="Notice period:"
                                placeholder="Termination notice period" fgroup-class="col-md-8" id="termination_notice_period"  wire:model="form.termination_notice_period" required/>

                            <x-adminlte-select2 name="termination_notice_period_type" label="" wire:model="form.termination_notice_period_type" fgroup-class="col-md-4" data-placeholder="Select an option...">
                                @foreach ($terminationPeriodTypes as $terminationPeriodType)
                                    <option {{ $terminationPeriodType == 'Days' ? 'selected' : '' }}>{{$terminationPeriodType}}</option>
                                @endforeach
                            </x-adminlte-select2>
                            </div>
                        </div>

                        <x-adminlte-input type="date" name="contract_start_date" label="Contract start date:"
                        placeholder="Contract start date" fgroup-class="col-md-4"
                        id="start_date_contract" wire:model="form.contract_start_date" required/>

                        <x-adminlte-input type="date" name="contract_end_date" label="Contract end date:"
                        placeholder="Contract end date" fgroup-class="col-md-4"
                        id="contract_end_date" wire:model="form.contract_end_date" required/>

                        <x-adminlte-select2 name="designated_location" label="Designated Location" wire:model="form.designated_location" data-placeholder="Select an option..."
                        fgroup-class="col-md-4">
                            <option>Lilongwe</option>
                            <option>Salima</option>
                        </x-adminlte-select2>

                        <x-adminlte-input name="designated_location_specifics" label="Designated location other specifics:"
                        placeholder="Designated location other specifics" fgroup-class="col-md-4"
                        id="designated_location_specific" wire:model="form.designated_location_specifics" required/>

                </div>
            </div>
        </div>

        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Payroll details</p>
                <div class="row">
                    <x-adminlte-input name="basic_pay" label="Basic pay:"
                    placeholder="Basic pay" fgroup-class="col-md-4" id="basic_pay" wire:model="form.basic_pay" required/>

                    <x-adminlte-select2 name="pay_period" label="Pay period" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="form.pay_period">
                        @foreach ($payPeriods as $payPeriod)
                            <option {{ $payPeriod == 'Single' ? 'Monthly' : '' }}>{{$payPeriod}}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="tax" label="Tax" wire:model="form.tax" data-placeholder="Select an option..."
                        fgroup-class="col-md-4">
                            <option>None</option>
                            <option>Payee</option>
                    </x-adminlte-select2>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            Save
            <div wire:loading>
                @include('livewire/common/spinner')
            </div>
        </button>
    </form>
</div>
