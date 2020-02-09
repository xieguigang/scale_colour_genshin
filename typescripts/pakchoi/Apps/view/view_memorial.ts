namespace pages {

    export class view_memorial extends Bootstrap {

        public get appName(): string {
            return "view/memorial"
        };

        protected init(): void {
            let vm = this;

            $ts.get(`@api:load_event?id=${$ts("@data:id")}`, function (result) {
                if (result.code == 0) {
                    vm.showDetails(<any>result.info);
                } else {
                    webapp.displayMsg(<string>result.info);
                }
            })
        }

        private showDetails(info: memorial) {
            $ts("#title").display(`${info.name}在${info.date}添加了一个纪念日`);
            $ts("#content").display(info.description);
            $ts("$days").display(`已经过去${info.days}天了`);
        }
    }

    interface memorial {
        id: string
        date: string
        days: string
        description: string
        name: string
        /**
         * avatar url
        */
        add_user: string
    }
}