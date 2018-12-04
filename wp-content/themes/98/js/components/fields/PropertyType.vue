<template>
    <div>
        <select 
            name="propertyType" 
            v-model="selected" 
            class="prop-type-input custom-select" >
            <option value="Any">All Types</option>
            <option value="AllHomes">All Homes</option>
            <option value="AllLand">All Vacant Land</option>
            <option value="Detached Single Family">Single Family Homes</option>
            <option value="MultiUnit">Condos/Townhouses/Multi</option>
            <option value="Commercial">Commercial</option>
        </select>
    </div>
</template>

<script>
    export default {
        props: {
            fieldValue: {
                type: String,
                default: 'Any'
            }
        },
        data () {
            return {
                selected: this.fieldValue
            }
        }
    }
</script>