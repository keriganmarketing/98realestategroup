<template>
    <form class="navbar-form form-inline" method="post" >
        <div class="row">
            <div class="col-sm-6 col-sm-6 col-lg-3">
                <label>Keyword</label>
                <input type="text" class="form-control" placeholder="City, address, subdivision or zip" >
            </div>
            <div class="col-sm-6 col-lg-3">
                <label>City / Area</label>
                <area-field
                    :field-value="searchTerms.area"
                >
                </area-field>
            </div>
            <div class="col-sm-6 col-lg-3">
                <label>Property Type</label>
                <property-type
                    :field-value="searchTerms.propertyType"
                >
                </property-type>
            </div>
            <div class="col-sm-6 col-lg-3">
                <label class="col-xs-12">&nbsp;</label>
                <button
                    @click="toggleAdvanced"
                    type="button" 
                    class="btn btn-primary dropdown-toggle col-xs-8 col" 
                    aria-haspopup="true" 
                    aria-expanded="false" 
                    >Advanced Options</button>
                <input type="hidden" name="cmd" value="mlssearch" >
                <button type="submit" class="btn btn-danger col-xs-4 col" >Search</button>
            </div>
        </div>
        <div v-if="advancedOpen" id="advanced-menu" class="advanced-menu row">
            <div class="col-lg-6">
                
                <div class="row">
                    <div class="col-xs-6">
                        <min-price-field
                            class="mb-4"
                            :field-value="searchTerms.minPrice"
                        >
                        </min-price-field>
                    </div>
                    <div class="col-xs-6">
                        <max-price-field
                            class="mb-4"
                            :field-value="searchTerms.maxPrice"
                        ></max-price-field>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <bedrooms-field
                            class="mb-4"
                            :field-value="searchTerms.bedrooms"
                        ></bedrooms-field>
                    </div>
                    <div class="col-xs-6">
                        <bathrooms-field
                            class="mb-4"
                            :field-value="searchTerms.bathrooms"
                        ></bathrooms-field>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <sqft-field
                            class="mb-4"
                            :field-value="searchTerms.sq_ft"
                        ></sqft-field>
                    </div>
                    <div class="col-xs-6">
                        <acreage-field
                            class="mb-4"
                            :field-value="searchTerms.acreage"
                        ></acreage-field>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">

                <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-12">
                
                        <status-field
                            class="mb-6"
                            :search-terms="searchTerms.status"
                        ></status-field>

                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-12">

                        <details-field
                            class="mb-6"
                            :data-waterfront="searchTerms.waterfront"
                            :data-waterview="searchTerms.waterview"
                            :data-foreclosures="searchTerms.foreclosures"
                        ></details-field>

                    </div>
                </div>

            </div>
        </div>
    </form>
</template>

<script>
    export default {
        props: {
            searchTerms: {
                type: Object,
                default: () => {
                    return {
                        omni: 'Mexico Beach',
                        propertyType: 'Single Family Home',
                        minPrice: '200000',
                        maxPrice: '',
                        sq_ft: '',
                        acreage: '',
                        status: ['active'],
                        details: [],
                        bedrooms: '',
                        bathrooms: '',
                        openHouses: 0,
                        sortBy: 'date_modified',
                        orderBy: 'DESC',
                        page: 1
                    }
                }
            }
        },

        data(){
            return {
                advancedOpen: false,
                mapViewSelected: false,
            }
        },

        created(){
            this.advancedOpen = false;
        },

        methods: {
            toggleAdvanced(event){
                if (event) event.preventDefault();
                this.advancedOpen = !this.advancedOpen;
            }
        }
    }
</script>