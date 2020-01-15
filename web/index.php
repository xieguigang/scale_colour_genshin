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
        if (pwa::login_userId() < 0) {
            # 未登录状态
            View::Display(["hide" => "display: none;"]);
        } else {
            Redirect("/home");
        }
    }

    /**
     * @uses view
     * @access *
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
     * @access *
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
