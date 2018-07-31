<template>
    <form class="form form-inline" method="get" >
        <input type="hidden" name="q" value="search" >
        <input type="hidden" name="omni" :value="searchTerms.omni" >
        <input type="hidden" name="propertyType" :value="searchTerms.propertyType" >
        <input type="hidden" name="minPrice" :value="searchTerms.minPrice" >
        <input type="hidden" name="maxPrice" :value="searchTerms.maxPrice" >
        <input type="hidden" name="sqft" :value="searchTerms.sqft" >
        <input type="hidden" name="acreage" :value="searchTerms.acreage" >
        <input type="hidden" name="details" :value="searchTerms.details" >
        <input type="hidden" name="beds" :value="searchTerms.beds" >
        <input type="hidden" name="baths" :value="searchTerms.baths" >
        <input type="hidden" name="waterfront" :value="searchTerms.waterfront" >
        <input type="hidden" name="waterview" :value="searchTerms.waterview" >
        <input type="hidden" name="foreclosure" :value="searchTerms.foreclosure" >
        <input type="hidden" name="page" :value="searchTerms.page" >
        <input 
            v-for="(status, index) in searchTerms.status" 
            type="hidden" 
            :name="'status[' + index + ']'" 
            :key="status" 
            :value="status" >
        <select name="sort" 
            v-model="selected" 
            class="area-input custom-select" 
            style="width:215px;" >
            <option value="price|desc">Price - high to low</option>
			<option value="price|asc">Price - low to high</option>
            <option value="date_modified|desc">Date Modified </option>
        </select><button type="submit" class="btn btn-info" >Sort <span class="glyphicon glyphicon-chevron-right"></span></button>    
    </form>
</template>

<script>
    export default {
        props: {
            fieldValue: {
                type: String,
                default: 'price|desc'
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
