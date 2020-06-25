<?php

include __DIR__ . "/../../modules/bootstrap.php";

class App {  

    /**
     * 上传相片
     * 
     * @uses api
     * @method POST
    */
    public function image() {
        imports("Microsoft.VisualBasic.FileIO.FileSystem");

        $file = $_FILES["File"];
        $tmp = $file["tmp_name"];
        $id = $_SESSION["id"];
        $year = year();
        $upload_path = pakchoi::getUploadDir() . "/images/$id/$year/";

        FileSystem::CreateDirectory($upload_path);

        $name = md5(Utils::Now() . $tmp);
        $upload_path = "$upload_path/$name";

        move_uploaded_file($tmp, $upload_path);

        $resId = (new Table("resources"))->add([
            "type" => 0,
            "filename" => $file["name"],
            "upload_time" => Utils::Now(),
            "size" => $file["size"],
            "description" => "",
            "uploader" => $id,
            "resource" => "$year/$name"
        ]);

        if ($resId > 0) {
            pakchoi::addActivity(1, "分享了相片 {$file["name"]}", $resId);
            controller::success($resId);
        } else {
            controller::error("error!");
        }
    }

    /**
     * 上传视频
     * 
     * @uses api
     * @method POST
    */
    public function video() {
        imports("Microsoft.VisualBasic.FileIO.FileSystem");

        $file = $_FILES["File"];
        $tmp = $file["tmp_name"];
        $id = $_SESSION["id"];
        $year = year();
        $upload_path = pakchoi::getUploadDir() . "/video/$id/$year/";

        FileSystem::CreateDirectory($upload_path);

        $name = md5(Utils::Now() . $tmp);
        $upload_path = "$upload_path/$name";

        if (!file_exists($tmp) || filesize($tmp) == 0) {
            controller::error("文件上传错误，请检查服务器配置！");
        }

        move_uploaded_file($tmp, $upload_path);

        $resId = (new Table("resources"))->add([
            "type" => 2,
            "filename" => $file["name"],
            "upload_time" => Utils::Now(),
            "size" => $file["size"],
            "description" => "",
            "uploader" => $id,
            "resource" => "$year/$name"
        ]);

        if ($resId > 0) {
            pakchoi::addActivity(1, "分享了视频 {$file["name"]}", $resId);
            controller::success($resId);
        } else {
            controller::error("error!");
        }
    }
}