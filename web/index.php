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
        if (pakchoi::login_userId() < 0) {
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
        View::Display(["home.active" => "active"]);
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
    */
    public function profile() {
        View::Display(["profile.active" => "active"]);
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
