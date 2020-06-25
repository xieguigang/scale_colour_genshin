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
     * @cache max-age=3600000
    */
    public function assets() {
        $resource = WebRequest::getPath("resource");
        $resource = WWWROOT . "/assets/$resource";
        
        if (!empty($resource) && file_exists($resource)) {
            Utils::PushDownload($resource, -1, null, null, false, false);
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
            Utils::PushDownload($resource, -1, null, null, false, false);
        } else {
            dotnet::PageNotFound($_GET["resource"]);
        }
    }
    
    /**
     * @require resource=string
     * @access *
    */
    public function avatar() {
        $resource = WebRequest::getPath("resource");
        $path = pakchoi::getUploadDir() . "/avatars/$resource";

        if (!file_exists($path)) {
            dotnet::PageNotFound($_GET["resource"]);
        } else {
            Utils::PushDownload($path, -1, "image/jpeg", null, false, false);
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
        $resource = WebRequest::getPath("resource");
        $type = strtolower(WebRequest::get("type", ""));
        $path = pakchoi::getUploadDir() . "/images/$resource";
        $resource = pakchoi::getUploadResource($resource);

        if (!file_exists($path)) {
            dotnet::PageNotFound($_GET["resource"]);
        }

        if ($type == "") {
            # get raw
            Utils::PushDownload($path, -1, "image/jpeg", $resource["filename"]);
        } else {
            if ($type == "thumbnail") {
                # width = 180px for thumbnail
                $tmpfname = tempnam("/tmp", "thumbnail");
                $width = 200;               
            } else if ($type == "preview") {
                # width = 500px for preview
                $tmpfname = tempnam("/tmp", "previews");
                $width = 500;
            } else {
                controller::error("Invalid config: '$type'!");
            }
        
            $ext = pakchoi::getImageExtensionName($resource["filename"]);

            if(!Utils::ImageThumbs($path, $tmpfname, $width, $ext)){
                controller::error(gd_info());
            } else {
                Utils::PushDownload($tmpfname, -1, "image/jpeg");
            }
        }
	}

    /**
     * 
    */
    public function audio() {

    }

    /**
     *      
     * @require resource=string
    */
    public function video() {
        require dirname(__DIR__) . "/modules/video_server/server.php";

        $resource = WebRequest::getPath("resource");
        $direct = WebRequest::getBool("direct_stream");
        $path = pakchoi::getUploadDir() . "/video/$resource";

        if (!file_exists($path)) {
            dotnet::PageNotFound($_GET["resource"]);
        } else if ($direct) {
            Utils::PushDownload($path, -1, "video/mp4", "video.mp4", false, true);
        } else {
            $video = new SeekableVideo($path, 'video/mp4', 'video.mp4');
            $video->begin_stream();
        }
    }
}