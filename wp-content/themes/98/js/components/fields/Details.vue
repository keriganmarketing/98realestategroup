<template>
    <div>
        <div class="mb-2"><label>Property Details</label></div>
        <label class="custom-control custom-checkbox">
            <input type="checkbox" name="waterfront" class="custom-control-input" v-model="waterfront">
            <span class="custom-control-label">Waterfront</span>
        </label>
        <label class="custom-control custom-checkbox">
            <input type="checkbox" name="waterview" class="custom-control-input" v-model="waterview">
            <span class="custom-control-label">Waterview</span>
        </label>
        <label class="custom-control custom-checkbox">
            <input type="checkbox" name="foreclosures" class="custom-control-input" v-model="foreclosures">
            <span for="foreclosures" class="custom-control-label">Foreclosure / Short Sale</span>
        </label>
    </div>
</template>

<script>
    export default {
        props: {
            dataWaterfront: {
                type: String,
                default: this.waterfront
            },
            dataWaterview: {
                type: String,
                default: this.waterview
            },
            dataForeclosures: {
                type: String,
                default: this.foreclosures
            },
        },

        data () {
            return {
                waterfront: this.dataWaterfront,
                waterview: this.dataWaterview,
                foreclosures: this.dataForeclosures
            }
        }

    }
</script>