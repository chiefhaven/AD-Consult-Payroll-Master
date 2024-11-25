<div id="businessInfo" v-if="showBusinessInfo" :class="{ show: showBusinessInfo }">
    <div v-if="!loading">
        <div class="container">
            <!-- Form Start -->
            <form id="businessInformationForm" @submit.prevent="submitBusinessInfo">

                <!-- Business Name -->
                <x-adminlte-input
                    id="businessName"
                    name="business_name"
                    label="Business Name"
                    placeholder="Enter the business name"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="businessForm.business_name"
                    required
                />

                <!-- Street Address -->
                <x-adminlte-input
                    id="streetAddress"
                    name="street_address"
                    label="Street Address"
                    placeholder="Enter the main street address"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="businessForm.street_address"
                    required
                />

                <!-- Street Address 2 -->
                <x-adminlte-input
                    id="streetAddress2"
                    name="street_address_2"
                    label="Street Address 2"
                    placeholder="Additional address information (optional)"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="businessForm.street_address_2"
                />

                <!-- District -->
                <x-adminlte-input
                    id="district"
                    name="district"
                    label="District"
                    placeholder="Enter the district"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="businessForm.district"
                />

                <!-- Province/Region -->
                <x-adminlte-input
                    id="provinceOrRegion"
                    name="province_or_region"
                    label="Province/Region"
                    placeholder="Enter the province or region"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="businessForm.province_or_region"
                />

                <!-- Country -->
                <x-adminlte-input
                    id="country"
                    name="country"
                    label="Country"
                    placeholder="Enter the country"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="businessForm.country"
                    required
                />

                <!-- Business Email -->
                <x-adminlte-input
                    id="businessEmail"
                    name="business_email"
                    type="email"
                    label="Business Email"
                    placeholder="e.g., info@business.com"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="businessForm.business_email"
                    required
                />

                <!-- Business Phone -->
                <x-adminlte-input
                    id="businessPhone"
                    name="business_phone"
                    type="tel"
                    label="Business Phone"
                    placeholder="e.g., +26512345678"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="businessForm.business_phone"
                    required
                />

                <!-- Alternative Phone Number -->
                <x-adminlte-input
                    id="altPhoneNumber"
                    name="alt_phone_number"
                    type="tel"
                    label="Alternative Phone Number"
                    placeholder="e.g., +26587654321"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="businessForm.alt_phone_number"
                />

                <!-- Business Website -->
                <x-adminlte-input
                    id="businessWebsite"
                    name="business_website"
                    type="url"
                    label="Business Website"
                    placeholder="e.g., https://www.business.com"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="businessForm.business_website"
                />

                <!-- Registration Number -->
                <x-adminlte-input
                    id="registrationNumber"
                    name="registration_number"
                    label="Registration Number"
                    placeholder="e.g., 123456789"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="businessForm.registration_number"
                />

                <!-- Tax Identification Number -->
                <x-adminlte-input
                    id="taxId"
                    name="tax_id"
                    label="Tax Identification Number (TIN)"
                    placeholder="e.g., 987654321"
                    fgroup-class="form-group"
                    label-class="form-label"
                    v-model="businessForm.tax_id"
                />

                <!-- Submit Button -->
                <div id="formActions" class="form-group mt-3">
                    <button id="saveBusinessInfo" type="submit" class="btn btn-primary">
                        Save Business Information
                    </button>
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
