namespace pages {

    export class profile extends Bootstrap {

        get appName(): string {
            return "profile";
        }

        protected init(): void {
            let vm = this;

            $ts.get("@api:visits", function (result) {
                if (result.code == 0) {
                    vm.renderVisitList(<any>result.info);
                }
            });
            $ts.get("@api:logins", function (result) {
                if (result.code == 0) {
                    vm.renderLoginList(<any>result.info);
                }
            });
        }

        private renderLoginList(logins: loginActivity[]) {
            let list = $ts("#login-list");
            let rowView: any;

            for (let login of logins) {
                rowView = $ts("<span>", {
                    style: "font-size:0.8em;color:lightgray"
                }).display(login.create_time).append($ts("<span>", {
                }).display(login.content));

                list.append($ts("<li>").display(rowView));
            }
        }

        private renderVisitList(visits: pageViewActivity[]) {
            let list = $ts("#visit-list");
            let rowView: any;

            for (let visit of visits) {
                rowView = $ts("<span>", {
                    style: "font-size:0.8em;color:lightgray"
                }).display(visit.time)
                    .append($ts("<span>", {
                    }).display($ts("<a>", { href: visit.page_url }).display(visit.page_url)));

                list.append($ts("<li>").display(rowView));
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