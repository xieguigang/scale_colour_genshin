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
    public function login_confirm() {        
        $token = $_GET["token"];
        $session = urldecode($_GET["session"]);

        session_abort();
        session_id($session);
        session_start();

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
                "content" => "在" . (new baiduMap())->GetUserGeoLocation() . "访问小站",
                "create_time" => Utils::Now(),
                "user" => pakchoi::login_userId()
            ]);

            (new Table("users"))->where([
                "id" => $_SESSION["id"]
            ])->save([
                "activities" => "~activities + 1"
            ]);
        } else {
            dotnet::AccessDenied("Invalid user login token!");
        }
    }

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
}