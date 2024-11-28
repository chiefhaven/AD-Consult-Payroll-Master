<form @submit.prevent="storeAdmin" enctype="multipart/form-data">
    <div class="card mb-3 p-4">
        <p>
            Admin information
            <hr>
        </p>
        <div class="row">
            <!-- First Name -->
            <div class="form-group col-md-4">
                <label for="first_name">First Name</label>
                <input
                    type="text"
                    class="form-control"
                    id="first_name"
                    name="first_name"
                    placeholder="Enter First Name"
                    v-model="form.first_name"
                    :class="{'is-invalid': errors.first_name}"
                    required
                />
                <!-- Validation error message -->
                <div v-if="errors.first_name" class="invalid-feedback">
                    @{{ errors.first_name[0] }}
                </div>
            </div>

            <!-- Middle Name -->
            <div class="form-group col-md-4">
                <label for="middle_name">Middle Name</label>
                <input
                    type="text"
                    class="form-control"
                    id="middle_name"
                    name="middle_name"
                    placeholder="Enter Middle Name"
                    v-model="form.middle_name"
                    :class="{'is-invalid': errors.middle_name}"
                />
                <!-- Validation error message -->
                <div v-if="errors.middle_name" class="invalid-feedback">
                    @{{ errors.middle_name[0] }}
                </div>
            </div>

            <!-- Sirname -->
            <div class="form-group col-md-4">
                <label for="sirname">Sirname</label>
                <input
                    type="text"
                    class="form-control"
                    id="sirname"
                    name="sirname"
                    placeholder="Enter Sirname"
                    v-model="form.sirname"
                    :class="{'is-invalid': errors.sirname}"
                    required
                />
                <!-- Validation error message -->
                <div v-if="errors.sirname" class="invalid-feedback">
                    @{{ errors.sirname[0] }}
                </div>
            </div>

        </div>

        <!-- Profile Picture -->
        <div class="mb-3">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <input
                type="file"
                id="profile_picture"
                @change="handleFileUpload"
                class="form-control"
                :class="{'is-invalid': errors.profile_picture}"
            />
            <!-- Validation error message -->
            <div v-if="errors.sirname" class="invalid-feedback">
                @{{ errors.profile_picture[0] }}
            </div>
        </div>

        <div class="row">
            <!-- Phone -->
            <div class="form-group col-md-4">
                <label for="phone">Phone</label>
                <input
                    type="tel"
                    class="form-control"
                    id="phone"
                    name="phone"
                    placeholder="Enter Phone Number"
                    v-model="form.phone"
                    :class="{'is-invalid': errors.phone}"
                    required
                />
                <!-- Validation error message -->
                <div v-if="errors.phone" class="invalid-feedback">
                    @{{ errors.phone[0] }}
                </div>
            </div>

            <!-- Alternative Phone -->
            <div class="form-group col-md-4">
                <label for="alt_phone">Alternative Phone</label>
                <input
                    type="tel"
                    class="form-control"
                    id="alt_phone"
                    name="alt_phone"
                    placeholder="Enter Alternative Phone Number"
                    v-model="form.alt_phone"
                    :class="{'is-invalid': errors.alt_phone}"
                />
                <!-- Validation error message -->
                <div v-if="errors.alt_phone" class="invalid-feedback">
                    @{{ errors.alt_phone[0] }}
                </div>
            </div>

            <!-- Email Address -->
            <div class="form-group col-md-4">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Email Address"
                    v-model="form.email"
                    :class="{'is-invalid': errors.email}"
                    required
                />
                <!-- Validation error message -->
                <div v-if="errors.email" class="invalid-feedback">
                    @{{ errors.email[0] }}
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Street Address -->
            <div class="form-group col-md-4">
                <label for="street_address">Street Address</label>
                <input
                    type="text"
                    class="form-control"
                    id="street_address"
                    name="street_address"
                    placeholder="Enter Street Address"
                    v-model="form.street_address"
                    :class="{'is-invalid': errors.street_address}"
                />
                <!-- Validation error message -->
                <div v-if="errors.street_address" class="invalid-feedback">
                    @{{ errors.street_address[0] }}
                </div>
            </div>

            <!-- District -->
            <div class="form-group col-md-4">
                <label for="district">District</label>
                <input
                    type="text"
                    class="form-control"
                    id="district"
                    name="district"
                    placeholder="Enter District"
                    v-model="form.district"
                    :class="{'is-invalid': errors.district}"
                />
                <!-- Validation error message -->
                <div v-if="errors.district" class="invalid-feedback">
                    @{{ errors.district[0] }}
                </div>
            </div>

            <!-- Country -->
            <div class="form-group col-md-4">
                <label for="country">Country</label>
                <input
                    type="text"
                    class="form-control"
                    id="country"
                    name="country"
                    placeholder="Enter Country"
                    v-model="form.country"
                    :class="{'is-invalid': errors.country}"
                />
                <!-- Validation error message -->
                <div v-if="errors.country" class="invalid-feedback">
                    @{{ errors.country[0] }}
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Role -->
            <div class="form-group col-md-6">
                <label for="role">Role</label>
                <select
                    id="role"
                    name="role"
                    class="form-control"
                    v-model="form.role"
                    :class="{'is-invalid': errors.role}"
                    required
                >
                    <option value="it_admin">IT Admin</option>
                    <option value="hr_admin">HR Admin</option>
                    <option value="finance_admin">Finance Admin</option>
                    <option value="super_admin">Super Admin</option>
                </select>
                <!-- Validation error message -->
                <div v-if="errors.role" class="invalid-feedback">
                    @{{ errors.role[0] }}
                </div>
            </div>

            <!-- Is Active Checkbox -->
            <div class="form-check col-md-2">
                <input
                    type="checkbox"
                    class="form-check-input"
                    id="is_active"
                    name="is_active"
                    v-model="form.is_active"
                    :class="{'is-invalid': errors.is_active}"
                />
                <label class="form-check-label" for="is_active">Is Active</label>
                <!-- Validation error message -->
                <div v-if="errors.is_active" class="invalid-feedback">
                    @{{ errors.is_active[0] }}
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3 p-4">
        <p>
            Login details
            <hr>
        </p>
        <div class="row">
            <!-- Username -->
            <div class="form-group col-md-4">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-control"
                    placeholder="Username"
                    v-model="form.username"
                    :class="{'is-invalid': errors.username}"
                    autocomplete="off"
                />
                <!-- Validation error message -->
                <div v-if="errors.username" class="invalid-feedback">
                    @{{ errors.username[0] }}
                </div>
            </div>

            <!-- Password -->
            <div class="form-group col-md-4">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Password"
                    v-model="form.password"
                    :class="{'is-invalid': errors.password}"
                    autocomplete="off"
                    minlength="8"
                />
                <!-- Validation error message -->
                <div v-if="errors.password" class="invalid-feedback">
                    @{{ errors.password[0] }}
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
        @{{ form.buttonName }}
    </button>
</form>
