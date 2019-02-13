<template>
    <div class="google-map" style="display:flex; width:100%; flex-wrap: wrap" >
        <div ref="map" class="col-xs-12 col-md-9" style="min-height: 600px; flex-grow:1" ></div>
        <div v-if="propOpen" class="col-xs-12 col-md-3 p-0" style="height:100%;">
            <mini-listing :listingData="selectedProperty"></mini-listing>
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
                default: ''
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
                errors: []
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
                            vm.getProperty(event.detail.mls_acct)
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
                    if (this.searchTerms[key] !== 'Any' && this.searchTerms[key] !== ''){
                        console.log(typeof this.searchTerms[key]);
                        if(typeof this.searchTerms[key] === 'object'){
                            request += '&' + key + '=';
                            Object.keys(this.searchTerms[key]).forEach(k => {
                                request += this.searchTerms[key][k] + '|';
                            });
                        }else{
                            request += '&' + key + '=' + this.searchTerms[key];
                        }
                    }
                });

                let endpoint = encodeURI("https://navica.kerigan.com/api/v1/map-search" + request);
                console.log(endpoint);

                axios.get(endpoint)
                .then(response => {
                    response.data.data.forEach(pin => {
                        if(pin.long < -85.042914){
                            vm.config.markers.push(pin);
                        }
                    })
                    // vm.config.markers = response.data.data;
                    vm.renderMap();
                })
                .catch(e => {
                    this.errors.push(e)
                })
            },

            getProperty(mlsAccount) {
            let vm = this;
            window.axios.get('https://navica.kerigan.com/api/v1/listing/' + mlsAccount)
                .then(response => {
                    vm.selectedProperty = response.data.data;
                    vm.propOpen = true;
                })
                .catch(e => {
                    this.errors.push(e)
                })
            }

        }

    }
</script>