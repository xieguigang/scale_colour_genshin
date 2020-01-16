<?php

include __DIR__ . "/../modules/bootstrap.php";

class App {
    
    /**
     * @access *
     * @require people=i32
     * @method POST
    */
    public function login() {
        $id = $_POST["people"];
        $user = (new Table("users"))->where(["id" => $id])->find();

        if ($user == false) {
            controller::error("Invalid user id!");
        } else {
            # send login email to target
            $result = pakchoi::sendLoginEmail($user);

            if ($result == true) {
                controller::success("Please check your email for login");
            } else {
                controller::error($result);
            }
        }
    }

    /**
     * @access *
    */
    public function login_check() {
        if (pakchoi::login_userId() > 0) {
            controller::success("1");
        } else {
            controller::success("no login");
        }
    }

    /**
     * @access *
     * @require token=string|session=string
     * @uses view
    */
    public function login_confirm() {        
        $token = $_GET["token"];
        $session = urldecode($_GET["session"]);

        session_id($session);

        $check = md5($_SESSION["key"] . $_SESSION["check"]["id"]);

        if ($check == $token) {
            # login success
            # write session
            foreach($_SESSION["check"] as $key => $value) {
                $_SESSION[$key] = $value;
            }

            $_SESSION["check"] = null;

            (new Table("activity"))->add([
                "type" => 0,  # 0 -> user login
                "content" => (new baiduMap())->GetUserGeoLocation(),
                "create_time" => Utils::Now(),
                "user" => pakchoi::login_userId()
            ]);
        } else {
            dotnet::AccessDenied("Invalid user login token!");
        }
    }
}