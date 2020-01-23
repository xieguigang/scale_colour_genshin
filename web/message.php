<?php

include __DIR__ . "/../modules/bootstrap.php";

class App {

    /**
     * Get latest message
     * 
     * @uses api
     * @require last_id=i32
    */
    public function updates() {
        $last_id = $_GET["last_id"];
        $messages = (new Table("messages"))->where([
            "id" => gt($last_id)
        ])->order_by("message_time", false)
          ->select();       

        controller::success(pakchoi::fillMsgSenderAvatarUrl($messages));
    }

    /**
     * Get history message
     * 
     * @uses api
    */
    public function history() {
        $history_id = WebRequest::getInteger("history_id", 0);

        if ($history_id == 0) {
            # get latest 10;
            $messages = (new Table("messages"))
              ->order_by("message_time", true)
              ->limit(10)
              ->select();      
        } else {
            $messages = (new Table("messages"))
              ->where(["id", lt($history_id)])
              ->order_by("message_time", true)
              ->limit(5)
              ->select();
        }

        controller::success(pakchoi::fillMsgSenderAvatarUrl($messages));
    }
}