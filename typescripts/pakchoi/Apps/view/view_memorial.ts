namespace pages {

    export class view_memorial extends Bootstrap {

        public get appName(): string {
            return "view/memorial"
        };

        protected init(): void {
            let vm = this;

            $ts.get(`@api:memorial?id=${$ts("@id")}`, function (result) {
                if (result.code == 0) {
                    vm.showDetails(<any>result.info);
                } else {
                    webapp.displayMsg(<string>result.info);
                }
            })
        }

        private showDetails(info: memorial) {

        }
    }

    interface memorial {
        id: string
        date: string
        description: string
        user_name: string
        user_avatar: string
    }
}