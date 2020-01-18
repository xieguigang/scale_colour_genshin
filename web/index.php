<?php

include __DIR__ . "/../modules/bootstrap.php";

class App {
    
    /**
     * 欢迎使用pakchoi
     * 
     * @uses view
     * @access *
    */
    public function index() {
        View::Display([
            "hide" => "display: none;",
            "who" => pakchoi::login_userId() >= 0 ? "Hi, " . $_SESSION["nickname"] : "欢迎使用pakchoi" 
        ]);
    }
    
    /**
     * 登录pakchoi
     * 
     * 如果已经存在登录会话，则跳转至home页面
     * 否则显示登录页面
     * 
     * @uses view
     * @access *
    */
    public function login() {
        if (pakchoi::login_userId() <= 0) {
			# get user list
			$peoples = (new Table("users"))->all();			
			
			for($i = 0; $i < count($peoples); $i++) {
				$peoples[$i]["avatar"] = pakchoi::getAvatarUrl($peoples[$i]);
			}
			
            # 未登录状态
            View::Display([
				"peoples" => $peoples, 
				"hide" => "display: none;"
			]);
        } else {
            Redirect("/home");
        }
    }

    /**
     * 主页·新鲜事
     * 
     * @uses view
    */
    public function home() {
        # 在最开始获取最近的10条
        $latest10 = (new Table("activity"))
            ->where(["type" => not_eq(0)])
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
            }            
        }

        View::Display([
            "home.active" => "active",
            "latest" => $latest10
        ]);
    }

	/**
     * 相册
     * 
     * @uses view
     * 
    */
    public function gallery() {
        # get latest 10 resource activity
        $latest = (new Table("resources"))
            ->order_by("upload_time", true)
            ->limit(10)
            ->select();
        $id = $_SESSION["id"];

        for($i = 0; $i < count($latest); $i++) {
            # $upload_path = pakchoi::getUploadDir() . "/images/$id/$year/";
            $latest[$i]["url"] = "/images/$id/" . $latest[$i]["resource"];
        }

        View::Display([
            "gallery.active" => "active",
            "photos" => $latest
        ]);
    }
    
    /**
     * 分享相片
     * 
     * @uses view
     * 
    */
    public function share_photo() {
        View::Display(["gallery.active" => "active"]);
    }

    /**
     * 查看相片
     * 
     * @uses view
     * @require id=i32
    */
    public function view_photo() {       
        $res = (new Table("resources"))->where(["id" => $_GET["id"], "type" => 0])->find();

        if ($res == false) {
            dotnet::PageNotFound("Target resource not found!");
        }

        $id = $res["uploader"];
        $raw = "/images/$id/" . $res["resource"];
        $previews =  $raw . "?type=preview";
        $upload_user = (new Table("users"))->where(["id" => $id])->find();

        View::Display([
            "gallery.active" => "active",
            "resource" => $previews,
            "nickname" => $upload_user["nickname"],
            "create_time" => $res["upload_time"],
            "description" => $res["description"],
            "raw" => $raw
        ]);
    }

    /**
     * 我
     * 
     * @uses view
    */
    public function profile() {
        $user = pakchoi::loginUser();

        View::Display([
            "profile.active" => "active",
            "name" => $user["nickname"],
            "fullname" => $user["fullname"],
            "whats.up" => $user["whats_up"],
            "n.posts" => $user["posts"],
            "n.photo" => $user["photos"],
            "n.activity" => $user["activities"],
            "avatar" => pakchoi::getAvatarUrl($user)
        ]);
    }

    /**
     * 编辑我的信息
     * 
     * @uses view
    */
    public function edit_profile() {
        $me = pakchoi::loginUser();

        View::Display([
            "profile.active" => "active",
            "avatar" => pakchoi::getAvatarUrl($me),
            "whatsup" => $me["whats_up"],
            "email" => $me["email"],
            "nickname" => $me["nickname"]
        ]);
    }

	/**
     * 后台更新
     * 
	 * Update site source file from github repository
	 *
	 * @uses api
	 * @access admin
	*/
    public function update() {
		
    }
}
