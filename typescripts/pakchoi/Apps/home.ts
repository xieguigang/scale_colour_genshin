namespace pages {

    export class home extends Bootstrap {

        get appName(): string {
            return "home";
        }

        protected init(): void {
            $ts.select(".type0").ForEach(card => card.style.display = "none");
            $ts("#share_geo").onclick = function () {
                webapp.modules.getLocation();
            }
            $ts("#granted").onclick = function () {
                if (Notification.permission != "granted") {
                    Notification.requestPermission()
                        .then(function (permission) {
                            if (permission == "granted") {
                                webapp.modules.startNotification();
                            } else {
                                webapp.displayMsg("消息权限被拒绝");
                            }
                        });
                }
            }

            $("#open-msg").click();
        }


    }
}