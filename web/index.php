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
        $welcome = pakchoi::login_userId() >= 0 ? "Hi, " . $_SESSION["nickname"] : "欢迎使用pakchoi";

        View::Display([
            "hide" => "display: none;",
            "who" => $welcome
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
        $latest_id = (new Table("activity"))->ExecuteScalar("max(`id`)") + 1;

        View::Display([
            "home.active" => "active",
            "latest_id" => $latest_id
        ]);
    }

    /**
     * 目标与进展
     * 
     * @uses view
    */
    public function goals() {
        View::Display([
            "home.active" => "active"          
        ]);
    }

    /**
     * 纪念日
     * 
     * @uses view
    */
    public function memorials() {
        View::Display([
            "home.active" => "active"          
        ]);
    }

    /**
     * 添加纪念日
     * 
     * @uses view
    */
    public function share_memorial() {
        View::Display([
            "home.active" => "active"          
        ]);
    }

    /**
     * 吐槽与聊天
     * 
     * @uses view
    */
    public function chat() {
        View::Display([
            "comment.active" => "active"
        ]);
    }

	/**
     * 相册
     * 
     * @uses view
     * 
    */
    public function gallery() {
        View::Display([
            "gallery.active" => "active"            
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
     * 分享视频
     * 
     * @uses view
     * 
    */
    public function share_video() {
        View::Display(["gallery.active" => "active"]);
    }

    /**
     * 查看相片
     * 
     * @uses view
     * @require id=i32
    */
    public function view_photo() {       
        $res = (new Table("resources"))
              ->where([
                "id" => $_GET["id"], 
                "type" => 0
            ])->find();

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
            "raw" => $raw,
            "resource_id" => $res["id"]
        ]);
    }

    /**
     * 查看视频
     * 
     * @uses view
     * @require id=i32
    */
    public function view_video() {       
        $res = (new Table("resources"))
              ->where([
                "id" => $_GET["id"], 
                "type" => 2
            ])->find();

        if ($res == false) {
            dotnet::PageNotFound("Target resource not found!");
        }

        $id = $res["uploader"];
        $raw = "/video/$id/" . $res["resource"];
        $previews =  $raw . "?type=preview&direct_stream=true";
        $upload_user = (new Table("users"))->where(["id" => $id])->find();

        View::Display([
            "gallery.active" => "active",
            "resource" => $previews,
            "nickname" => $upload_user["nickname"],
            "create_time" => $res["upload_time"],
            "description" => $res["description"],
            "raw" => $raw,
            "resource_id" => $res["id"]
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
     * 查看分享的位置
     * 
     * @uses view
     * @require id=i32
    */
    public function view_location() {
        $id = $_GET["id"];
        $location = (new Table("activity"))
            ->where(["id" => $id])
            ->find();
        $usr = (new Table("users"))
            ->where(["id" => $location["user"]])
            ->find();

        View::Display([
            "home.active" => "active",
            "id" => $id,
            "nickname" => $usr["nickname"],
            "create_time" => $location["create_time"],
            "description" => ""
        ]);
    }

    /**
     * 查看地理位置
     * 
     * @uses view
     * @require x=double|y=double
    */
    public function baiduMap() {
        $_GET["key"] = DotNetRegistry::Read("baidumap.webkey");
        View::Display($_GET);
    }

    /**
     * 查看详情
     * 
     * @uses view
     * @require id=i32
    */
    public function view_memorial() {
        $id = $_GET["id"];

        View::Display([
            "home.active" => "active",
            "id" => $id
        ]);
    }
}
