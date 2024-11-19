<div id="emailSettings" v-if="showEmailSettings" :class="{ show: showEmailSettings }">
    <div v-if="!loading && data.length > 0">
        <div class="container">
            <!-- Form Start -->
            <form id="emailConfigurationForm" @submit.prevent="submitEmailForm">
                <!-- Mail Host -->
                <x-adminlte-input
                    id="mailHost"
                    name="mail_host"
                    label="Mail Host"
                    placeholder="e.g., smtp.mailtrap.io"
                    fgroup-class="form-group col-md-5"
                    label-class="form-label"
                    v-model="form.mail_host"
                    required
                />

                <!-- Mail Port -->
                <x-adminlte-input
                    id="mailPort"
                    name="mail_port"
                    type="number"
                    label="Mail Port"
                    placeholder="e.g., 587"
                    fgroup-class="form-group col-md-5"
                    label-class="form-label"
                    v-model.number="form.mail_port"
                    required
                />

                <!-- Mail Username -->
                <x-adminlte-input
                    id="mailUsername"
                    name="mail_username"
                    label="Mail Username"
                    placeholder="Email username"
                    fgroup-class="form-group col-md-5"
                    label-class="form-label"
                    v-model="form.mail_username"
                    required
                />

                <!-- Mail Password -->
                <x-adminlte-input
                    id="mailPassword"
                    name="mail_password"
                    type="text"
                    label="Mail Password"
                    placeholder="Email password"
                    fgroup-class="form-group col-md-5"
                    label-class="form-label"
                    v-model="form.mail_password"
                />

                <!-- Mail Encryption -->
                <x-adminlte-select2
                    id="mailEncryption"
                    name="mail_encryption"
                    label="Mail Encryption"
                    fgroup-class="form-group col-md-5"
                    v-model="form.mail_encryption"
                >
                    <option value="" disabled selected>Select Encryption</option>
                    <option value="tls">TLS</option>
                    <option value="ssl">SSL</option>
                    <option value="none">None</option>
                </x-adminlte-select2>

                <!-- Mail From Address -->
                <x-adminlte-input
                    id="mailFromAddress"
                    name="mail_from_address"
                    type="email"
                    label="From Address"
                    placeholder="e.g., no-reply@yourdomain.com"
                    fgroup-class="form-group col-md-5"
                    label-class="form-label"
                    v-model="form.mail_from_address"
                    required
                />

                <!-- Mail From Name -->
                <x-adminlte-input
                    id="mailFromName"
                    name="mail_from_name"
                    label="From Name"
                    placeholder="e.g., Your Company Name"
                    fgroup-class="form-group col-md-5"
                    label-class="form-label"
                    v-model="form.mail_from_name"
                    required
                />

                <div id="formActions" class="form-group mt-3">
                    <button id="saveEmailConfig" type="submit" class="btn btn-primary">Save Configuration</button>
                </div>
            </form>
        </div>
    </div>
    <div v-if="error">
        <p class="alert alert-danger mt-3">
            @{{ error }}
        </p>
    </div>
</div>
