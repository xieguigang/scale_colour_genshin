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
     * @cache max-age=360000000
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
     * Get upload image
     * 
     * thumbnail = 120
     * preview = 600
     * 
     * @require resource=string
    */
	public function image() {
        # pakchoi::getUploadDir() . "/images/$id/" . $latest[$i]["resource"];	
        $resource = $_GET["resource"];
        $type = strtolower(WebRequest::get("type", ""));
        $path = pakchoi::getUploadDir() . "/images/$resource";
        
        if (!file_exists($path)) {
            dotnet::PageNotFound($_GET["resource"]);
        }

        if ($type == "") {
            # get raw
            Utils::PushDownload($path, -1, "image/jpeg");
        } else {
            if ($type == "thumbnail") {
                # width = 120px for thumbnail
                $tmpfname = tempnam("/tmp", "thumbnail");
                $width = 120;               
            } else if ($type == "preview") {
                # width = 600px for preview
                $tmpfname = tempnam("/tmp", "previews");
                $width = 600;
            } else {
                controller::error("Invalid config: '$type'!");
            }

            $ext = self::getImageRawFileType($resource);

            if(!Utils::ImageThumbs($path, $tmpfname, $width, $ext)){
                controller::error("gd library is not installed!");
            } else {
                Utils::PushDownload($tmpfname, -1, "image/jpeg");
            }
        }
	}
    
    private static function getImageRawFileType($resource) {
        $tokens = explode("/", $resource);
        $user_id = $tokens[0];
        $resource = "{$tokens[1]}/{$tokens[2]}";
        $file = (new Table("resources"))->where([
            "uploader" => $user_id, 
            "resource" => $resource
        ])->find();
        $rawfilename = $file["filename"];
        $ext = explode(".", $rawfilename);
        $ext = $ext[count($ext) -1];

        if (strlen($ext) > 4) {
            # This image file have no extension name
            return "jpg";
        } else {
            return strtolower($ext);
        }
    }

    /**
     * 
    */
    public function audio() {

    }
}