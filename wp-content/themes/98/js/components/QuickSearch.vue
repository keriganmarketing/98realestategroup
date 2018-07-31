<template>
    <form class="navbar-form form-inline" method="get" action="/properties/" >
        <input type="hidden" name="q" value="search" >
        <div class="container no-gutter">
            <div class="row">
                <div class="col-lg-4">
                    <p class="search-form-label">PROPERTY<br>QUICK SEARCH</p>
                </div>
                <div class="col-sm-6 col-sm-6 col-lg-2">
                    <input type="text" class="form-control" name="omni" placeholder="Address, Subdivision or MLS#" >
                </div>
                <div class="col-sm-6 col-lg-2">
                    <area-field></area-field>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <property-type></property-type>
                </div>
                <button 
                    @click="toggleAdvanced" 
                    type="button" 
                    class="btn btn-primary dropdown-toggle col-xs-6 col-sm-3 col-lg-1" 
                    data-toggle="dropdown" 
                    aria-haspopup="true" 
                    aria-expanded="false" 
                    >Filter</button>
                <button type="submit" class="btn btn-danger col-xs-6 col-sm-3 col-lg-1" >Search</button>
            </div>
        </div>
        <div v-if="advancedSearch" id="advanced-menu" class="advanced-menu col-xs-12">
            <div class="container-wide">
                <div class="row">
                    <div class="col-md-4 col-lg-6">
                
                        <div class="row">
                            <div class="col-xs-6 col-md-12 col-lg-6">
                                <min-price-field
                                    class="mb-4"
                                >
                                </min-price-field>
                            </div>
                            <div class="col-xs-6 col-md-12 col-lg-6">
                                <max-price-field
                                    class="mb-4"
                                ></max-price-field>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-md-12 col-lg-6">
                                <bedrooms-field
                                    class="mb-4"
                                ></bedrooms-field>
                            </div>
                            <div class="col-xs-6 col-md-12 col-lg-6">
                                <bathrooms-field
                                    class="mb-4"
                                ></bathrooms-field>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-md-12 col-lg-6">
                                <sqft-field
                                    class="mb-4"
                                ></sqft-field>
                            </div>
                            <div class="col-xs-6 col-md-12 col-lg-6">
                                <acreage-field
                                    class="mb-4"
                                ></acreage-field>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        
                        <status-field
                            class="mb-6"
                        ></status-field>

                        <details-field
                            class="mb-6"
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

        },

        data() {
            return {
                advancedSearch: false
            }
        },

        methods: {
            toggleAdvanced(){
                this.advancedSearch = !this.advancedSearch;
            }
        }
    }
</script>