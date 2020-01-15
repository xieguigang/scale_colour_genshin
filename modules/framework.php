<?php

imports("MVC.request");

class pwa {

    public static function login_userId() {
        return Utils::ReadValue($_SESSION, "id", -1);
    }
}