<div class="col-lg-12">
    @section('plugins.Select2', true)
    <form wire:submit="save">
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Client Details</p>
                <div class="row">
                        <x-adminlte-input type="text" name="name" label="Name:*" placeholder="Name" fgroup-class="col-md-3"
                        disable-feedback id="name" wire:model="name" required/>

                        <x-adminlte-input-file name="client_logo" label="Client logo" placeholder="Choose a file..."
                        fgroup-class="col-md-3" disable-feedback/>

                        <x-adminlte-input type="email" name="email" label="Email:*" placeholder="Email address" fgroup-class="col-md-3"
                        disable-feedback id="email" wire:model="email" required/>

                        <x-adminlte-input type="tel" name="phone" label="Phone:*" placeholder="Phone" fgroup-class="col-md-3"
                        disable-feedback id="phone" wire:model="phone" required/>

                        <x-adminlte-select2 type="option" name="project" label="Project:" placeholder="Select an option..."
                        fgroup-class="col-md-4">
                            <option>UN Aids</option>
                            <option>Cholera</option>
                        </x-adminlte-select2>

                        <x-adminlte-input type="date" name="contractstartdate" label="Contract start date:" placeholder="Contract start date:"
                        fgroup-class="col-md-4" disable-feedback id="contractstartdate" wire:model="contractstartdate"/>

                        <x-adminlte-input type="date" name="contractenddate" label="Contract end date:" placeholder="Contract end date"
                        fgroup-class="col-md-4" disable-feedback id="contractenddate" wire:model="contractenddate"/>

                </div>
            </div>
        </div>
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>More information</p>
                <div class="row">
                    <x-adminlte-input type="text" name="street_address" label="Street Adress:*"
                    placeholder="Street address" fgroup-class="col-md-3"
                    disable-feedback id="street_address" wire:model="street_address" required/>

                    <x-adminlte-input type="text" name="street_address_2" label="Street Adress 2:"
                    placeholder="Street address 2" fgroup-class="col-md-3"
                    id="street_address_2" wire:model="street_address_2"/>

                    <x-adminlte-input type="text" name="postal_code" label="Postal/Zip code:"
                    placeholder="Postal/Zip code" fgroup-class="col-md-3"
                    id="postal_code" wire:model="postal_code"/>

                    <x-adminlte-input type="text" name="city" label="City:*"
                    placeholder="City" fgroup-class="col-md-3"
                    id="city" wire:model="city" required/>

                    <x-adminlte-input type="text" name="state" label="State/Region/Province:"
                    placeholder="State/Region/Province" fgroup-class="col-md-4"
                     id="state" wire:model="state" required/>

                    <x-adminlte-select2 type="text" name="country" label="Country" wire:model="country" data-placeholder="Select an option..."
                        fgroup-class="col-md-4">
                        @foreach ($countries as $country)
                            <option {{ $country->name == 'Malawi' ? 'selected' : '' }}>{{$country->name}}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-input type="website" name="website" label="Website:"
                    placeholder="Website" fgroup-class="col-md-4"
                     id="website" wire:model="website"/>

                    <x-adminlte-input type="text" name="tax_number" label="Tax number:"
                    placeholder="Tax number" fgroup-class="col-md-3" id="tax_number" wire:model="tax_number"/>

                    <x-adminlte-input type="text" name="tax_label" label="Tax label:"
                    placeholder="Tax label" fgroup-class="col-md-3" id="tax_label" wire:model="tax_label"/>

                    <x-adminlte-input type="text" name="tax_number_2" label="Tax number 2:"
                    placeholder="Tax number 2" fgroup-class="col-md-3" id="tax_number_2" wire:model="tax_number_2"/>

                    <x-adminlte-input type="text" name="tax_number_label_2" label="Tax label 2:"
                    placeholder="Tax label 2" fgroup-class="col-md-3" id="tax_label_2" wire:model="tax_label_2"/>
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
                        fgroup-class="col-md-4" disable-feedback id="username" wire:model="username"/>

                        <x-adminlte-input type="password" name="confirm_password" label="Password" placeholder="Password"
                        fgroup-class="col-md-4" disable-feedback id="password" wire:model="password"/>

                        <x-adminlte-input type="password" name="confirm_password" label="Confirm Password" placeholder="Password"
                        fgroup-class="col-md-4" disable-feedback id="confirm_password" wire:model="confirm_password"/>

                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
