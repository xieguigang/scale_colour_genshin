<?php

include __DIR__ . "/../modules/bootstrap.php";

/**
 * File proxy
*/
class App {
    
    /**
     * Transfer the static assets files
     * 
     * @access *
     * @require resource=string
    */
    public function assets() {
        $resource = trim($_GET["resource"], "./\\ ");
        $resource = WWWROOT . "/assets/$resource";
        
        if (file_exists($resource)) {
            Utils::PushDownload($resource);
        } else {
            dotnet::PageNotFound($_GET["resource"]);
        }
    }

    /**
     * 
    */
    public function audio() {

    }
}