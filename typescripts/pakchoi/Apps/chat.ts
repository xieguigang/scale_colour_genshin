namespace pages {

    export class chat extends Bootstrap {

        get appName(): string {
            return "chat";
        }

        protected init(): void {
            let vm = this;

            setInterval(function () {
                vm.fetchMessage();
            }, 1000);

            $ts("#send").onclick = function () {
                vm.sendComment();
            }
            $ts("#share_geo").onclick = function () {
                webapp.models.getLocation();
            }
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

            webapp.models.fetchComments("-1", this.lastId, function (id) {
                vm.lastId = id;
            });
        }
    }
}