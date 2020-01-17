<?php

include __DIR__ . "/../modules/bootstrap.php";

class App {
    
    /**
     * @uses view
     * @access *
    */
    public function index() {
        View::Display(["hide" => "display: none;"]);
    }
    
    /**
     * 登录
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
			$default = "/assets/images/default.png";
			
			for($i = 0; $i < count($peoples); $i++) {
				if (empty($peoples[$i]["avatar"])) {
					# use default
					$peoples[$i]["avatar"] = $default;
				} else {
					$peoples[$i]["avatar"] = "/files/image/" . $peoples[$i]["avatar"];					
				}
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
     * @uses view
    */
    public function home() {
        # 在最开始获取最近的10条
        $latest10 = (new Table("activity"))
            ->order_by("create_time", true)
            ->limit(10)
            ->select();
        $tags = pakchoi::getActivityTags();

        for($i = 0; $i < count($latest10); $i++) {
            $type = $latest10[$i]["type"];
            $latest10[$i]["tag"] = $tags[$type];

            if ($type == 0) {
                # 登录动态是使用默认的地图图片的
                $latest10[$i]["resource"] = "/assets/images/map.jpg";
                $latest10[$i]["content"] = $_SESSION["nickname"] . $latest10[$i]["content"];
            }

            
        }

        View::Display([
            "home.active" => "active",
            "latest" => $latest10
        ]);
    }

	/**
     * @uses view
     * 
    */
    public function gallery() {
        View::Display(["gallery.active" => "active"]);
    }
    
    /**
     * @uses view
     * 
    */
    public function share_photo() {
        View::Display(["gallery.active" => "active"]);
    }

    /**
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
            "n.activity" => $user["activities"]
        ]);
    }

	/**
	 * Update site source file from github repository
	 *
	 * @uses api
	 * @access admin
	*/
    public function update() {
		
    }
}
