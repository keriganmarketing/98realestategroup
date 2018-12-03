<template>
    <div>
        <select 
            name="propertyType" 
            v-model="selected" 
            class="prop-type-input custom-select" >
            <option value="Any">All Types</option>
            <option value="Residential">All Residential Homes</option>
            <option value="Detached Single Family">Single Family Homes</option>
            <option value="Residential Lots/Land">Residential Lots &amp; Land</option>
            <option value="Condominium">Condos</option>
            <option value="ASF (Attached Single Family)">Townhomes</option>
            <option value="Dup/Tri/Quad (Multi-Unit)">Dup/Tri/Quadplex Units</option>
            <option value="Commercial Land">Commercial Land</option>
            <option value="Apartments/Multi-Family">Apartments/Mult-Family</option>
            <option value="Pre-Construction">Pre-Construction</option>
            <option value="Mobile/Manufactured">Mobile/Manufactured</option>
            <option value="Farm/Timberland">Farm/Timberland</option>
            <option value="Vacant Land">Vacant Land</option>
            <option value="Industrial">Industrial</option>
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