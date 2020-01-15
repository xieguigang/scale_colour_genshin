namespace pages {

    export class index extends Bootstrap {

        get appName(): string {
            return "index";
        }

        protected init(): void {
            $ts("#enter").onclick = function () {
                $goto("/home");
            }
        }
    }
}