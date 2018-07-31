<template>
    <div>
        <div><label>Bathrooms</label></div>
        <select
            name="baths"
            class="custom-select"
            v-model="selected"
        >
            <option value="">Any</option>
            <option v-for="option in options" :value="option" :key="option" >
                {{ option.toLocaleString() + '+' }}
            </option>
        </select>
    </div>
</template>
<script>
export default {
    props: {
        fieldValue: {
            type: String,
            default: ""
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
            for(let i = 0; i < 6; i++){
                options[i] = ((i+1))
            }
            return options;
        }
    }
}
</script>