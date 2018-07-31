<template>
    <div>
        <select 
            name="area" 
            v-model="selected" 
            class="area-input custom-select">
            <option value="Any">All Areas</option>

            <option value="Mexico/St. Joe Beach" class="group">Mexico / St. Joe Beach</option>
            <option value="Beacon Hill">Beacon Hill</option>
            <option value="Mexico Beach">Mexico Beach</option>
            <option value="Overstreet-South">Overstreet-South</option>
            <option value="St. Joe Beach">St. Joe Beach</option>
            <option value="Windmark Beach">Windmark Beach</option>

            <option value="Cape San Blas/S. Gulf" class="group">Cape San Blas</option>
            <option value="Cape San Blas-N">North Cape San Blas</option>
            <option value="Cape San Blas-S">South Cape San Blas</option>
            <option value="CR 30-A">CR 30-A</option>
            <option value="Indian Pass">Indian Pass</option>
            <option value="SR 30-A">SR 30-A</option>
        
            <option value="Port St. Joe" class="group">Port St. Joe</option>
            <option value="City of Port St. Joe">City of Port St. Joe</option>
            <option value="Jones Homestead">Jones Homestead</option>
            <option value="Oak Grove">Oak Grove</option>
        
            <option value="North Gulf County" class="group">North Gulf County</option>
            <option value="Dalkeith">Dalkeith</option>
            <option value="Honeyville">Honeyville</option>
            <option value="Howard Creek">Howard Creek</option>
            <option value="Overstreet-North">Overstreet-North</option>
            <option value="Wewahitchka">Wewahitchka</option>
            <option value="White City">White City</option>

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