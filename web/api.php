<?php

include __DIR__ . "/../modules/bootstrap.php";

class App {
    
    /**
     * @access *
     * @require people=i32
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
}