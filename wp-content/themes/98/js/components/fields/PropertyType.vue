<template>
    <div>
        <select 
            name="propertyType" 
            v-model="selected" 
            class="prop-type-input custom-select" >
            <option value="Any">All Types</option>
            <option value="RD">Single Family Homes</option>
            <option value="LR">Residential Lots &amp; Land</option>
            <option value="RC">Condos</option>
            <option value="RA">Townhomes</option>
            <option value="RQ">Dup/Tri/Quadplex Units</option>
            <option value="LC">Commercial Land</option>
            <option value="CA">Apartments/Mult-Family</option>
            <option value="RP">Pre-Construction</option>
            <option value="RM">Mobile/Manufactured</option>
            <option value="LF">Farm/Timberland</option>
            <option value="CV">Vacant Land</option>
            <option value="CI">Industrial</option>
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