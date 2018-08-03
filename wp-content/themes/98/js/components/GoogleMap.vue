<template>
    <div class="google-map" style="display:flex; width:100%; flex-wrap: wrap" >
        <div ref="map" class="col-xs-12 col-md-9 col-lg-10" style="min-height: 600px; flex-grow:1" ></div>
        <div v-if="propOpen" class="col-xs-12 col-md-3 col-lg-2">
            <mini-listing :listingData="selectedProperty" ></mini-listing>
        </div>
    </div>
</template>

<script>
import GoogleMap from '../services/google-maps.service.js';

    export default {
        props: {
            latitude: {
                type: Number,
                default: this.latitude
            },
            longitude: {
                type: Number,
                default: this.longitude
            },
            zoom: {
                type: Number,
                default: this.zoom
            },
            api: {
                type: String,
                default: 'AIzaSyCRXeRhZCIYcKhtc-rfHCejAJsEW9rYtt4'
            },
            searchTerms: {
                type: Object,
                default: () => {}
            }
        },

        data() {
            return {
                renderedMap: {},
                config: {},
                isLoading: true,
                propOpen: false,
                selectedProperty: {},
                searchData: {},
                params: '',
                errors: [],
                pins: []
            }
        },
        mounted () {
            this.config = {
                zoom: this.zoom,
                center: {
                    latitude: this.latitude,
                    longitude: this.longitude
                },
                mapElement: this.$refs.map,
                markers: [],
                origin: {}
            };
            this.buildQuery();
            this.setCenter();
        },

        watch: {
            latitude: function () {
                this.config = {
                    zoom: this.zoom,
                    center: {
                        latitude: this.latitude,
                        longitude: this.longitude
                    },
                    mapElement: this.$refs.map,
                    markers: [],
                    origin: {}
                };
                this.buildQuery();
                this.setCenter();
            }
        },

        methods: {
            buildQuery() {
                let queryString = '?q=search';
                Object.keys(this.searchTerms).forEach(key => {
                    if(this.searchTerms[key] != 'Any'){
                        queryString += '&' + key + '=' + this.searchTerms[key];
                    }
                });
                this.params = queryString;
            },

            renderMap() {
                let vm = this;
                new GoogleMap(vm.config, vm.api)
                    .load()
                    .then(rendered => {
                        vm.renderedMap = rendered;
                        window.addEventListener('marker_updated', function (event) {
                            vm.getProperty(event.detail.mls_account)
                        });
                    });
            },

            setCenter(){
                this.getMarkers();
            },

            getMarkers() {
                let vm = this;
                let request = '?q=search';

                Object.keys(this.searchTerms).forEach(key => {
                    request += '&' + key + '=' + this.searchTerms[key];
                });

                axios.get("https://rafgc.kerigan.com/api/v1/map-search" + request)
                .then(response => {
                    vm.config.markers = response.data.data;
                    vm.renderMap();
                    this.pins = response.data.data; 
                })
                .catch(e => {
                    this.errors.push(e)
                })
            },

            getProperty(mlsAccount) {
            let vm = this;
            window.axios.get('https://rafgc.kerigan.com/api/v1/listing/' + mlsAccount)
                .then(response => {
                    vm.selectedProperty = response.data;
                    vm.propOpen = true;
                })
                .catch(e => {
                    this.errors.push(e)
                })
            }

        }

    }
</script>