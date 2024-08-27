<div>
<livewire:common.page-header pageTitle="{{ $pageTitle }}"/>
<div class="col-lg-12">
    @include('includes/error')
    @section('plugins.Select2', true)
    <form wire:submit="save" autocomplete="off">
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Client Details</p>
                <div class="row">
                        <x-adminlte-input type="text" name="name" label="Name:*" placeholder="Name" fgroup-class="col-md-4" class="{{ $errors->has('form.name') ? 'is-invalid' : '' }}" id="name" wire:model="form.name" required/>

                        <x-adminlte-input type="email" name="email" label="Email:*" placeholder="Email address" fgroup-class="col-md-4" class="{{ $errors->has('form.email') ? 'is-invalid' : '' }}" id="email" wire:model="form.email" required/>

                        <x-adminlte-input type="tel" name="phone" label="Phone:*" placeholder="Phone" fgroup-class="col-md-4" class="{{ $errors->has('form.phone') ? 'is-invalid' : '' }}" id="phone" wire:model="form.phone" required/>

                        <x-adminlte-input type="text" name="project" label="Project:" placeholder="Project" fgroup-class="col-md-3" class="{{ $errors->has('form.project') ? 'is-invalid' : '' }}"
                        id="project" wire:model="form.project"/>

                        <x-adminlte-select type="text" name="industry" label="Industry:" wire:model="form.industry" placeholder="Select an option..." fgroup-class="col-md-3" class="{{ $errors->has('form.industry') ? 'is-invalid' : '' }}">
                            <option value="" selected disabled>Please select an option...</option>
                            @foreach ($industries as $industries)
                                <option>{{$industries->name}}</option>
                            @endforeach
                        </x-adminlte-select>

                        <x-adminlte-input type="date" name="contractstartdate" label="Contract start date:" placeholder="Contract start date:"
                        fgroup-class="col-md-3" class="{{ $errors->has('form.contractstartdate') ? 'is-invalid' : '' }}" id="contractstartdate" wire:model="form.contractstartdate" required/>

                        <x-adminlte-input type="date" name="contractenddate" label="Contract end date:" placeholder="Contract end date"
                        fgroup-class="col-md-3" class="{{ $errors->has('form.contractenddate') ? 'is-invalid' : '' }}" id="contractenddate" wire:model="form.contractenddate"/>

                </div>
            </div>
        </div>
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>More information</p>
                <div class="row">
                    <x-adminlte-input type="tel" name="phone2" label="Alternative Phone:*" placeholder="Alternative Phone" fgroup-class="col-md-3" class="{{ $errors->has('form.phone2') ? 'is-invalid' : '' }}"
                        id="phone2" wire:model="form.phone2"/>

                    <x-adminlte-input type="text" name="street_address" label="Street Adress:*"
                    placeholder="Street address" fgroup-class="col-md-3" class="{{ $errors->has('form.street_address') ? 'is-invalid' : '' }}" id="street_address" wire:model="form.street_address"/>

                    <x-adminlte-input type="text" name="street_address_2" label="Street Adress 2:"
                    placeholder="Street address 2" fgroup-class="col-md-3" class="{{ $errors->has('form.street_address_2') ? 'is-invalid' : '' }}" id="street_address_2" wire:model="form.street_address_2"/>

                    <x-adminlte-input type="text" name="postal_code" label="Postal/Zip code:"
                    placeholder="Postal/Zip code" fgroup-class="col-md-3" class="{{ $errors->has('form.postal_code') ? 'is-invalid' : '' }}" id="postal_code" wire:model="form.postal_code"/>

                    <x-adminlte-input type="text" name="city" label="City:*"
                    placeholder="City" fgroup-class="col-md-4" class="{{ $errors->has('form.city') ? 'is-invalid' : '' }}" id="city" wire:model="form.city" required/>

                    <x-adminlte-input type="text" name="state" label="State/Region/Province:"
                    placeholder="State/Region/Province" fgroup-class="col-md-4" class="{{ $errors->has('form.state') ? 'is-invalid' : '' }}" id="state" wire:model="form.state"/>

                    <x-adminlte-select type="text" name="country" label="Country" wire:model="form.country" data-placeholder="Select an option..." fgroup-class="col-md-4" class="{{ $errors->has('form.country') ? 'is-invalid' : '' }}" autocomplete="false">
                        <option value="" disabled>Please select an option...</option>
                        @foreach ($countries as $country)
                            <option>{{$country->name}}</option>
                        @endforeach
                    </x-adminlte-select>

                    <x-adminlte-input type="text" name="tax_number" label="Tax number:"
                    placeholder="Tax number" fgroup-class="col-md-3" class="{{ $errors->has('form.tax_number') ? 'is-invalid' : '' }}" id="tax_number" wire:model="form.tax_number"/>

                    <x-adminlte-input type="text" name="tax_label" label="Tax label:"
                    placeholder="Tax label" fgroup-class="col-md-3" class="{{ $errors->has('form.tax_label') ? 'is-invalid' : '' }}" id="tax_label" wire:model="form.tax_label"/>

                    <x-adminlte-input type="text" name="tax_number_2" label="Tax number 2:"
                    placeholder="Tax number 2" fgroup-class="col-md-3" class="{{ $errors->has('form.tax_number_2') ? 'is-invalid' : '' }}" id="tax_number_2" wire:model="form.tax_number_2"/>

                    <x-adminlte-input type="text" name="tax_number_label_2" label="Tax label 2:"
                    placeholder="Tax label 2" fgroup-class="col-md-3" class="{{ $errors->has('form.tax_label_2') ? 'is-invalid' : '' }}" id="tax_label_2" wire:model="form.tax_label_2"/>

                    <x-adminlte-input type="website" name="website" label="Website:"
                    placeholder="Website" fgroup-class="col-md-4" class="{{ $errors->has('form.website') ? 'is-invalid' : '' }}" id="website" wire:model="form.website"/>
                </div>
            </div>
        </div>
        <div class="card mb-3 p-4">
            <div class="box-body">
                <p>Login details <figcaption class="blockquote-footer">
                    Leave blank to auto generate credentials
                  </figcaption></p>
                <div class="row">
                        <x-adminlte-input type="text" name="username" label="Username" placeholder="Username"
                        fgroup-class="col-md-4" class="{{ $errors->has('form.username') ? 'is-invalid' : '' }}" id="username" wire:model="form.username"/>

                        <x-adminlte-input type="password" name="password" label="Password" placeholder="Password" fgroup-class="col-md-4" class="{{ $errors->has('form.password') ? 'is-invalid' : '' }}" id="password" wire:model="form.password"/>

                        <x-adminlte-input type="password" name="confirm_password" label="Confirm Password" placeholder="Password" fgroup-class="col-md-4" class="{{ $errors->has('form.confirm_password') ? 'is-invalid' : '' }}" id="confirm_password" wire:model="form.confirm_password"/>

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
