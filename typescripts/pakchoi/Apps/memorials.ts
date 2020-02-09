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
            let list = $ts("#timeline");

            for (let evt of data) {
                let time = $ts("<li>").display(`<div class="timeline-time">
                                <span class="date">${evt.date}</span>                               
                            </div>
                    
                            <div class="timeline-body">
                                <div class="timeline-header">
                                    <span class="userimage"><img
                                            src="${evt.add_user}" alt=""></span>
                                    <span class="username"><a href="javascript:void(0);">${evt.name}</a> <small></small></span>                                  
                                </div>
                                <div class="timeline-content">
                                    <p>
                                        <a href="/view/memorial/${evt.id}">${evt.description}</a>
                                    </p>
                                </div>                       
                            </div>`);

                list.append(time);
            }
        }
    }

    export interface memorial {
        date: string;
        description: string;
        add_user: string;
        name: string;
        id: string;
    }
}