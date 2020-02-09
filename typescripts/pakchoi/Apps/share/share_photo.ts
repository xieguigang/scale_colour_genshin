namespace pages {

    export class share_photo extends Bootstrap {

        get appName(): string {
            return "share_photo";
        }

        protected init(): void {
            let vm = this;

            $ts("#do-upload").onclick = function () {
                vm.doUpload();
            }

            webapp.hookImagePreviews("#inputGroupFile02", "#previews");
        }

        private doUpload() {
            let file: File = $input("#inputGroupFile02").files[0];

            $ts.upload("@api:upload", file, function (result) {
                if (result.code == 0) {
                    // then save description info
                    $ts.post("@api:addnote", {
                        note: $ts.value("#note"),
                        res: result.info
                    }, function (result) {
                        $goto("/gallery");
                    });
                } else {
                    console.error(<string>result.info);
                }
            });
        }

    }
}