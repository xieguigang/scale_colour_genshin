<?php

include __DIR__ . "/../../modules/bootstrap.php";

class App {   
    
    /**
     * @uses api
    */
    public function latest_visits() {
        $visits = (new Table("pageview"))
        ->where(["user_id" => $_SESSION["id"], "code" => 200])
        ->limit(10)
        ->order_by("time", true)
        ->select();

        controller::success($visits);
    }

    /**
     * @uses api
    */
    public function latest_logins() {
        $logins = (new Table("activity"))
        ->where(["user" => $_SESSION["id"], "type" => 0])
        ->limit(10)
        ->order_by("create_time", true)
        ->select();

        controller::success($logins);
    }
}