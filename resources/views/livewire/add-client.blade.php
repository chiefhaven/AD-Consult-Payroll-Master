<div class="col-lg-12">
    @section('plugins.Select2', true)
    <form wire:submit="save">
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Client Details</p>
                <div class="row">
                        <x-adminlte-input name="name" label="Name:*" placeholder="Name" fgroup-class="col-md-4"
                        disable-feedback id="name" wire:model="name" required/>

                        <x-adminlte-input name="email" label="Email:*" placeholder="Email address" fgroup-class="col-md-4"
                        disable-feedback id="email" wire:model="email" required/>

                        <x-adminlte-input name="phone" label="Phone:" placeholder="Phone" fgroup-class="col-md-3"
                        disable-feedback id="phone" wire:model="phone" required/>

                        <x-adminlte-input-file name="client_logo" label="Client logo" placeholder="Choose a file..."
                        fgroup-class="col-md-3" disable-feedback/>

                        <x-adminlte-select2 name="project" label="Project" data-placeholder="Select an option..."
                        fgroup-class="col-md-3">
                            <option>Select gender</option>
                            <option>UN Aids</option>
                            <option>Cholera</option>
                        </x-adminlte-select2>
                </div>
            </div>
        </div>
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>More information</p>
                <div class="row">
                        <x-adminlte-textarea name="address_1" label="Address 1" rows=5
                            igroup-size="sm" placeholder="Address 1" fgroup-class="col-md-6">
                        </x-adminlte-textarea>

                        <x-adminlte-textarea name="address_2" label="Address_1" rows=5
                            igroup-size="sm" placeholder="Enter address 2" fgroup-class="col-md-6">
                        </x-adminlte-textarea>

                        <x-adminlte-input name="city" label="City:"
                        placeholder="City" fgroup-class="col-md-3"
                        disable-feedback id="city" wire:model="city" required/>

                        <x-adminlte-input name="state" label="State/Region/Province:"
                        placeholder="State/Region/Province" fgroup-class="col-md-3"
                        disable-feedback id="state" wire:model="state" required/>

                        <x-adminlte-select2 name="country" label="Country" data-placeholder="Select an option..."
                         fgroup-class="col-md-3">
                            <option>Select Country</option>
                            <option>Malawi</option>
                            <option>Zambia</option>
                            <option>Germany</option>
                        </x-adminlte-select2>

                        <x-adminlte-input name="website" label="Website:"
                        placeholder="Website" fgroup-class="col-md-3"
                        disable-feedback id="website" wire:model="website" required/>
                </div>
            </div>
        </div>
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Login details</p>
                <div class="row">
                        <x-adminlte-input name="confirm_password" label="Username" placeholder="Username"
                        fgroup-class="col-md-4" disable-feedback id="username" wire:model="username"/>

                        <x-adminlte-input name="confirm_password" label="Password" placeholder="Password"
                        fgroup-class="col-md-4" disable-feedback id="password" wire:model="password"/>

                        <x-adminlte-input name="confirm_password" label="Confirm Password" placeholder="Password"
                        fgroup-class="col-md-4" disable-feedback id="confirm_password" wire:model="confirm_password"/>

                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
