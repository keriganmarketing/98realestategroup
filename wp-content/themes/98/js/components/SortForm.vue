<template>
    <form class="form form-inline d-inline-block" method="get" >
        <input type="hidden" name="q" value="search" >
        <input v-if="searchTerms.omni" type="hidden" name="omni" :value="searchTerms.omni" >
        <input v-if="searchTerms.area" type="hidden" name="area" :value="searchTerms.area" >
        <input v-if="searchTerms.propertyType" type="hidden" name="propertyType" :value="searchTerms.propertyType" >
        <input v-if="searchTerms.minPrice" type="hidden" name="minPrice" :value="searchTerms.minPrice" >
        <input v-if="searchTerms.maxPrice" type="hidden" name="maxPrice" :value="searchTerms.maxPrice" >
        <input v-if="searchTerms.sqft" type="hidden" name="sqft" :value="searchTerms.sqft" >
        <input v-if="searchTerms.acreage" type="hidden" name="acreage" :value="searchTerms.acreage" >
        <input v-if="searchTerms.details" type="hidden" name="details" :value="searchTerms.details" >
        <input v-if="searchTerms.beds" type="hidden" name="beds" :value="searchTerms.beds" >
        <input v-if="searchTerms.baths" type="hidden" name="baths" :value="searchTerms.baths" >
        <input v-if="searchTerms.waterfront" type="hidden" name="waterfront" :value="searchTerms.waterfront" >
        <input v-if="searchTerms.waterview" type="hidden" name="waterview" :value="searchTerms.waterview" >
        <input v-if="searchTerms.foreclosure" type="hidden" name="foreclosure" :value="searchTerms.foreclosure" >
        <input v-if="searchTerms.page" type="hidden" name="page" :value="searchTerms.page" >
        <div v-if="searchTerms.status">
            <input 
                v-for="(status, index) in searchTerms.status" 
                type="hidden" 
                :name="'status[' + index + ']'" 
                :key="status" 
                :value="status" >
        </div>
        <select name="sort" 
            v-model="selected" 
            class="custom-select" 
            style="width:auto;" >
            <option value="list_price|desc">Price - high to low</option>
			<option value="list_price|asc">Price - low to high</option>
            <option value="date_modified|desc">Date Modified </option>
        </select><button type="submit" class="btn btn-info" >Sort</button>    
    </form>
</template>

<script>
    export default {
        props: {
            fieldValue: {
                type: String,
                default: 'date_modified|desc'
            },
            searchTerms: {
                type: Object,
                default: () => {}
            }
        },

        data () {
            return {
                selected: this.fieldValue
            }
        }
    }
</script>
