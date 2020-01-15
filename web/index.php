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
