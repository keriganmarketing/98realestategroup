export default class GeoLocator {
    geolocate() {
        return new Promise(function (resolve, reject) {
            navigator.geolocation.getCurrentPosition(resolve, reject);
        });
    }
    getLocation () {
        if (navigator.geolocation) {
            return this.geolocate()
                .then(position => {
                    return {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                    };
                })
                .catch(error => {
                    switch (error.code) {
                    case error.PERMISSION_DENIED:
                        throw new Error("You must enable location permissions to get directions");
                    case error.POSITION_UNAVAILABLE:
                        throw new Error("Your location information is currently unavailable.");
                    case error.TIMEOUT:
                        throw new Error("The request to get your location information timed out.");
                    default:
                        throw new Error("An unexpected error has occurred. Please try again.");
                    }
                });
        }
    }
}
