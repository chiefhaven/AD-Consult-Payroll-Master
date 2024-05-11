<div class="col-lg-12">
    @section('plugins.Select2', true)
    <form wire:submit="save">
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Employee Details</p>
                <div class="row">
                        <x-adminlte-input type="text" name="prefix" label="Prefix" placeholder="Mr. Ms. Mrs" fgroup-class="col-md-2"
                        disable-feedback id="prefix" wire:model="prefix"/>

                        <x-adminlte-input type="text" name="firstname" label="First name:*" placeholder="Firstname" fgroup-class="col-md-4"
                        disable-feedback id="firstname" wire:model="firstname" required/>

                        <x-adminlte-input type="text" name="middlename" label="Middle name:" placeholder="Middlename" fgroup-class="col-md-3"
                        disable-feedback id="middlename" wire:model="middlename"/>

                        <x-adminlte-input type="text" name="surname" label="Surname:*" placeholder="Surname" fgroup-class="col-md-3"
                        disable-feedback id="surname" wire:model="surname" required/>

                        <x-adminlte-input type="email" name="email" label="Email:*" placeholder="Email address" fgroup-class="col-md-4"
                        disable-feedback id="email" wire:model="email" required/>

                        <x-adminlte-input type="tel" name="phone" label="Phone:*" placeholder="Phone" fgroup-class="col-md-3"
                        disable-feedback id="phone" wire:model="phone" required/>
                </div>
            </div>
        </div>
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>More information</p>
                <div class="row">
                        <x-adminlte-input type="date" name="date_of_birth" label="Date of birth" placeholder="Date of birth"
                        fgroup-class="col-md-3" id="date_of_birth" wire:model="date_of_birth" required/>

                        <x-adminlte-select2 type="text" name="gender" label="Gender:*" wire:model="gender" data-placeholder="Select an option..."
                        fgroup-class="col-md-3" required>
                            @foreach ($genderEnums as $genderEnum)
                                <option value="{{$genderEnum}}" {{ $genderEnum == 'Male' ? 'selected' : '' }}>{{$genderEnum}}</option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-select2 type="text" name="marital_status" label="Marital status:*" wire:model="marital_status"
                        data-placeholder="Select an option..." fgroup-class="col-md-2" required>
                            @foreach ($maritalStatusEnums as $maritalStatusEnum)
                                <option value="{{$maritalStatusEnum}}" {{ $maritalStatusEnum == 'Single' ? 'selected' : '' }}>{{$maritalStatusEnum}}</option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-input type="text" name="employee_alt_number" label="Alternate phone number:"
                        placeholder="Alternate phone number" fgroup-class="col-md-4"
                        disable-feedback id="employee_alt_number" wire:model="employee_alt_number"/>

                        <x-adminlte-select2 type="text" name="nationality" label="Nationality" wire:model="nationality" data-placeholder="Select an option..."
                         fgroup-class="col-md-3">
                            @foreach ($countries as $country)
                                <option value="{{$country->name}}" {{ $country->name == 'Malawi' ? 'selected' : '' }}>{{$country->name}}</option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="id_type" wire:model="id_type" label="ID Type" data-placeholder="Select an option..."
                         fgroup-class="col-md-3">
                            @foreach ($idTypes as $idType)
                                <option value="{{$idType}}">{{$idType}}</option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-input name="id_number" label="ID number:" placeholder="ID number"
                        fgroup-class="col-md-3" disable-feedback id="id_number" wire:model="id_number" required/>

                        <x-adminlte-input-file name="id_proof" label="Upload ID proof" placeholder="Choose a file..."
                        fgroup-class="col-md-3" wire:model="id_proof" wire:model="id_proof" disable-feedback/>

                        <x-adminlte-textarea name="employee_current_address" label="Current Address" rows=5
                            igroup-size="sm" placeholder="Enter employee current residence" fgroup-class="col-md-6" wire:model="employee_current_address">
                        </x-adminlte-textarea>

                        <x-adminlte-textarea name="employee_permanent_address" label="Permanent Address" rows=5
                            igroup-size="sm" placeholder="Enter employee permanent/home address" fgroup-class="col-md-6" wire:model="employee_permanent_address">
                        </x-adminlte-textarea>


                        <x-adminlte-input name="family_contact_name" label="Family contact name:"
                        placeholder="Family contact name" fgroup-class="col-md-4"
                        disable-feedback id="family_contact_name" wire:model="family_contact_name" required wire:model="family_contact_name"/>

                        <x-adminlte-input name="family_contact_number" label="Family contact number:"
                        placeholder="Family contact alt number" fgroup-class="col-md-4"
                        disable-feedback id="family_contact_number" wire:model="family_contact_number" wire:model="family_contact_number" required/>

                        <x-adminlte-input name="family_contact_alt_number" label="Family contact alt number:"
                        placeholder="Family contact alt number" fgroup-class="col-md-4"
                        disable-feedback id="family_contact_alt_number" wire:model="family_contact_alt_number" required/>

                </div>
            </div>
        </div>

        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Employment details</p>
                        <div class="row">
                        <x-adminlte-input type="date" name="hiredate" label="Date Hired" placeholder="Date hired" fgroup-class="col-md-3" disable-feedback id="hiredate" wire:model="hiredate"/>


                        <x-adminlte-select2 name="company" label="Company/Organization" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="company">
                            <option>United Nations</option>
                            <option>World Bank</option>
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="education_level" label="Education Level" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="education_level">
                            @foreach ($educationLevels as $educationLevel)
                                <option value="{{$educationLevel}}" {{ $educationLevel == 'BSC' ? 'selected' : '' }}>{{$educationLevel}}</option>
                            @endforeach
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="project" label="Project" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="project">
                            <option>UN Aids</option>
                            <option>Cholera</option>
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="designation" label="Designation" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="designation">
                            <option>Accountant</option>
                            <option>Field Officer</option>
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="contract_type" label="Contract type" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="contract_type">
                            <option>Permanent</option>
                            <option>Part time</option>
                        </x-adminlte-select2>

                        <x-adminlte-input name="probation_period" label="Probation period:"
                        placeholder="Probation period" fgroup-class="col-md-4"
                        disable-feedback id="probation_period" wire:model="probation_period" wire:model="probation_period" required/>

                        <div class="col-md-4">
                            <div class="row input-group form-group-lg">
                                <x-adminlte-input name="termination_notice_period" label="Notice period:"
                                placeholder="Termination notice period" fgroup-class="col-md-8" disable-feedback id="termination_notice_period"  wire:model="termination_notice_period" required/>

                            <x-adminlte-select2 name="termination_notice_period_type" label="" wire:model="termination_notice_period_type" fgroup-class="col-md-4" data-placeholder="Select an option...">
                                @foreach ($terminationPeriodTypes as $terminationPeriodType)
                                    <option value="{{$terminationPeriodType}}" {{ $terminationPeriodType == 'Days' ? 'selected' : '' }}>{{$terminationPeriodType}}</option>
                                @endforeach
                            </x-adminlte-select2>
                            </div>
                        </div>

                        <x-adminlte-input type="date" name="contract_start_date" label="Contract start date:"
                        placeholder="Contract start date" fgroup-class="col-md-4"
                        disable-feedback id="start_date_contract" wire:model="contract_start_date" required/>

                        <x-adminlte-input type="date" name="contract_end_date" label="Contract end date:"
                        placeholder="Contract end date" fgroup-class="col-md-4"
                        disable-feedback id="contract_end_date" wire:model="contract_end_date" required/>

                        <x-adminlte-select2 name="designated_location" label="Designated Location" wire:model="designated_location" data-placeholder="Select an option..."
                        fgroup-class="col-md-4">
                            <option>Lilongwe</option>
                            <option>Salima</option>
                        </x-adminlte-select2>

                        <x-adminlte-input name="designated_location_specifics" label="Designated location other specifics:"
                        placeholder="Designated location other specifics" fgroup-class="col-md-4"
                        disable-feedback id="designated_location_specific" wire:model="designated_location_specifics" required/>

                </div>
            </div>
        </div>

        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Payroll details</p>
                <div class="row">
                    <x-adminlte-input name="basic_pay" label="Basic pay:"
                    placeholder="Basic pay" fgroup-class="col-md-4"
                    disable-feedback id="basic_pay" wire:model="basic_pay" required/>

                    <x-adminlte-select2 name="pay_period" label="Pay period" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="pay_period">
                        @foreach ($payPeriods as $payPeriod)
                            <option value="{{$payPeriod}}" {{ $payPeriod == 'Single' ? 'Monthly' : '' }}>{{$payPeriod}}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="tax" label="Tax" wire:model="tax" data-placeholder="Select an option..."
                        fgroup-class="col-md-4">
                            <option>None</option>
                            <option>Payee</option>
                    </x-adminlte-select2>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
