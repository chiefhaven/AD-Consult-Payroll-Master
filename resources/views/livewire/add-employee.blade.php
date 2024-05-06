<div class="col-lg-12">
    @section('plugins.Select2', true)
    <form wire:submit="save">
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Employee Details</p>
                <div class="row">
                        <x-adminlte-input name="prefix" label="Prefix" placeholder="Mr. Ms. Mrs" fgroup-class="col-md-2"
                        disable-feedback id="" wire:model="prefix"/>

                        <x-adminlte-input name="firstname" label="First name:*" placeholder="Firstname" fgroup-class="col-md-4"
                        disable-feedback id="firstname" wire:model="firstname" required/>

                        <x-adminlte-input name="middlename" label="Middle name:" placeholder="Middlename" fgroup-class="col-md-3"
                        disable-feedback id="middlename" wire:model="middlename" required/>

                        <x-adminlte-input name="surname" label="Surname:" placeholder="Surname" fgroup-class="col-md-3"
                        disable-feedback id="surname" wire:model="surname" required/>

                        <x-adminlte-input name="email" label="Email:*" placeholder="Email address" fgroup-class="col-md-4"
                        disable-feedback id="email" wire:model="email" required/>

                        <x-adminlte-input name="phone" label="Phone:*" placeholder="Phone" fgroup-class="col-md-3"
                        disable-feedback id="phone" wire:model="phone" required/>
                </div>
            </div>
        </div>
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>More information</p>
                <div class="row">
                        <x-adminlte-input name="prefix" label="Date of birth" placeholder="Date of birth"
                        fgroup-class="col-md-3"
                        disable-feedback id="" wire:model="date_of_birth"/>

                        <x-adminlte-select2 name="gender" label="Gender" data-placeholder="Select an option..."
                        fgroup-class="col-md-3">
                            <option>Select gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="martial_status" label="Marital status" data-placeholder="Select an option..."
                        fgroup-class="col-md-2">
                            <option>Select status</option>
                            <option>Maried</option>
                            <option>Single</option>
                        </x-adminlte-select2>

                        <x-adminlte-input name="alternate_phone_number" label="Alternate phone number:"
                        placeholder="Alternate phone number" fgroup-class="col-md-4"
                        disable-feedback id="alternate_phone_number" wire:model="alternate_phone_number" required/>

                        <x-adminlte-select2 name="nationality" label="Nationality" data-placeholder="Select an option..."
                         fgroup-class="col-md-3">
                            <option>Select nation</option>
                            <option>Malawian</option>
                            <option>Zambian</option>
                            <option>Other</option>
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="id_proof_name" label="ID proof name" data-placeholder="Select an option..."
                         fgroup-class="col-md-3">
                            <option>Select ID</option>
                            <option>NRB</option>
                            <option>Passport</option>
                            <option>Other</option>
                        </x-adminlte-select2>

                        <x-adminlte-input name="id_number" label="ID number:" placeholder="ID number"
                        fgroup-class="col-md-3" disable-feedback id="id_number" wire:model="id_number" required/>

                        <x-adminlte-input-file name="ifLabel" label="Upload ID proof" placeholder="Choose a file..."
                        fgroup-class="col-md-3" disable-feedback/>

                        <x-adminlte-textarea name="current_address" label="Current Address" rows=5
                            igroup-size="sm" placeholder="Enter employee current residence" fgroup-class="col-md-6">
                        </x-adminlte-textarea>

                        <x-adminlte-textarea name="permanent_address" label="Permanent Address" rows=5
                            igroup-size="sm" placeholder="Enter employee permanent/home address" fgroup-class="col-md-6">
                        </x-adminlte-textarea>

                        <x-adminlte-input name="family_contact_name" label="Family contact name:"
                        placeholder="Family contact name" fgroup-class="col-md-4"
                        disable-feedback id="family_contact_name" wire:model="family_contact_name" required/>

                        <x-adminlte-input name="family_contact_number" label="Family contact number:"
                        placeholder="Family contact alt number" fgroup-class="col-md-4"
                        disable-feedback id="family_contact_number" wire:model="family_contact_number" required/>

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
                        <x-adminlte-select2 name="company" label="Company/Organization" data-placeholder="Select an option..."
                        fgroup-class="col-md-4">
                            <option>United Nations</option>
                            <option>World Bank</option>
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="designation" label="Designation" data-placeholder="Select an option..."
                        fgroup-class="col-md-4">
                            <option>Accountant</option>
                            <option>Field Officer</option>
                        </x-adminlte-select2>

                        <x-adminlte-select2 name="designated_location" label="Designated Location" data-placeholder="Select an option..."
                        fgroup-class="col-md-4">
                            <option>Lilongwe</option>
                            <option>Salima</option>
                        </x-adminlte-select2>

                        <x-adminlte-input name="designated_location_specific" label="Designated location other specific:"
                        placeholder="Designated location other specific" fgroup-class="col-md-4"
                        disable-feedback id="designated_location_specific" wire:model="designated_location_specific" required/>

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
                        fgroup-class="col-md-4">
                            <option>Hourly</option>
                            <option>Daily</option>
                            <option>Weekly</option>
                            <option>Fortnightly</option>
                            <option>Monthly</option>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="tax" label="Tax" data-placeholder="Select an option..."
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
