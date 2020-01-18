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

            });
        }

        private loadComments() {

        }
    }
}