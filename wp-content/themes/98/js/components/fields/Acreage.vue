<template>
    <div>
        <div><label>Acreage</label></div>
        <select
            name="acreage"
            class="custom-select"
            v-model="selected"
        >
            <option value="Any">Any</option>
            <option value=".5" >1/2 or more</option>
            <option value="1" >1 or more</option>
            <option value="2" >2 or more</option>
            <option value="5" >5 or more</option>
            <option value="10" >10 or more</option>
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
        }
    }
</script>