<div>
    <div class="card p-5 employee-profile-header">
        <div class="row">
            <div class="col-md-3">
                <img class="" src="/img/employee-profile.jpg" height="auto" width="100%">
            </div>
            <div class="col-md-1"><p>&nbsp;</p></div>
            <div class="col-md-8">
                <h2 class="text-white fw-bold">Azena and Co.</h2>
                <div class="text-bold">Sologan</div>
                <p class="text-white">
                    <div class="text-white">Address:</div>
                    <div class="text-white">Phone:</div>
                    <div class="text-white">Email:</div>
                </p>
            </div>
        </div>
    </div>
    <div class="row m-4">
        <div class="col-md-4">
            <x-adminlte-small-box title="20" text="Employees" icon="fas fa-users text-dark"
            theme="warning" url="#" url-text="Reputation history" id="sbUpdatable"/>
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box title="K100,000" text="Unpaid Invoices" icon="fas fa-medal text-dark"
            theme="danger" url="#" url-text="Reputation history" id="sbUpdatable"/>
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box title="30" text="Reputation" icon="fas fa-medal text-dark"
            theme="primary" url="#" url-text="Reputation history" id="sbUpdatable"/>
        </div>
    </div>
    <div class="row m-4">
        <div class="col-md-5 card p-5">
            <livewire:employees.employeeList />
        </div>
        <div class="col-md-1">
            &nbsp;
        </div>
        <div class="col-md-3 card p-5">
            Upcoming events
        </div>
    </div>
</div>
