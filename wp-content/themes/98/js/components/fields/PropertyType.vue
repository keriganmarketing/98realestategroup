<template>
    <div>
        <select 
            name="propertyType" 
            v-model="selected" 
            class="prop-type-input custom-select" >
            <option value="Any">All Types</option>
            <option value="Detached Single Family">Single Family Homes</option>
            <option value="Land">Lots &amp; Land</option>
            <option value="Condominiums">Condos</option>
            <option value="ASF">Townhomes</option>
            <option value="MULTI">Dup/Tri/Quadplex Units</option>
            <option value="Commercial">Commercial</option>
            <option value="Pre-Construction">Pre-Construction</option>
            <option value="Mobile">Mobile/Manufactured</option>
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