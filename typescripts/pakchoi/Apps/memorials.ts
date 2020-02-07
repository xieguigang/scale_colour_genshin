namespace pages {

    export class memorials extends Bootstrap {

        public get appName(): string {
            return "memorials";
        };

        protected init(): void {
            let vm = this;

            $ts.get("@data:memorials", function (result) {
                if (result.code == 0) {
                    vm.show_memorials(<any>result.info);
                } else {
                    webapp.displayMsg(<string>result.info);
                }
            });
        }

        private show_memorials(data: memorial[]) {


            for (let evt of data) {

            }
        }
    }

    export interface memorial {
        date: string;
        description: string;
        add_user: string;
    }
}