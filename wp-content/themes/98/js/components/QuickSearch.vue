<template>
    <form class="navbar-form form-inline" method="get" action="/properties/" >
        <input type="hidden" name="q" value="search" >
        <div class="container no-gutter">
            <div class="row">
                <div class="col-xs-12 col-md-9 col-lg-3 col-xl-4 offset-md-3 offset-lg-0">
                    <p class="search-form-label">PROPERTY <span>QUICK SEARCH</span></p>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3 col-xl-2 offset-md-3 offset-lg-0">
                    <omni-bar
                        v-model="omni"
                        :options="omniTerms"
                        :filter-function="applySearchFilter"
                        field-value=""
                    ></omni-bar>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <area-field></area-field>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <property-type></property-type>
                </div>
                <button
                    @click="toggleAdvanced"
                    type="button"
                    class="btn btn-primary dropdown-toggle col-xs-6 col-md-4 col-lg-1 offset-md-3 offset-lg-0"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    >Filter</button>
                <button type="submit" class="btn btn-danger col-xs-6 col-md-5 col-lg-1" >Search</button>
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
        <input name="page" value="1" type="hidden" >
    </form>
</template>

<script>
    export default {
        props: {

        },

        data() {
            return {
                advancedSearch: false,
                omni: null,
                omniTerms: [],
                baseUrl: 'https://navica.kerigan.com/api/v1/omnibar'
            }
        },

        watch: {
            omni: function (newOmni, oldOmni) {
                if (newOmni.length > 2) {
                    this.search();
                }
            }
        },

        methods: {
            toggleAdvanced(){
                this.advancedSearch = !this.advancedSearch;
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