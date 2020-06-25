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
            let args = $from($ts.location.url.query)
                .ToDictionary(a => a.name, a => a.value)
                .Object;
            let msgInfo = loading("正在上传相片，请不要刷新页面...");

            $ts.upload("@api:upload", file, function (result) {
                if (result.code == 0) {
                    // then save description info
                    // and other relation information
                    if (isNullOrUndefined(args)) {
                        args = {};
                    }

                    args["note"] = $ts.value("#note");
                    args["res"] = result.info;

                    $ts.post("@api:addnote", args, function (result) {
                        layer.close(msgInfo);

                        successMsg("上传成功！", function () {
                            $goto("/gallery");
                        });
                    });
                } else {
                    errorMsg(<string>result.info);
                }
            });
        }

    }
}