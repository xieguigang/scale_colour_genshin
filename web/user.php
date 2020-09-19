<?php

include __DIR__ . "/../modules/bootstrap.php";

class App {

    /**
     * 用户在客户端拉起登录会话
     * 
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
     * 检查登录是否成功
     * 
     * @uses api
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
     * 通过访问电子邮件中的这个链接确认登录
     * 
     * @access *
     * @require token=string|session=string
     * @uses view
    */
    public function login_confirm($token, $session) {
        $session = urldecode($session);

        session_abort();
        session_id($session);
        session_start();

        $check = md5($_SESSION["key"] . $_SESSION["check"]["id"]);

        if ($check == $token) {
            $this->doLogin();
        } else {
            dotnet::AccessDenied("Invalid user login token!");
        }
    }

    private function doLogin() {
        # login success
        # write session
        foreach($_SESSION["check"] as $key => $value) {
            $_SESSION[$key] = $value;
        }

        $_SESSION["check"] = null;

        (new Table("activity"))->add([
            "type" => 0,  # 0 -> user login
            "content" => "在" . (new baiduMap())->GetUserGeoLocation() . "访问小站",
            "create_time" => Utils::Now(),
            "user" => pakchoi::login_userId()
        ]);

        (new Table("users"))->where([
            "id" => $_SESSION["id"]
        ])->save([
            "activities" => "~activities + 1"
        ]);

        View::Show(dirname(__DIR__) . "/modules/views/etc/login_success.html",[
            "title" => "登陆成功"
        ]);
    }
}