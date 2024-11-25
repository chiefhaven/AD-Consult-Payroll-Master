<div id="invoiceSettings" v-if="showInvoiceSettings" :class="{ show: showInvoiceSettings }">
    <div v-if="!loading && data">
        <div class="container">
            <!-- Form Start -->
            <form id="invoiceSettingsForm" @submit.prevent="submitInvoiceForm">
                <div class="card-body">
                    <div class="row">
                        <x-adminlte-input
                            id="invoicePrefix"
                            name="prefix"
                            label="Invoice Prefix:"
                            placeholder="E.g., INV-"
                            fgroup-class="form-group col-md-6"
                            label-class="form-label"
                            v-model="form.prefix"
                            required
                        />
                        <x-adminlte-input
                            id="invoiceNumberIncludeYear"
                            name="invoiceNumberIncludeYear"
                            type="checkbox"
                            label="Include year:"
                            placeholder="Yes"
                            fgroup-class="form-group col-md-3"
                            label-class="form-label"
                            v-model.number="form.invoiceNumberIncludeYear"
                            required
                        />

                        <x-adminlte-input
                            id="invoiceNumberIncludeClientName"
                            name="invoiceNumberIncludeClientName"
                            type="checkbox"
                            label="Include client name:"
                            placeholder="Yes"
                            fgroup-class="form-group col-md-3"
                            label-class="form-label"
                            v-model.number="form.invoiceNumberIncludeClientName"
                            required
                        />
                    </div>

                    <x-adminlte-input
                        id="invoiceSeparator"
                        name="separator"
                        label="Separator:"
                        placeholder="E.g., -, _"
                        fgroup-class="form-group"
                        label-class="form-label"
                        v-model="form.seperator"
                        required
                    />

                    <x-adminlte-input
                        id="startingInvoiceNumber"
                        name="startNumber"
                        type="number"
                        label="Starting Invoice Number:"
                        placeholder="E.g., 1"
                        fgroup-class="form-group"
                        label-class="form-label"
                        v-model.number="form.startNumber"
                        min="1"
                        required
                    />
                    <x-adminlte-input
                        id="defaultTaxRate"
                        name="taxRate"
                        type="number"
                        label="Default Tax Rate (%):"
                        placeholder="E.g., 15"
                        fgroup-class="form-group"
                        label-class="form-label"
                        v-model.number="form.taxRate"
                        min="0"
                        max="100"
                        required
                    />

                    <x-adminlte-textarea
                        id="termsAndConditions"
                        name="terms"
                        label="Terms and Conditions:"
                        type="textarea"
                        rows="4"
                        placeholder="Enter terms and conditions"
                        fgroup-class="form-group"
                        label-class="form-label"
                        v-model="form.terms"
                    ></x-adminlte-textarea>

                    <x-adminlte-textarea
                        id="invoiceHeader"
                        name="header"
                        label="Header"
                        type="textarea"
                        rows="4"
                        placeholder="Header"
                        fgroup-class="form-group"
                        label-class="form-label"
                        v-model="form.header"
                    ></x-adminlte-textarea>

                    <x-adminlte-textarea
                        id="invoiceFooter"
                        name="footer"
                        label="Footer"
                        type="textarea"
                        rows="4"
                        placeholder="Invoice footer"
                        fgroup-class="form-group"
                        label-class="form-label"
                        v-model="form.footer"
                    ></x-adminlte-textarea>
                </div>
                <div class="card-footer">
                    <button id="saveSettingsButton" type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
    <div v-if="error">
        <p class="p-5">
            @{{ error }}
        </p>
    </div>
</div>
