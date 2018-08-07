import GoogleMapsLoader from 'google-maps';
import MarkerClusterer from 'marker-clusterer-plus';

export default class GoogleMap {
    constructor(config, api) {
        this.config = config;
        this.map = {};
        this.apiKey = api;
        this.visibleMarkers = [];
        this.google = {};
    }

    load() {
        return new Promise((resolve, reject = null) => {
            resolve(this.init());
        });
    }

    init() {
        GoogleMapsLoader.KEY = this.apiKey;
        GoogleMapsLoader.load(google => {
            this.renderMap(google);
            this.addMarkers(google);
        });
    }

    renderMap(google) {
        let config = this.config;
        let mapData = this.map;

        mapData.map = new google.maps.Map(config.mapElement, {
            zoom: config.zoom,
            center: new google.maps.LatLng(config.center.latitude, config.center.longitude),
            disableDefaultUI: true,
            zoomControl: true,
            scaleControl: true,
            maxZoom: 20
        });

        mapData.markerClusterer = new MarkerClusterer(
            mapData.map,
            this.visibleMarkers,
            {
                maxZoom: 17,
                gridSize: 80,
                ignoreHidden: true,
                styles: [{
                    url: '/wp-content/themes/98/img/m1.png',
                    height: 50,
                    width: 50,
                    textColor: '#333333',
                    textSize: 12
                }, {
                    url: '/wp-content/themes/98/img/m2.png',
                    height: 60,
                    width: 60,
                    textColor: '#333333',
                    textSize: 12
                }, {
                    url: '/wp-content/themes/98/img/m3.png',
                    width: 70,
                    height: 70,
                    textColor: '#333333',
                    textSize: 13
                }, {
                    url: '/wp-content/themes/98/img/m4.png',
                    width: 80,
                    height: 80,
                    textColor: '#333333',
                    textSize: 13
                }, {
                    url: '/wp-content/themes/98/img/m5.png',
                    width: 90,
                    height: 90,
                    textColor: '#333333',
                    textSize: 14
                }]
            }
        );

        return mapData;
    }

    addMarkers(google) {
        let mapData = this.map;
        let instance = this;

        google.maps.event.addListener(mapData.map, 'idle', function () {
            instance.drawMarkers(google);
        });
    }

    drawMarkers(google) {
        this.visibleMarkers = [];
        let instance = this;
        let markers = this.config.markers;
        let mapData = this.map;
        let visibleMarkers = this.visibleMarkers;
        let bounds = mapData.map.getBounds();

        for (let i = 0; i < markers.length; i++) {

            let latLng = new google.maps.LatLng(markers[i].lat, markers[i].long)
            if (bounds.contains(latLng)) {
                let listingClass = 'RES';
                let marker = new google.maps.Marker({
                    position: latLng,
                    map: mapData.map,
                    draggable: false,
                    flat: true,
                    icon: '/wp-content/themes/98/img/map-pin-' + listingClass + '-' + markers[i].status.toLowerCase() + '.png'
                });
                visibleMarkers.push(marker);

                marker.addListener('click', function () {
                    mapData.selected = markers[i];
                    window.dispatchEvent(new CustomEvent('marker_updated', {
                        detail: markers[i]
                    }));
                });
            }
        }
        if (mapData.markerClusterer) {
            mapData.markerClusterer.clearMarkers();
            mapData.markerClusterer.addMarkers(visibleMarkers);
        }
    }

    resetIcons(markers) {
        for (let i = 0; i < markers.length; i++) {
            markers[i].setIcon(this.markerShape);
        }
    }

    getDirections(button, panel) {
        GoogleMapsLoader.KEY = this.apiKey;
        GoogleMapsLoader.load(google => {

            let config = this.config;
            let mapData = this.map;

            mapData.map = new google.maps.Map(config.mapElement, {
                zoom: config.zoom,
                center: new google.maps.LatLng(config.center.latitude, config.center.longitude),
                disableDefaultUI: true,
                zoomControl: true,
                scaleControl: true,
                maxZoom: 20
            });

            let directionsDisplay = new google.maps.DirectionsRenderer({
                origin: new google.maps.LatLng(config.origin.latitude, config.origin.longitude),
                destination: new google.maps.LatLng(config.center.latitude, config.center.longitude),
                travelMode: 'DRIVING',
            });

            let directionsService = new google.maps.DirectionsService();
            directionsDisplay.setPanel(panel);
            directionsService.route({
                origin: directionsDisplay.origin,
                destination: directionsDisplay.destination,
                travelMode: 'DRIVING'
            }, function (response, status) {
                if (status === 'OK') {
                    return directionsDisplay.setDirections(response);
                } else {
                    return window.alert('Directions request failed due to ' + status);
                }
            });
            directionsDisplay.setMap(mapData.map);
        });
    }
}