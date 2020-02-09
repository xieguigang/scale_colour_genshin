<?php

include __DIR__ . "/../modules/bootstrap.php";

class App {   

    /**
     * @uses api
     * @method POST
    */
    public function save() {
        if ((new Table("users"))->where(["id" => $_SESSION["id"]])->save($_POST)) {
            controller::success("saved");
        } else {
            controller::success("Invalid characters!");
        }
    }

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

    /**
     * 分享当前的位置
     * 
     * @uses api
     * @method POST
    */
    public function share_geoLocation() {
        if ($_POST["fallback"] == true) {
            $content = (new baiduMap())->GetUserGeoLocation(true);
            $content["fallback"] = true;
        } else {
            $latitude = $_POST["latitude"];
            $longitude = $_POST["longitude"];
            $content = [
                "latitude" => $latitude,
                "longitude" => $longitude,
                "fallback" => false
            ];
        }

        $result = pakchoi::addActivity(2, json_encode($content), null);

        if (is_string($result)) {
            controller::error($result);
        } else {
            controller::success($result);
        }
    }

    /**
     * @uses api
     * @require id=i32
    */
    public function getLocation() {       
        $id = $_GET["id"];
        $location = (new Table("activity"))->where(["id" => $id])->find();
        $content = json_decode($location["content"], true);
        $content["create_time"] = $location["create_time"];
        $content["user"] = $location["user"];

        controller::success($content);
    }

    /**
     * Get comments data for a given resource object
     * 
     * @uses api
     * @require resource=i32
    */
    public function get_comment() {
        $resource = $_GET["resource"];
        $messages = (new Table("messages"))->where([
            "mentions" => $resource
        ])->order_by("message_time", true)
          ->select();       
        
        controller::success(pakchoi::fillMsgSenderAvatarUrl($messages));
    }

    /**
     * @uses api
     * @method POST
     * 
     * @require resource=i32|comment=string
    */
    public function comment() {
        $resource = $_POST["resource"];
        $comment = $_POST["comment"];
        $userId = $_SESSION["id"];
        $messages = new Table("messages");
        $newId = $messages->add([
            "send_from" => $userId,
            "message_time" => Utils::Now(),
            "message" => base64_encode($comment),
            "mentions" => $resource
        ]);

        if ($newId == false) {
            controller::error($messages->getLastMySql());
        } else {
            controller::success($newId);
        }
    }

    /**
     * @uses api
    */
    public function more() {
        $latest_id = $_GET["latest_id"];
        # 在最开始获取最近的10条
        $latest10 = (new Table("activity"))
            ->where(["type" => not_eq(0), "id" => lt_eq($latest_id)])
            ->order_by("create_time", true)
            ->limit(10)
            ->select();
        $tags = pakchoi::getActivityTags();   
        $resource = new Table("resources");

        for($i = 0; $i < count($latest10); $i++) {
            $type = $latest10[$i]["type"];
            $latest10[$i]["tag"] = $tags[$type];
            $user = $latest10[$i]["user"];
            $user = (new Table("users"))->where(["id" => $user])->find();

            $latest10[$i]["content"] = $user["nickname"] . $latest10[$i]["content"];

            if ($type == 0) {
                # 登录动态是使用默认的地图图片的
                $latest10[$i]["resource"] = "/assets/images/map.jpg";
            } else if ($type == 1) {
                $res = $resource->where(["id" => $latest10[$i]["resource"]])->find();
                $id = $user["id"];
                $url = "/images/$id/" . $res["resource"] . "?type=thumbnail";
                $latest10[$i]["resource"] = $url;
                $latest10[$i]["link"] = "/view/photo/" . $res["id"];
            } else if ($type == 2) {
                # 查看分享的位置
                $latest10[$i]["resource"] = "/assets/images/map.jpg";
                $latest10[$i]["link"] = "/view/location/" . $latest10[$i]["id"];
            }           
        }

        controller::success($latest10);
    }

    /**
     * 添加对上传的资源的描述信息
     * 
     * @uses api
     * @require res=i32
     * @method POST
    */
    public function resource_note() {
        $note = $_POST["note"];
        $id = $_POST["res"];

        (new Table("resources"))
        ->where(["id" => $id])
        ->save(["description" => $note]);

        controller::success(1);
    }

    /**
     * 上传相片
     * 
     * @uses api
     * @method POST
    */
    public function upload_image() {
        imports("Microsoft.VisualBasic.FileIO.FileSystem");

        $file = $_FILES["File"];
        $tmp = $file["tmp_name"];
        $id = $_SESSION["id"];
        $year = year();
        $upload_path = pakchoi::getUploadDir() . "/images/$id/$year/";

        FileSystem::CreateDirectory($upload_path);

        $name = md5(Utils::Now() . $tmp);
        $upload_path = "$upload_path/$name";

        move_uploaded_file($tmp, $upload_path);

        $resId = (new Table("resources"))->add([
            "type" => 0,
            "filename" => $file["name"],
            "upload_time" => Utils::Now(),
            "size" => $file["size"],
            "description" => "",
            "uploader" => $id,
            "resource" => "$year/$name"
        ]);

        if ($resId > 0) {
            pakchoi::addActivity(1, "分享了相片 {$file["name"]}", $resId);
            controller::success($resId);
        } else {
            controller::error("error!");
        }
    }

    /**
     * @uses api
    */
    public function load_gallery() {
        # get latest 10 resource activity
        $latest = (new Table("resources"))
            ->order_by("upload_time", true)
            // ->limit(10)
            ->select();        

        for($i = 0; $i < count($latest); $i++) {
            # $upload_path = pakchoi::getUploadDir() . "/images/$id/$year/";
            $id = $latest[$i]["uploader"];
            $latest[$i]["url"] = "/images/$id/" . $latest[$i]["resource"];
        }

        controller::success($latest);
    }

    /**
     * @uses api
     * @method POST
    */
    public function upload_avatar() {
        imports("Microsoft.VisualBasic.FileIO.FileSystem");

        $file = $_FILES["File"];
        $tmp = $file["tmp_name"];        
        $name = md5($tmp . $file["name"]);
        $ext = pakchoi::getImageExtensionName($file["name"]);
        $upload_path = pakchoi::getUploadDir() . "/avatars";

        FileSystem::CreateDirectory($upload_path . "/$ext");

        $id = $_SESSION["id"];
        $name = "$ext/$id" . "_$name";
        $upload_path = $upload_path . "/" . $name;

        move_uploaded_file($tmp, $upload_path);

        # write to user profile
        if (!file_exists($upload_path)) {
            controller::error("error!");
        } else {
            (new Table("users"))->where([
                "id" => $id
            ])->save(["avatar" => $name]);
        }        

        controller::success(1);
    }

    /**
     * @uses api
     * @method POST
    */
    public function add_memorial() {
        $event = $_POST["event"];
        $date = $_POST["date"];

        imports("System.DateTime");

        $date = System\DateTime::FromTimeStamp($date)->ToString();
        $anniversary = new Table("anniversary");
        $id = $anniversary->add([
            "date" => $date,
            "description" => $event,
            "add_user" => pakchoi::login_userId()
        ]);

        if (false == $id) {
            controller::error($anniversary->getLastMySql());
        } else {
            controller::success(1);
        }
    }

    /**
     * @uses api
     * @method GET
    */
    public function get_memorials() {
        $events = (new Table("anniversary"))->all();

        for($i = 0; $i < count($events); $i++) {
            $events[$i]["name"] = pakchoi::getNickName($events[$i]["add_user"]);
            $events[$i]["add_user"] = pakchoi::getAvatarUrl($events[$i]["add_user"]);
        }

        controller::success($events);
    }

    /**
     * @uses api
     * @method GET
     * @require id=i32
    */
    public function get_memorial() {
        $id = $_GET["id"];
        $evt = (new Table("anniversary"))->where(["id" => $id])->find();

        if ($evt == false) {
            controller::error("not found");
        } else {
            $evt["name"] = pakchoi::getNickName($evt["add_user"]);
            $evt["add_user"] = pakchoi::getAvatarUrl($evt["add_user"]);

            controller::success($evt);
        }
    }
}