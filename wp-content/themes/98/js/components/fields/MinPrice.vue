<template>
    <div>
        <div><label>Min Price</label></div>
        <select
            name="minPrice"
            class="custom-select"
            v-model="selected"
        >
            <option value="Any">Any</option>
            <option v-for="option in options" :value="option" :key="option" >${{ option.toLocaleString() }}</option>
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
            for(let i = 0; i < 9; i++){
                options[i] = ((i+1) * 100000)
            }
            for(let i = 1; i <= 5; i++){
                options[i + 8] = ((i) * 1000000)
            }
            return options;
        }
    }
}
</script>