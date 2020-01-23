<?php

imports("MVC.request");
imports("php.export");

class pakchoi {

    public static function getAvatarUrl($id) {
        if (is_array($id)) {
            $peoples = $id;
        } else {
            $peoples = (new Table("users"))->where(["id" => $id])->find();
        }

        if (empty($peoples["avatar"])) {
            # use default
            return "/assets/images/default.png";
        } else {
            return "/images/avatar/" . $peoples["avatar"];					
        }
    }

    public static function fillMsgSenderMentionUrl($messages) {
        $resources = [];

        for($i = 0; $i < count($messages); $i++) {
            if ($messages[$i]["mentions"] > 0) {
                $res_id = $messages[$i]["mentions"];
                $res_key = "T$res_id";

                if(!array_key_exists($res_key, $resources)) {
                    $res = (new Table("resources"))->where(["id" => $res_id])->find();

                    switch($res["type"]) {
                        case 0:
                            $resources[$res_key] = [
                                "title" => "评论相片 '{$res["filename"]}'",
                                "href" => "/view/photo/$res_id"
                            ];
                            break;
                        default:
                            $resources[$res_key] = [
                                "title" => "无效的资源目标",
                                "href" => "#"
                            ];
                    }
                }

                $messages[$i]["target"] = $resources[$res_key];
            }
        }
        
        return $messages;
    }

    public static function fillMsgSenderAvatarUrl($messages) {
        $avatars = [];

        for($i =0 ; $i < count($messages); $i++) {
            $usrId = $messages[$i]["send_from"];
            $usrKey = "T$usrId";
            $messages[$i]["message"] = base64_decode($messages[$i]["message"]); 

            if (!array_key_exists($usrKey, $avatars)) {
                $avatars[$usrKey] = pakchoi::getAvatarUrl($usrId);
            }

            $messages[$i]["avatar"] = $avatars[$usrKey];      
        }

        return $messages;
    }

    public static function getUploadDir() {
        return WWWROOT . "/upload";
    }

    public static function getImageExtensionName($rawfilename) {
        $ext = explode(".", $rawfilename);
        $ext = $ext[count($ext) -1];

        if (strlen($ext) > 4) {
            # This image file have no extension name
            return "jpg";
        } else {
            return strtolower($ext);
        }
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
            "分享相片", // 1
            "分享位置" // 2
        ];
    }

    public static function addActivity($type, $content, $resId) {
        $activity = new Table("activity");
        $data = [
            "type" => $type,
            "content" => $activity->EscapeString($content),
            "create_time" => Utils::Now(),
            "user" => $_SESSION["id"]            
        ];

        if (!empty($resId)) {
            $data["resource"] = $resId;
        }

        $result = $activity->add($data);

        if ($result != false) {
            # update activity count
            (new Table("users"))
            ->where(["id" => $_SESSION["id"]])
            ->save([
                "activities" => "~activities + 1"
            ]);

            if ($type == 1) {
                (new Table("users"))
                ->where(["id" => $_SESSION["id"]])
                ->save([
                    "photos" => "~photos + 1"
                ]);
            }  

            return $result;
        } else {
            return $activity->getLastMySql();
        }
    }

    public static function login_userId() {
        return Utils::ReadValue($_SESSION, "id", -1);
    }

    /**
     * Get data of current login user
    */
    public static function loginUser() {
        return (new Table("users"))
            ->where(["id" => self::login_userId()])
            ->find();
    }

    public static function sendLoginEmail($user) {
        include_once __DIR__ . "/mailto.php";

        $key = DotNetRegistry::Read("login.tokens", ["salt.key"]);
        $key = $key[random_int(0, count($key)-1)];
        $token = md5($key . $user["id"]);
        $ssid = urlencode(session_id());
        $time = urlencode(Utils::Now());
        $host = "http://47.94.16.9";
        $url = "$host/api/login_confirm?time=$time&token=$token&session=$ssid";

        $_SESSION["key"] = $key;
        $_SESSION["check"] = $user;

        return EMail::sendMail($user["email"], $user["nickname"], "登录确认", "请点击下面的链接完成登录", $url);
    }
}