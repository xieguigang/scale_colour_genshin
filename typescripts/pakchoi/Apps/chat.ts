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

        private lastId: string;

        private fetchMessage() {
            webapp.models.fetchComments("-1", this.lastId);
        }
    }
}