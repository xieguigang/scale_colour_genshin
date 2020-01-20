namespace webapp.modules {

    export function getLocation() {
        if ($ts.location.url.protocol.toLowerCase() == "http") {
            // 非https链接会被浏览器拒绝调用API
            // 则这个时候在服务器端使用ip定位
            ipLocation();
        } else {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("浏览器不支持地理定位。");
            }
        }
    }

    function ipLocation() {
        $ts.post("@api:addGeoLoc", { fallback: true }, function (result) {
            console.log(result);
        });
    }

    function showPosition(position: Position) {
        var lat = position.coords.latitude; //纬度 
        var lag = position.coords.longitude; //经度 

        $ts.post("@api:addGeoLoc", { latitude: lat, longitude: lag }, function (result) {
            console.log('纬度:' + lat + ',经度:' + lag);
        });
    }

    function showError(error: PositionError) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                alert("定位失败,用户拒绝请求地理定位");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("定位失败,位置信息是不可用");
                break;
            case error.TIMEOUT:
                alert("定位失败,请求获取用户位置超时");
                break;
            default:
                alert("定位失败,定位系统失效");
                break;
        }
    }

}