<?php

imports("Microsoft.VisualBasic.Net.CURL");
imports("Microsoft.VisualBasic.Strings");

class baiduMap {

    const api = "http://api.map.baidu.com/location/ip";

    private $key;

    public function __construct() {
        $this->key = DotNetRegistry::Read("baidumap.key");
    }

    public function GetUserIP() {
        return Utils::UserIPAddress();
    }

    public function GetUserGeoLocation() {
        $ip       = $this->GetUserIP();
        $argv     = [
            "ip" => $ip, 
            "ak" => $this->key
        ]; 
        $url      = baiduMap::api . "?" . http_build_query($argv);
        $response = json_decode(CURLExtensions::GET($url));

        if (property_exists($response, "content")) {
            $location = $response->content->address;
        } else {
            $location = "未知位置";
        }
		
		if (Strings::Empty($location, true)) {
            # 来自境外地区的登陆，百度地图无法得到查询结果
            # 在这里统一标记为美国地区，值不留空
            $location = "美国";
        }
		
        return $location;
    }
}