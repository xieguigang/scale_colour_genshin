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
        $resource = WebRequest::getPath("resource");
        $resource = WWWROOT . "/assets/$resource";
        
        if (!empty($resource) && file_exists($resource)) {
            Utils::PushDownload($resource);
        } else {
            dotnet::PageNotFound($_GET["resource"]);
        }
    }

    /**
     * @access *
     * @require resource=string
    */
    public function scripts() {
        $resource = WebRequest::getPath("resource");
        $resource = WWWROOT . "/typescripts/build/$resource";
        
        if (!empty($resource) && file_exists($resource)) {
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