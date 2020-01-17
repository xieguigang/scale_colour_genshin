<?php

imports("MVC.controller");
imports("MVC.restrictions");

class accessController extends controller {

    private static function recordEvent($code) {
        (new Table("pageview"))->add([
            "time" => Utils::Now(),
            "code" => $code,
            "page_url" => Utils::URL(false),
            "user_id" => pakchoi::login_userId(),
            "ip" => Utils::UserIPAddress(),
            "location" => (new baiduMap())->GetUserGeoLocation()
        ]);
    }

    private function log_pageView($access) {
        $type = $this->getUsage();

        # 从这里统计用户的活动信息
        if ($type == "view" || $type == "router") {
            // 只针对html页面的访问进行统计
            self::recordEvent($access ? 200 : 403);
        }

        return $access;
    }

    public function accessControl() {
        $access = $this->getAccessLevel();        

        if ($this->AccessByEveryOne()) {
            return $this->log_pageView(true);
        } else if (empty($access)) {
            // 什么也没有填写的时候，默认为登录用户才可以访问
            return $this->log_pageView(pakchoi::login_userId() > 0);
        } else {
            // access现在不为空的了
            $access = explode("|", $access);
        } 
        
        // 例如控制器被标记为
        // @access wechat|admin
        // 表示只能够通过微信端或者具有管理员权限的用户才可以访问当前的这个控制器

        // 控制器被标记为
        // @access admin
        // 表示只能够具有管理员权限的用户才可以访问当前的这个控制器
        //
        // 则权限管理可以通过下面的循环来实现
        $roles = self::getUserRoleEnums();

        foreach ($access as $role) {
            if (array_key_exists($role, $roles)) {
                if (self::isRole($roles[$role])) {
                    return $this->log_pageView(true);
                }
            }
        }
        
        // 当前的用户任何权限条件都不满足，则禁止访问当前的这个控制器
        return $this->log_pageView(false);
    }

    private static function isRole($roleId) {
        return false;
    }

    private static function getUserRoleEnums() {
        return [
            "admin" => 999
        ];
    }
}