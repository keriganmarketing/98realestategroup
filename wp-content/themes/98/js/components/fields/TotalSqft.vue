<template>
    <div>
        <div><label>Total Sqft</label></div>
        <select 
            name="sq_ft" 
            v-model="selected" 
            class="custom-select">
            <option value="Any">Any</option>
            <option v-for="option in options" :value="option" :key="option" >{{ option.toLocaleString() }}</option>
        </select>
    </div>
</template>
<script>
    export default {
        props: {
            fieldValue: {
                type: String,
                default: "Any"
            }
        },
        data () {
            return {
                selected: this.fieldValue
            }
        },
        computed: {
            options: function() {
                let options = [];
                for(let i = 0; i < 12; i++){
                    options[i] = ((i+4) * 200);
                }
                return options;
            }
        }
    }
</script>