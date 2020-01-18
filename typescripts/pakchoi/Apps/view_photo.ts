namespace pages {

    export class view_photo extends Bootstrap {

        get appName(): string {
            return "view/photo";
        }

        private resourceId: string = <any>$ts("@data:resource");

        protected init(): void {
            let vm = this;

            $ts("#send").onclick = function () {
                vm.sendComment();
            }

            // load comments belongs to this resource file
            this.loadComments();
        }

        private sendComment() {
            let text: string = $ts.value("#comment");
            let data = {
                resource: this.resourceId,
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

        private loadComments() {
            $ts.get(`@api:load&resource=${this.resourceId}`, function (result: IMsg<webapp.models.message[]>) {
                if (result.code == 0) {
                    for (let msg of <webapp.models.message[]>result.info) {

                    }
                }
            });
        }
    }


}