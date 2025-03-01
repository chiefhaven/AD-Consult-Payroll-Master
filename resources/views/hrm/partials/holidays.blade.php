<div id="holidays" v-if="showHolidays" :class="{ show: showHolidays  }">

    <div v-if="!loading && holidays.length > 0">
        <div class="table-responsive">
            <table id="holidaysTable" class="table table-bordered table-striped table-vcenter display nowrap">
                <thead>
                    <tr>
                        <th style="min-width: 150px;">Date</th>
                        <th style="min-width: 150px;">Name</th>
                        <th style="min-width: 50px;">Description</th>
                        <th style="min-width: 50px;">Type</th>
                        <th style="min-width: 50px;">Recurring</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="holiday in holidays" :key="holiday.id">
                        <td class="font-w600">
                            @{{ holiday.date }}
                        </td>
                        <td class="font-w600">
                            @{{ holiday.name }}
                        </td>
                        <td>
                            @{{ holiday.description }}
                        </td>
                        <td>
                            @{{ holiday.type }}
                        </td>
                        <td>
                            <div v-if="holiday.recurring">
                                Yes
                            </div>
                            <div v-else>
                                No
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="dropdown d-inline-block">
                            <button
                                type="button"
                                class="btn btn-default"
                                :id="'dropdown-' + holiday.id"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >
                                <span class="d-sm-inline-block">Action</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end p-0">
                                <div class="p-2">
                                <!-- View Holiday Details -->
                                <button class="dropdown-item nav-main-link" @click="holidayDetails(holiday.id)">
                                    <i class="nav-main-link-icon fas fa-eye"></i>
                                    <span class="btn">View</span>
                                </button>

                                <!-- Edit Holiday -->
                                <button class="dropdown-item nav-main-link btn" @click="editHoliday(holiday)">
                                    <i class="nav-main-link-icon fas fa-pencil-alt"></i>
                                    <span class="btn">Edit</span>
                                </button>

                                <!-- Delete Holiday -->
                                <button class="dropdown-item nav-main-link btn delete-holiday-confirm" type="button" @click="confirmHolidayDelete(holiday.id)">
                                    <i class="nav-main-link-icon fas fa-trash-alt"></i>
                                    <span class="btn">Delete</span>
                                </button>
                                </div>
                            </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div v-if="!loading && holidays.length == 0">
        <p class="text-center">No holidays available</p>
    </div>
    <div v-if="error">
        <p class="p-5">
            @{{ error }}
        </p>
    </div>

</div>

<div>
    <!-- Modal Background Overlay -->
    <div v-if="showAddHolidayModal" class="modal-backdrop fade" :class="{ show: showAddHolidayModal }"></div>

    <!-- Modal Dialog -->
    <div class="modal fade" :class="{ show: showAddHolidayModal }" v-if="showAddHolidayModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="display: block;">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>@{{ state.modalTitle }}</h3>
            </div>
            <div class="modal-body">
                <div class="mb-3 p-4">
                    <div class="box-body">
                        <x-adminlte-input
                            type="text"
                            name="name"
                            v-model="state.name"
                            label="Name"
                            placeholder="Name"
                            fgroup-class="col-md-12"
                            class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                            id="name"
                            autocomplete="off"
                        />

                        <x-adminlte-input
                            type="date"
                            name="date"
                            v-model="state.date"
                            label="Date:"
                            placeholder="Date"
                            fgroup-class="col-md-12"
                            class="{ 'is-invalid': errors.has('date') }"
                            ref="datePickerInput"
                            autocomplete="off"
                        />

                        <x-adminlte-textarea
                            type="text"
                            name="description"
                            v-model="state.description"
                            label="Description:"
                            placeholder="Description"
                            fgroup-class="col-md-12"
                            class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                            autocomplete="off"
                        ></x-adminlte-textarea>

                        <div class="col-md-12">
                            <div class="row">
                                <x-adminlte-select2
                                    name="state.holiday_type"
                                    v-model="state.holiday_type"
                                    label="Holiday Type:"
                                    fgroup-class="col-md-6"
                                    class="{ 'is-invalid': $errors->has('holiday_type') }"
                                    data-placeholder="Select an option..."
                                    autocomplete="off">
                                    <option value="" disabled>Please select an option...</option>
                                    <option value="National">National</option>
                                    <option value="Other">Other</option>
                                </x-adminlte-select2>

                                <x-adminlte-select2
                                    name="state.recurring"
                                    v-model="state.recurring"
                                    label="Recurring:"
                                    fgroup-class="col-md-6"
                                    class="{ 'is-invalid': $errors->has('recurring') }"
                                    data-placeholder="Select an option..."
                                    autocomplete="off">
                                    <option value="" disabled>Please select an option...</option>
                                    <option :value="true">Yes</option>
                                    <option :value="false">No</option>
                                </x-adminlte-select2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" @click="addHoliday(state.holidayId)">@{{ state.buttonName }}</button>
            <button type="button" class="btn btn-default" @click="closeForm">Cancel</button>
            </div>
        </div>
        </div>
    </div>
</div>
