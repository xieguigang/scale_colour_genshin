<?php

imports("MVC.request");

class pakchoi {

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