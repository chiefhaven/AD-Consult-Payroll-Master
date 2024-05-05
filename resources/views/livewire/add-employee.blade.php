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
                        <x-adminlte-input name="prefix" label="Date of birth" placeholder="Date of birth" fgroup-class="col-md-3"
                        disable-feedback id="" wire:model="date_of_birth"/>

                        <x-adminlte-select2 name="gender" label="Gender" data-placeholder="Select an option..." fgroup-class="col-md-3">
                            <option>Select gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </x-adminlte-select2>

                        <x-adminlte-input name="marital_status" label="Marital status" placeholder="Marital status" fgroup-class="col-md-2"
                        disable-feedback id="marital_status" wire:model="marital_status" required/>

                        <x-adminlte-input name="alternate_phone_number" label="Alternate phone number:" placeholder="Alternate phone number" fgroup-class="col-md-4"
                        disable-feedback id="alternate_phone_number" wire:model="alternate_phone_number" required/>

                        <x-adminlte-input name="family_contact_number" label="Family contact number:" placeholder="Family contact number" fgroup-class="col-md-3"
                        disable-feedback id="family_contact_number" wire:model="family_contact_number" required/>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
