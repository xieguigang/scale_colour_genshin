namespace pages {

    export class login extends Bootstrap {

        get appName(): string {
            return "login";
        }

        protected init(): void {
            let vm = this;

            $ts.select(".people-link").onClick(sender => vm.doLogin(sender.getAttribute("people")));
        }

        private doLogin(people: string) {
            let vm = this;

            clearInterval();

            $ts("#open-msg").click();
            $ts.post("@api:login", { people: people }, function (result) {                
                if (result.code == 0) {
                    setInterval(function () {
                        vm.doCheckLogin();
                    }, 1000);
                } else {
                    console.error(<string>result.info);
                }
            });
        }

        private doCheckLogin() {
            $ts.get("@api:check", function (result: IMsg<string>) {
                if (result.code == 0) {
                    if (result.info == "1") {
                        $goto("/home");
                    }
                } else {
                    console.error(result.info);
                }
            })
        }
    }
}