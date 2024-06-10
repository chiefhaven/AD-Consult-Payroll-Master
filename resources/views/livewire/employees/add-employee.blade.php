<div>
    <livewire:common.page-header pageTitle="{{ $pageTitle }}"/>
    <div class="col-lg-12">
    @include('includes/error')
    @section('plugins.Select2', true)
    <form wire:submit="save" autocomplete="off">
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Employee Details</p>
                <div class="row">
                        <x-adminlte-input type="text" name="prefix" label="Prefix" placeholder="Mr. Ms. Mrs" fgroup-class="col-md-2" class="{{ $errors->has('form.prefix') ? 'is-invalid' : '' }}"
                        id="prefix" wire:model="form.prefix" autocomplete="false"/>

                        <x-adminlte-input type="text" name="firstname" label="First name:*" placeholder="Firstname" fgroup-class="col-md-4" class="{{ $errors->has('form.firstname') ? 'is-invalid' : '' }}"
                        id="firstname" wire:model="form.firstname" autocomplete="false"/>

                        <x-adminlte-input type="text" name="middlename" label="Middle name:" placeholder="Middlename" fgroup-class="col-md-3" class="{{ $errors->has('form.middlename') ? 'is-invalid' : '' }}"
                        id="middlename" wire:model="form.middlename" autocomplete="false"/>

                        <x-adminlte-input type="text" name="lastname" label="Lastname:*" placeholder="Lastname" fgroup-class="col-md-3" class="{{ $errors->has('form.lastname') ? 'is-invalid' : '' }}"
                        id="surname" wire:model="form.lastname" autocomplete="false" required/>

                        <x-adminlte-input type="email" name="email" label="Email:*" placeholder="Email address" fgroup-class="col-md-4" class="{{ $errors->has('form.email') ? 'is-invalid' : '' }}"
                        id="email" wire:model="form.email" autocomplete="false" required/>

                        <x-adminlte-input type="tel" name="phone" label="Phone:*" placeholder="Phone" fgroup-class="col-md-3" class="{{ $errors->has('form.phone') ? 'is-invalid' : '' }}"
                        id="phone" wire:model="form.phone" autocomplete="false" required/>
                </div>
            </div>
        </div>
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>More information</p>
                <div class="row">
                        <x-adminlte-input type="date" name="date_of_birth" label="Date of birth:*" placeholder="Date of birth"
                        fgroup-class="col-md-2" class="{{ $errors->has('form.date_of_birth') ? 'is-invalid' : '' }}" id="date_of_birth" wire:model="form.date_of_birth" autocomplete="false" required/>

                        <x-adminlte-select type="text" name="gender" label="Gender:*" wire:model="form.gender" data-placeholder="Select an option..." fgroup-class="col-md-2" class="{{ $errors->has('form.gender') ? 'is-invalid' : '' }}" autocomplete="false" required>
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($genderEnums as $genderEnum)
                                <option>{{$genderEnum}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-select type="text" name="marital_status" label="Marital status:*" wire:model="form.marital_status"
                        data-placeholder="Select an option..." fgroup-class="col-md-2" class="{{ $errors->has('form.marital_status') ? 'is-invalid' : '' }}" autocomplete="false" required>
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($maritalStatusEnums as $maritalStatusEnum)
                                <option>{{$maritalStatusEnum}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-input type="text" name="employee_alt_number" label="Alternate phone number:"
                        placeholder="Alternate phone number" fgroup-class="col-md-3" class="{{ $errors->has('form.employee_alt_number') ? 'is-invalid' : '' }}" id="employee_alt_number" wire:model="form.employee_alt_number" autocomplete="false"/>

                        <x-adminlte-select type="text" name="nationality" label="Nationality:*" wire:model="form.nationality" data-placeholder="Select an option..." fgroup-class="col-md-3" class="{{ $errors->has('form.nationality') ? 'is-invalid' : '' }}" autocomplete="false" required>
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($countries as $country)
                                <option wire:key="{{ $country->name }}">{{$country->name}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-select type="text" name="id_type" wire:model="form.id_type" label="ID Type:*" data-placeholder="Select an option..." fgroup-class="col-md-2" class="{{ $errors->has('form.id_type') ? 'is-invalid' : '' }}" autocomplete="false" required>
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($idTypes as $idType)
                                <option>{{$idType}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-input name="id_number" label="ID number:*" placeholder="ID number"
                        fgroup-class="col-md-2" class="{{ $errors->has('form.id_number') ? 'is-invalid' : '' }}" id="id_number" wire:model="form.id_number" autocomplete="false" required/>

                        <x-adminlte-input name="resident_street" label="Resident street:*" placeholder="Resident street"
                        fgroup-class="col-md-2" class="{{ $errors->has('form.resident_street') ? 'is-invalid' : '' }}" id="resident_street" wire:model="form.resident_street" autocomplete="false" required/>

                        <x-adminlte-input name="resident_city" label="Resident city:*" placeholder="Resident city"
                        fgroup-class="col-md-2" id="resident_city" class="{{ $errors->has('form.resident_city') ? 'is-invalid' : '' }}" wire:model="form.resident_city" autocomplete="false" required/>

                        <x-adminlte-input name="resident_state" label="Resident state:*" placeholder="Resident state"
                        fgroup-class="col-md-2" class="{{ $errors->has('form.resident_state') ? 'is-invalid' : '' }}" id="resident_state" wire:model="form.resident_state" autocomplete="false" required/>

                        <x-adminlte-select type="text" name="resident_country" label="Resident country:*" wire:model="form.resident_country" data-placeholder="Select an option..."
                         fgroup-class="col-md-2" class="{{ $errors->has('form.resident_country') ? 'is-invalid' : '' }}" autocomplete="false" required>
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($countries as $country)
                                <option>{{$country->name}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-input name="permanent_city" label="Permanent street:" placeholder="Permanent street"
                        fgroup-class="col-md-3" class="{{ $errors->has('form.permanent_street') ? 'is-invalid' : '' }}" id="permanent_street" wire:model="form.permanent_street" autocomplete="false"/>

                        <x-adminlte-input name="permanent_city" label="Permanent city:" placeholder="Permanent city"
                        fgroup-class="col-md-3" class="{{ $errors->has('form.permanent_city') ? 'is-invalid' : '' }}" id="permanent_city" wire:model="form.permanent_city" autocomplete="false"/>

                        <x-adminlte-input name="permanent_state" label="Permanent state:" placeholder="Permanent state"
                        fgroup-class="col-md-3" class="{{ $errors->has('form.permanent_state') ? 'is-invalid' : '' }}" id="resident_state" wire:model="form.permanent_state" autocomplete="false"/>

                        <x-adminlte-select type="text" name="permanent_counrty" label="Permanent country:" wire:model="form.permanent_country" data-placeholder="Select an option..."
                         fgroup-class="col-md-3" class="{{ $errors->has('form.permanent_country') ? 'is-invalid' : '' }}" autocomplete="false">
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($countries as $country)
                                <option>{{$country->name}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-input name="family_contact_name" label="Family contact name:"
                        placeholder="Family contact name" fgroup-class="col-md-4" class="{{ $errors->has('form.family_contact_name') ? 'is-invalid' : '' }}" id="family_contact_name" wire:model="form.family_contact_name" autocomplete="false" required/>

                        <x-adminlte-input name="family_contact_number" label="Family contact number:"
                        placeholder="Family contact alt number" fgroup-class="col-md-4" class="{{ $errors->has('form.family_contact_number') ? 'is-invalid' : '' }}" id="family_contact_number" wire:model="form.family_contact_number" autocomplete="false" required/>

                        <x-adminlte-input name="family_contact_alt_number" label="Family contact alt number:"
                        placeholder="Family contact alt number" fgroup-class="col-md-4" class="{{ $errors->has('form.family_contact_alt_number') ? 'is-invalid' : '' }}" id="family_contact_alt_number" wire:model="form.family_contact_alt_number" autocomplete="false" required/>

                </div>
            </div>
        </div>

        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Employment details</p>
                        <div class="row">
                        <x-adminlte-input type="date" name="hiredate" label="Date Hired:" placeholder="Date hired"
                        fgroup-class="col-md-4" class="{{ $errors->has('form.hiredate') ? 'is-invalid' : '' }}" id="hiredate" wire:model="form.hiredate" autocomplete="false"/>


                        <x-adminlte-input type="text" name="client" label="Company/Organization:" list="clientOptions"
                        fgroup-class="col-md-4" class="{{ $errors->has('form.client') ? 'is-invalid' : '' }}" wire:model="form.client" wire:keydown="autocompleteclientSearch($event)" autocomplete="false"/>
                            <datalist id="clientOptions">
                                @if(isset($clients))
                                    @foreach ($clients as $client)
                                        <option>{{$client->client_name}}</option>
                                    @endforeach
                                @endif
                            </datalist>

                        <x-adminlte-select name="education_level" label="Education Level:" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" class="{{ $errors->has('form.education_level') ? 'is-invalid' : '' }}" wire:model="form.education_level" autocomplete="false">
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($educationLevels as $educationLevel)
                                <option>{{$educationLevel}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-select name="project" label="Project:" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" class="{{ $errors->has('form.project') ? 'is-invalid' : '' }}" wire:model="form.project" autocomplete="false">
                            <option value="null" selected disabled>Please select an option...</option>
                            <option>UN Aids</option>
                            <option>Cholera</option>
                        </x-adminlte-select>

                        <x-adminlte-select name="designation" label="Designation:" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" class="{{ $errors->has('form.designation') ? 'is-invalid' : '' }}" wire:model="form.designation" autocomplete="false">
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach (App\Models\Designation::all() as $designation)
                                <option>{{$designation->name}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-select name="contract_type" label="Contract type:" data-placeholder="Select an option..."
                        fgroup-class="col-md-4" class="{{ $errors->has('form.contract_type') ? 'is-invalid' : '' }}" wire:model="form.contract_type" autocomplete="false">
                            <option value="null" selected disabled>Please select an option...</option>
                            <option>Permanent</option>
                            <option>Part time</option>
                        </x-adminlte-select>

                        <x-adminlte-input name="probation_period" label="Probation period:"
                        placeholder="Probation period" fgroup-class="col-md-4" class="{{ $errors->has('form.probation_period') ? 'is-invalid' : '' }}" id="probation_period" wire:model="form.probation_period" wire:model="form.probation_period" autocomplete="false" required/>

                        <div class="col-md-4">
                            <div class="row input-group form-group-lg">
                                <x-adminlte-input name="termination_notice_period" label="Notice period:"
                                placeholder="Termination notice period" fgroup-class="col-md-8" class="{{ $errors->has('form.termination_notice_period') ? 'is-invalid' : '' }}" id="termination_notice_period"  wire:model="form.termination_notice_period" autocomplete="false" required/>

                            <x-adminlte-select name="termination_notice_period_type" label="Period type" wire:model="form.termination_notice_period_type" fgroup-class="col-md-4 m-0" class="{{ $errors->has('form.termination_notice_period_type') ? 'is-invalid' : '' }}" data-placeholder="Select an option..." autocomplete="false">
                                @foreach ($terminationPeriodTypes as $terminationPeriodType)
                                    <option>{{$terminationPeriodType}}</option>
                                @endforeach
                            </x-adminlte-select>
                            </div>
                        </div>

                        <x-adminlte-input type="date" name="contract_start_date" label="Contract start date:"
                        placeholder="Contract start date" fgroup-class="col-md-4" class="{{ $errors->has('form.start_date_contract') ? 'is-invalid' : '' }}" id="start_date_contract" wire:model="form.contract_start_date" autocomplete="false" required/>

                        <x-adminlte-input type="date" name="contract_end_date" label="Contract end date:"
                        placeholder="Contract end date" fgroup-class="col-md-4" class="{{ $errors->has('form.contract_end_date') ? 'is-invalid' : '' }}" id="contract_end_date" wire:model="form.contract_end_date" autocomplete="false" required/>

                        <x-adminlte-select name="designated_location" label="Designated Location" wire:model="form.designated_location" data-placeholder="Select an option..." fgroup-class="col-md-4" class="{{ $errors->has('form.designated_location') ? 'is-invalid' : '' }}" autocomplete="false">
                            <option value="null" selected disabled>Please select an option...</option>
                            @foreach ($districts as $district)
                                <option wire:key="{{ $district->name }}">{{$district->name}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-input name="designated_location_specifics" label="Designated location other specifics:" placeholder="Designated location other specifics" fgroup-class="col-md-4" class="{{ $errors->has('form.designated_location_specifics') ? 'is-invalid' : '' }}" id="designated_location_specific" wire:model="form.designated_location_specifics" autocomplete="false"/>

                </div>
            </div>
        </div>

        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Payroll details</p>
                <div class="row">
                    <x-adminlte-input name="basic_pay" label="Basic pay:"
                    placeholder="Basic pay" fgroup-class="col-md-4" class="{{ $errors->has('form.basic_pay') ? 'is-invalid' : '' }}" id="basic_pay" wire:model="form.basic_pay" autocomplete="false" required/>

                    <x-adminlte-select name="pay_period" label="Pay period"
                        fgroup-class="col-md-4" class="{{ $errors->has('form.pay_period') ? 'is-invalid' : '' }}" wire:model="form.pay_period" autocomplete="false">
                        <option value="null" selected disabled>Please select an option...</option>
                        @foreach ($payPeriods as $payPeriod)
                            <option>{{$payPeriod}}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-input type="checkbox" name="paye" label="Paye:" fgroup-class="checkbox" class="{{ $errors->has('form.paye') ? 'is-invalid' : '' }}" id="paye" wire:model="form.paye" checked autocomplete="false"/>
                </div>
            </div>
        </div>

        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Login details <figcaption class="blockquote-footer">
                    Leave blank to auto generate credentials
                  </figcaption></p>
                <div class="row">
                        <x-adminlte-input type="text" name="confirm_password" label="Username" placeholder="Username"
                        fgroup-class="col-md-3" id="username" wire:model="form.username" autocomplete="false"/>

                        <x-adminlte-input type="password" name="confirm_password" label="Password" placeholder="Password"
                        fgroup-class="col-md-3" id="password" wire:model="form.password" autocomplete="false"/>

                        <x-adminlte-input type="password" name="confirm_password" label="Confirm Password" placeholder="Password"
                        fgroup-class="col-md-3" id="confirm_password" wire:model="form.confirm_password" autocomplete="false"/>

                        <x-adminlte-input type="checkbox" name="allow_login" label="Allow Login:*" fgroup-class="checkbox" class="{{ $errors->has('form.allow_login') ? 'is-invalid' : '' }}"
                        id="phone" wire:model="form.allow_login" autocomplete="false"/>

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
</div>
