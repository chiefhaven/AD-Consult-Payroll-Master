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

                        <x-adminlte-input type="text" name="lastname" label="Lastname:*" placeholder="Lastname" fgroup-class="col-md-3"
                        id="surname" wire:model="form.lastname" required/>

                        <x-adminlte-input type="email" name="email" label="Email:*" placeholder="Email address" fgroup-class="col-md-4"
                        id="email" wire:model="form.email" required/>

                        <x-adminlte-input type="tel" name="phone" label="Phone:*" placeholder="Phone" fgroup-class="col-md-3"
                        id="phone" wire:model="form.phone" required/>

                        <x-adminlte-input type="checkbox" name="allow_login" label="Allow Login:*"
                        id="phone" wire:model="form.allow_login" checked required/>
                </div>
            </div>
        </div>
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>More information</p>
                <div class="row">
                        <x-adminlte-input type="date" name="date_of_birth" label="Date of birth:*" placeholder="Date of birth"
                        fgroup-class="col-md-3" id="date_of_birth" wire:model="form.date_of_birth" required/>

                        <x-adminlte-select type="text" name="gender" label="Gender:*" wire:model="form.gender" data-placeholder="Select an option..."
                        fgroup-class="col-md-3" required>
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($genderEnums as $genderEnum)
                                <option>{{$genderEnum}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-select type="text" name="marital_status" label="Marital status:*" wire:model="form.marital_status"
                        data-placeholder="Select an option..." fgroup-class="col-md-2" required>
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($maritalStatusEnums as $maritalStatusEnum)
                                <option>{{$maritalStatusEnum}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-input type="text" name="employee_alt_number" label="Alternate phone number:"
                        placeholder="Alternate phone number" fgroup-class="col-md-4"
                        id="employee_alt_number" wire:model="form.employee_alt_number"/>

                        <x-adminlte-select type="text" name="nationality" label="Nationality:*" wire:model="form.nationality" data-placeholder="Select an option..."
                         fgroup-class="col-md-3" required>
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($countries as $country)
                                <option wire:key="{{ $country->name }}">{{$country->name}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-select type="text" name="id_type" wire:model="form.id_type" label="ID Type:*" data-placeholder="Select an option..."
                         fgroup-class="col-md-3" required>
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($idTypes as $idType)
                                <option>{{$idType}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-input name="id_number" label="ID number:*" placeholder="ID number"
                        fgroup-class="col-md-3" id="id_number" wire:model="form.id_number" required/>

                        <x-adminlte-input-file name="id_proof" label="Upload ID proof:*" placeholder="Choose a file..."
                        fgroup-class="col-md-3" wire:model="form.id_proof" wire:model="form.id_proof"/>

                        <x-adminlte-input name="resident_street" label="Resident street:*" placeholder="Resident street"
                        fgroup-class="col-md-3" id="resident_street" wire:model="form.resident_street" required/>

                        <x-adminlte-input name="resident_city" label="Resident city:*" placeholder="Resident city"
                        fgroup-class="col-md-3" id="resident_city" wire:model="form.resident_city" required/>

                        <x-adminlte-input name="resident_state" label="Resident state:*" placeholder="Resident state"
                        fgroup-class="col-md-3" id="resident_state" wire:model="form.resident_state" required/>

                        <x-adminlte-select type="text" name="resident_country" label="Resident country:*" wire:model="form.resident_country" data-placeholder="Select an option..."
                         fgroup-class="col-md-3" required>
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($countries as $country)
                                <option>{{$country->name}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-input name="permanent_city" label="Permanent street:" placeholder="Permanent street"
                        fgroup-class="col-md-3" id="permanent_street" wire:model="form.permanent_street" />

                        <x-adminlte-input name="permanent_city" label="Permanent city:" placeholder="Permanent city"
                        fgroup-class="col-md-3" id="permanent_city" wire:model="form.permanent_city" />

                        <x-adminlte-input name="permanent_state" label="Permanent state:" placeholder="Permanent state"
                        fgroup-class="col-md-3" id="resident_state" wire:model="form.permanent_state" />

                        <x-adminlte-select type="text" name="permanent_counrty" label="Permanent country:" wire:model="form.permanent_country" data-placeholder="Select an option..."
                         fgroup-class="col-md-3">
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($countries as $country)
                                <option>{{$country->name}}</option>
                            @endforeach
                        </x-adminlte-select>

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
                        <x-adminlte-input type="date" name="hiredate" label="Date Hired:" placeholder="Date hired"
                        fgroup-class="col-md-4" id="hiredate" wire:model="form.hiredate"/>


                        <x-adminlte-input type="text" name="client" label="Company/Organization:" list="clientOptions"
                        fgroup-class="col-md-4" wire:model="form.client" wire:keydown="autocompleteclientSearch($event)" />
                            <datalist id="clientOptions">
                                @if(isset($clients))
                                    @foreach ($clients as $client)
                                        <option>{{$client->client_name}}</option>
                                    @endforeach
                                @endif
                            </datalist>

                        <x-adminlte-select name="education_level" label="Education Level:" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="form.education_level">
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($educationLevels as $educationLevel)
                                <option>{{$educationLevel}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-select name="project" label="Project:" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="form.project">
                            <option value="null" selected disabled>Please select an option...</option>
                            <option>UN Aids</option>
                            <option>Cholera</option>
                        </x-adminlte-select>

                        <x-adminlte-select name="designation" label="Designation:" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="form.designation">
                            <option value="null" selected disabled>Please select an option...</option>
                            <option>Accountant</option>
                            <option>Field Officer</option>
                        </x-adminlte-select>

                        <x-adminlte-select name="contract_type" label="Contract type:" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" wire:model="form.contract_type">
                            <option value="null" selected disabled>Please select an option...</option>
                            <option>Permanent</option>
                            <option>Part time</option>
                        </x-adminlte-select>

                        <x-adminlte-input name="probation_period" label="Probation period:"
                        placeholder="Probation period" fgroup-class="col-md-4"
                        id="probation_period" wire:model="form.probation_period" wire:model="form.probation_period" required/>

                        <div class="col-md-4">
                            <div class="row input-group form-group-lg">
                                <x-adminlte-input name="termination_notice_period" label="Notice period:"
                                placeholder="Termination notice period" fgroup-class="col-md-8" id="termination_notice_period"  wire:model="form.termination_notice_period" required/>

                            <x-adminlte-select name="termination_notice_period_type" label="" wire:model="form.termination_notice_period_type" fgroup-class="col-md-4" data-placeholder="Select an option...">
                                @foreach ($terminationPeriodTypes as $terminationPeriodType)
                                    <option>{{$terminationPeriodType}}</option>
                                @endforeach
                            </x-adminlte-select>
                            </div>
                        </div>

                        <x-adminlte-input type="date" name="contract_start_date" label="Contract start date:"
                        placeholder="Contract start date" fgroup-class="col-md-4"
                        id="start_date_contract" wire:model="form.contract_start_date" required/>

                        <x-adminlte-input type="date" name="contract_end_date" label="Contract end date:"
                        placeholder="Contract end date" fgroup-class="col-md-4"
                        id="contract_end_date" wire:model="form.contract_end_date" required/>

                        <x-adminlte-select name="designated_location" label="Designated Location" wire:model="form.designated_location" data-placeholder="Select an option..."
                        fgroup-class="col-md-4">
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($districts as $district)
                                <option wire:key="{{ $district->name }}">{{$district->name}}</option>
                            @endforeach
                        </x-adminlte-select>

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

                    <x-adminlte-select name="pay_period" label="Pay period"
                        fgroup-class="col-md-4" wire:model="form.pay_period">
                        <option value="null" selected disabled>Please select an option...</option>
                        @foreach ($payPeriods as $payPeriod)
                            <option>{{$payPeriod}}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select name="tax" label="Applicable Tax" wire:model="form.tax" fgroup-class="col-md-4">
                            <option selected >Please select an option...</option>
                            <option>None</option>
                            <option>Payee</option>
                    </x-adminlte-select>
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
