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
    */
    public function gallery() {
    	View::Display();
    }
	
	/**
	 * @uses api
	 * @access *
	*/
    public function update() {
		
    }
}
