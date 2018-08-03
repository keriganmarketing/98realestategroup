<template>
    <div>
        <select 
            name="propertyType" 
            v-model="selected" 
            class="prop-type-input custom-select" >
            <option value="Any">All Types</option>
            <option value="Detached Single Family">Single Family Homes</option>
            <option value="Residential Lots/Land">Residential Lots &amp; Land</option>
            <option value="Vacant Land">Vacant Land</option>
            <option value="Condominiums">Condos</option>
            <option value="ASF/Attached Individual Unit">Townhomes</option>
            <option value="Dup/Tri/Quad MULTI Unit">Dup/Tri/Quadplex Units</option>
            <option value="Improved Comm">Improved Commercial</option>
            <option value="Unimproved Comm">Unimproved Commercial</option>
            <option value="Commercial Land">Commercial Land</option>
            <option value="Pre-Construction">Pre-Construction</option>
            <option value="Mobile/Manufactured">Mobile/Manufactured</option>
            <option value="Residential& Business">Multi-Zone</option>
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