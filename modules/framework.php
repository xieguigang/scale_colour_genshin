<?php

imports("MVC.request");
imports("php.export");

class pakchoi {

    public static function getUploadDir() {
        return WWWROOT . "/upload";
    }

    public static function getUploadResource($resource) {
        $tokens = explode("/", $resource);
        $user_id = $tokens[0];
        $resource = "{$tokens[1]}/{$tokens[2]}";
        $file = (new Table("resources"))->where([
            "uploader" => $user_id, 
            "resource" => $resource
        ])->find();

        return $file;
    }

    public static function getActivityTags() {
        return [
            "访问", // 0
            "分享相片"
        ];
    }

    public static function addActivity($type, $content, $resId) {
        (new Table("activity"))->add([
            "type" => $type,
            "content" => $content,
            "create_time" => Utils::Now(),
            "user" => $_SESSION["id"],
            "resource" => $resId
        ]);

        # update activity count
        (new Table("users"))->where(["id" => $_SESSION["id"]])->save(["activities" => "~activities + 1"]);

        if ($type == 1) {
            (new Table("users"))->where(["id" => $_SESSION["id"]])->save(["photos" => "~photos + 1"]);
        }        
    }

    public static function login_userId() {
        return Utils::ReadValue($_SESSION, "id", -1);
    }

    public static function loginUser() {
        return (new Table("users"))->where(["id" => self::login_userId()])->find();
    }

    public static function sendLoginEmail($user) {
        include_once __DIR__ . "/mailto.php";

        $key = DotNetRegistry::Read("login.tokens", ["salt.key"]);
        $key = $key[random_int(0, count($key)-1)];
        $token = md5($key . $user["id"]);
        $ssid = urlencode(session_id());
        $url = "http://47.94.16.9:83/api/login_confirm?token=$token&session=$ssid";

        $_SESSION["key"] = $key;
        $_SESSION["check"] = $user;

        return EMail::sendMail($user["email"], $user["nickname"], "登录确认", "请点击下面的链接完成登录", $url);
    }
}