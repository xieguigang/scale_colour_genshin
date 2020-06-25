namespace pages {

    export class chat extends Bootstrap {

        get appName(): string {
            return "chat";
        }

        protected init(): void {
            let vm = this;

            setInterval(function () {
                vm.fetchMessage();
            }, 3000);

            $ts("#send").onclick = function () {
                vm.sendComment();
            }

            webapp.modules.fetchComments("-1", -1, function (id) {
                vm.lastId = id;
            });
        }

        private sendComment() {
            let text: string = $ts.value("#comment");
            let data = {
                resource: -1,
                comment: text
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

        /**
         * The latest message id
        */
        private lastId: string;

        private fetchMessage() {
            let vm = this;
            let url: string = `@api:update?last_id=${vm.lastId}`;

            $ts.get(url, function (result: IMsg<webapp.modules.message[]>) {
                if (result.code == 0) {
                    let msgs = <webapp.modules.message[]>result.info;
                    let container = $ts("#comment-list");

                    if (msgs.length > 0) {
                        vm.lastId = msgs[msgs.length - 1].id;
                    }

                    // update ui
                    webapp.modules.appendComments(container, msgs);
                }
            });
        }
    }
}