<?php

include __DIR__ . "/../modules/bootstrap.php";

class App {
    
    /**
     * @uses view
     * @access *
    */
    public function index() {
        View::Display();
    }
    
    /**
     * @uses view
     * @access *
    */
    public function home() {
        View::Display();
    }

	/**
     * @uses view
    */
    public function gallery() {
    	View::Display();
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
