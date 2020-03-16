namespace pages {

    export class profile extends Bootstrap {

        get appName(): string {
            return "profile";
        }

        private loadVisitsDone: boolean = false;
        private loadLoginsDone: boolean = false;

        protected init(): void {
            let vm = this;
            let msgInfo = loading("正在加载数据...");
            let checkPageLoad = function () {
                if (vm.loadVisitsDone && vm.loadLoginsDone) {
                    layer.close(msgInfo);
                }
            }

            $ts.get("@api:visits", function (result) {
                if (result.code == 0) {
                    vm.renderVisitList(<any>result.info);
                    vm.loadVisitsDone = true;

                    checkPageLoad();
                } else {
                    layer.closeAll();
                    errorMsg(<string>result.info);
                }
            });
            $ts.get("@api:logins", function (result) {
                if (result.code == 0) {
                    vm.renderLoginList(<any>result.info);
                    vm.loadLoginsDone = true;

                    checkPageLoad();
                } else {
                    layer.closeAll();
                    errorMsg(<string>result.info);
                }
            });
        }

        private renderLoginList(logins: loginActivity[]) {
            let list = $ts("#login-list");
            let rowView: any;

            for (let login of logins) {
                rowView = $ts("<span>", {
                    style: "font-size:0.8em;color:lightgray"
                }).display(login.create_time).appendElement($ts("<span>", {
                }).display(login.content));

                list.appendElement($ts("<li>").display(rowView));
            }
        }

        private renderVisitList(visits: pageViewActivity[]) {
            let list = $ts("#visit-list");
            let rowView: any;

            for (let visit of visits) {
                rowView = $ts("<span>", {
                    style: "font-size:0.8em;color:lightgray"
                }).display(visit.time)
                    .appendElement($ts("<span>", {
                    }).display($ts("<a>", { href: visit.page_url }).display(visit.page_url)));

                list.appendElement($ts("<li>").display(rowView));
            }
        }
    }

    interface pageViewActivity {
        time: string;
        page_url: string;
    }

    interface loginActivity {
        create_time: string;
        content: string;
    }
}