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

        private renderLoginList(logins) {

        }

        private renderVisitList(visits) {

        }
    }
}