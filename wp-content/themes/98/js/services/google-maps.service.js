import GoogleMapsLoader from 'google-maps';
import GeoLocator from './geolocator.service';
import MarkerClusterer from 'marker-clusterer-plus';

export default class GoogleMap {
    constructor(config, api) {
        this.config = config;
        this.map = {};
        this.apiKey = api;
        this.visibleMarkers = [];
        this.google = {};
        this.markerShape = {
            path: 'M0-48c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z',
            scale: 0.7,
            strokeWeight: 2,
            strokeColor: '#FFF',
            strokeOpacity: 0.5,
            fillColor: '#555',
            fillOpacity: 1,
            rotation: 0
        };
        this.selectedShape = {
            path: 'M0-48c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z',
            scale: 0.7,
            strokeWeight: 4,
            strokeColor: '#55ff00',
            strokeOpacity: 0.5,
            fillColor: '#555',
            fillOpacity: 1,
            rotation: 0
        };
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
                    url: '/img/m1.png',
                    height: 50,
                    width: 50,
                    textColor: '#333333',
                    textSize: 12
                }, {
                    url: '/img/m2.png',
                    height: 60,
                    width: 60,
                    textColor: '#333333',
                    textSize: 12
                }, {
                    url: '/img/m3.png',
                    width: 70,
                    height: 70,
                    textColor: '#333333',
                    textSize: 13
                }, {
                    url: '/img/m4.png',
                    width: 80,
                    height: 80,
                    textColor: '#333333',
                    textSize: 13
                }, {
                    url: '/img/m5.png',
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

            let latLng = new google.maps.LatLng(markers[i].latitude, markers[i].longitude)
            if (bounds.contains(latLng)) {
                let marker = new google.maps.Marker({
                    position: latLng,
                    map: mapData.map,
                    draggable: false,
                    flat: true,
                    icon: instance.markerShape
                });
                visibleMarkers.push(marker);

                marker.addListener('click', function () {
                    instance.resetIcons(visibleMarkers);
                    mapData.selected = markers[i];
                    this.setIcon(instance.selectedShape);
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