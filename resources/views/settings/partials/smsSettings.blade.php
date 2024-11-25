<div id="smsSettings" v-if="showSmsSettings" :class="{ show: showSmsSettings }">
    <div v-if="!loading && data">
        <div class="container">
            <!-- Form Start -->
            <form id="smsConfigurationForm" @submit.prevent="submitSmsForm">

                <!-- SMS Gateway -->
                <x-adminlte-select2
                    id="smsGateway"
                    name="sms_gateway"
                    label="SMS Gateway"
                    fgroup-class="form-group"
                    v-model="smsForm.sms_gateway"
                    required
                >
                    <option value="" disabled selected>Select Gateway</option>
                    <option value="twilio">Twilio</option>
                    <option value="nexmo">Nexmo</option>
                    <option value="plivo">Plivo</option>
                    <option value="africastalking">Africas Talking</option>
                    <option value="other">Other</option>
                </x-adminlte-select2>

                <!-- API Key -->
                <x-adminlte-input
                    id="smsApiKey"
                    name="sms_api_key"
                    label="API Key"
                    placeholder="Enter your API key"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="smsForm.sms_api_key"
                    required
                />

                <!-- API Secret -->
                <x-adminlte-input
                    id="smsApiSecret"
                    name="sms_api_secret"
                    label="API Secret"
                    placeholder="Enter your API secret"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="smsForm.sms_api_secret"
                />

                <!-- Sender ID -->
                <x-adminlte-input
                    id="smsSenderId"
                    name="sms_sender_id"
                    label="Sender ID"
                    placeholder="e.g., YourBrand"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="smsForm.sms_sender_id"
                />

                <!-- Default Country Code -->
                <x-adminlte-input
                    id="smsCountryCode"
                    name="sms_country_code"
                    label="Default Country Code"
                    placeholder="e.g., +265"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="smsForm.sms_country_code"
                    required
                />

                <!-- Message Type -->
                <x-adminlte-select2
                    id="smsMessageType"
                    name="sms_message_type"
                    label="Message Type"
                    fgroup-class="form-group"
                    v-model="smsForm.sms_message_type"
                >
                    <option value="" disabled selected>Select Message Type</option>
                    <option value="transactional">Transactional</option>
                    <option value="promotional">Promotional</option>
                </x-adminlte-select2>

                <div id="formActions" class="form-group mt-3">
                    <button id="saveSmsConfig" type="submit" class="btn btn-primary">Save Configuration</button>
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
