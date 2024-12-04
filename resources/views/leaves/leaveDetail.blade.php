<div class="modal fade text-left" id="leaveDatail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _('Leave Details') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="row p-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col md-6">
                                                <div class="card p-2">
                                                   <h5>Employee ID</h5>
                                                    <p>  @{{ selectedLeave.employee_no }}</p>
                                                </div>
                                            </div>

                                            <div class="col md-6">
                                                <div class="card p-2">
                                                    <h5>Name</h5>
                                                    <p>@{{ selectedLeave.Name }}  @{{ selectedLeave.Surname }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h6>Leave Type</h6>
                                                <p class="card p-2">@{{ selectedLeave.Type }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <h6>Status</h6>
                                                <p class="card p-2">@{{ selectedLeave.Status }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <h6>Application Date</h6>
                                                <p class="card p-2"> @{{ selectedLeave.start_date }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6>Reason here</h6>
                                                <p class="card p-2">@{{ selectedLeave.Reason }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6>Leave Records</h6>
                                                <p>records here</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
