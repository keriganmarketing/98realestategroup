<template>
    <form class="navbar-form form-inline" method="get" >
        <input type="hidden" name="q" value="search" >
        <div class="row">
            <div class="col-sm-6 col-sm-6 col-lg-3">
            <label>Keyword</label>
                <omni-bar
                    v-model="omni"
                    :options="omniTerms"
                    :filter-function="applySearchFilter"
                    :field-value="searchTerms.omni"
                ></omni-bar>
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
                <button type="submit" class="btn btn-danger col-xs-4 col">Search</button>
            </div>
        </div>
        <div v-if="advancedOpen" id="advanced-menu" class="advanced-menu row">
            <div class="col-lg-6 col-xl-12">

                <div class="row">
                    <div class="col-xs-6 col-xl-2">
                        <min-price-field
                            class="mb-4"
                            :field-value="searchTerms.minPrice"
                        >
                        </min-price-field>
                    </div>
                    <div class="col-xs-6 col-xl-2">
                        <max-price-field
                            class="mb-4"
                            :field-value="searchTerms.maxPrice"
                        ></max-price-field>
                    </div>

                    <div class="col-xs-6 col-xl-2">
                        <bedrooms-field
                            class="mb-4"
                            :field-value="searchTerms.beds"
                        ></bedrooms-field>
                    </div>
                    <div class="col-xs-6 col-xl-2">
                        <bathrooms-field
                            class="mb-4"
                            :field-value="searchTerms.baths"
                        ></bathrooms-field>
                    </div>

                    <div class="col-xs-6 col-xl-2">
                        <sqft-field
                            class="mb-4"
                            :field-value="searchTerms.sqft"
                        ></sqft-field>
                    </div>
                    <div class="col-xs-6 col-xl-2">
                        <acreage-field
                            class="mb-4"
                            :field-value="searchTerms.acreage"
                        ></acreage-field>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-12">

                <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-12 col-xl-6">

                        <status-field
                            class="mb-6"
                            :search-terms="searchTerms.status"
                        ></status-field>

                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-12 col-xl-6">

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
        <input name="page" value="1" type="hidden" >
    </form>
</template>

<script>
    export default {
        props: {
            'searchTerms': {
                type: Object,
                default: {}
            }
        },
        data(){
            return {
                omni: null,
                omniTerms: [],
                advancedOpen: false,
                mapViewSelected: false,
                baseUrl: 'https://navica.kerigan.com/api/v1/omnibar'
            }
        },
        created(){
            this.advancedOpen = false;
        },
        watch: {
            omni: function (newOmni, oldOmni) {
                if (newOmni.length > 2) {
                    this.search();
                }
            }
        },
        methods: {
            toggleAdvanced(event){
                if (event) event.preventDefault();
                this.advancedOpen = !this.advancedOpen;
            },
            applySearchFilter(search, omniTerms) {
                return omniTerms.filter(term => term.value.toLowerCase().includes(search.toLowerCase()))
            },
            search: _.debounce(
                function () {
                    console.log(this.omni);
                    let vm = this;
                    let config = {
                        method: 'get',
                        url: vm.baseUrl + '?search=' + vm.omni,
                    };
                    axios(config)
                        .then(response => {
                            vm.omniTerms = response.data;
                        })
                },
                100
            )
        }
    }
</script>