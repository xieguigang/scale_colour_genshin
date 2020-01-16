namespace pages {

    export class login extends Bootstrap {

        get appName(): string {
            return "login";
        }

        protected init(): void {
            $ts.select(".people-link").onClick(function (sender) {
                let people = sender.getAttribute("people");

                $ts("#open-msg").click();
            });
        }
    }
}