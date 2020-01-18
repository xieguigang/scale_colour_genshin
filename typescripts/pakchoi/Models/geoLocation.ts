namespace webapp.models {

    export function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("???????????");
        }
    }

    function showPosition(position) {
        console.log(position);
        var lat = position.coords.latitude; //?? 
        var lag = position.coords.longitude; //?? 
        console.log('??:' + lat + ',??:' + lag);
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                alert("????,??????????");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("????,????????");
                break;
            case error.TIMEOUT:
                alert("????,??????????");
                break;
            case error.UNKNOWN_ERROR:
                alert("????,??????");
                break;
        }
    }
}