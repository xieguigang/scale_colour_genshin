namespace pages {

    export class share_memorial extends Bootstrap {

        public get appName(): string {
            return "share/memorial";
        }

        protected init(): void {
            $ts("#do-add").onclick = function () {
                let evt: string = $ts.value("#event");
                let date: string = $ts.value("#date");

                $ts.post("@api:add", { event: evt, date: date }, function (result) {
                    if (result.code == 0) {
                        $goto("/memorials");
                    } else {
                        webapp.displayMsg(<string>result.info);
                    }
                });
            }
        }
    }
}