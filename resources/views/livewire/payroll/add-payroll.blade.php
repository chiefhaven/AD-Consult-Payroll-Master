<div>
    <div class="col-lg-12">
        @include('includes/error')
        @section('plugins.Select2', true)
        <div class="card mb-3 p-4">
            <div class="box-body">
                <h3>For Client: <strong>{{ $client }}</strong></h3>
            </div>
        </div>
        <form wire:submit="save" autocomplete="off">
            <x-adminlte-input type="text" name="client" label="client"
                id="client" wire:model="client" autocomplete="false"/>
            <div class="card mb-3 p-4">
                <div class="box-body">
                    <p>Options</p>
                    <div class="row">
                        <x-adminlte-input type="text" name="group" label="Group" placeholder="Month/Year" fgroup-class="col-12" class="{{ $errors->has('form.group') ? 'is-invalid' : '' }}" id="group" wire:model="form.group" autocomplete="off"/>

                        <x-adminlte-input type="text" name="employees" label="Select employees" placeholder="Employees" fgroup-class="col-12" class="{{ $errors->has('form.employees') ? 'is-invalid' : '' }}" id="employees" wire:model="form.employees" autocomplete="off"/>

                        <x-adminlte-input type="text" name="middlename" label="Middle name:" placeholder="Middlename" fgroup-class="col-md-3" class="{{ $errors->has('form.middlename') ? 'is-invalid' : '' }}" id="middlename" wire:model="form.middlename" autocomplete="false"/>

                        <x-adminlte-input type="text" name="lastname" label="Lastname:*" placeholder="Lastname" fgroup-class="col-md-3" class="{{ $errors->has('form.lastname') ? 'is-invalid' : '' }}"
                            id="surname" wire:model="form.lastname" autocomplete="false" required/>

                        <x-adminlte-input type="email" name="email" label="Email:*" placeholder="Email address" fgroup-class="col-md-4" class="{{ $errors->has('form.email') ? 'is-invalid' : '' }}"
                            id="email" wire:model="form.email" autocomplete="false" required/>

                        <x-adminlte-input type="tel" name="phone" label="Phone:*" placeholder="Phone" fgroup-class="col-md-3" class="{{ $errors->has('form.phone') ? 'is-invalid' : '' }}"
                            id="phone" wire:model="form.phone" autocomplete="false" required/>
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
