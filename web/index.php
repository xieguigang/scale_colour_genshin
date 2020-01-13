<?php

include __DIR__ . "/../modules/bootstrap.php";

class App {
    
    /**
     * @uses view
    */
    public function index() {
        View::Display();
    }
}