<template>
    <div>
        <div class="mb-2"><label>Property Status</label></div>
        <label class="custom-control custom-checkbox">
            <input type="checkbox" name="status[active]" value="Active" class="custom-control-input" v-model="active">
            <span class="custom-control-label">Active</span>
        </label>
        <label class="custom-control custom-checkbox">
            <input type="checkbox" name="status[sold]" value="Sold/Closed" class="custom-control-input" v-model="sold">
            <span class="custom-control-label">Sold</span>
        </label>
        <label class="custom-control custom-checkbox">
            <input type="checkbox" name="status[contingent]" value="Contingent" class="custom-control-input" v-model="contingent">
            <span class="custom-control-label">Contingent</span>
        </label>

    </div>
</template>

<script>
    export default {
        props: {
            searchTerms: {
                type: Array,
                default: []
            }
        },

        data () {
            return {
                active: true,
                sold: false,
                contingent: true
            }
        },

        mounted () {
            this.active = this.searchTerms.active;
            this.sold = this.searchTerms.sold;
            this.contingent = this.searchTerms.contingent;
        }
    }
</script>