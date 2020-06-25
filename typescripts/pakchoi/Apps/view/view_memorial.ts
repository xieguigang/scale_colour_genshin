namespace pages {

    export class view_memorial extends Bootstrap {

        public get appName(): string {
            return "view/memorial"
        };

        private evtId: string = <any>$ts("@data:id");

        protected init(): void {
            let vm = this;

            $ts.get(`@api:load_event?id=${$ts("@data:id")}`, function (result) {
                if (result.code == 0) {
                    vm.showDetails(<any>result.info);
                } else {
                    webapp.displayMsg(<string>result.info);
                }
            })

            $ts("#send").onclick = function () {
                vm.sendComment();
            }

            // load comments belongs to this resource file
            webapp.modules.fetchComments(this.evtId, 1);

            $ts.get(`@api:gallery?memorial=${this.evtId}`, function (result) {
                if (result.code == 0) {
                    gallery.showGallery(<any>result.info);
                } else {
                    webapp.displayMsg(<string>result.info);
                }
            });
        }

        private sendComment() {
            let text: string = $ts.value("#comment");
            let data = {
                resource: this.evtId,
                comment: text,
                type: 1
            };

            if (Strings.Empty(text)) {
                return webapp.displayMsg("评论不可以为空！");
            }

            $ts.post("@api:comment", data, function (result) {
                if (result.code == 0) {
                    $ts.value("#comment", "");
                }
            });
        }

        private showDetails(info: memorial) {
            $ts("#title").display(`${info.name}在${info.date}添加了一个纪念日`);
            $ts("#content").display(info.description);
            $ts("#days").display(`已经过去${info.days.days}天了`);
        }
    }

    interface memorial {
        id: string
        date: string
        days: { days: string }
        description: string
        name: string
        /**
         * avatar url
        */
        add_user: string
    }
}