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
        redirect("/");
    }
}