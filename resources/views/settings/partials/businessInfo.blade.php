<div id="businessInfo" v-if="showBusinessInfo" :class="{ show: showBusinessInfo }">

    <div v-if="!loading && data.length > 0">
        @{{ data }}
    </div>
    <div v-if="error">
        <p class="p-5">
            @{{ error }}
        </p>
    </div>

</div>
