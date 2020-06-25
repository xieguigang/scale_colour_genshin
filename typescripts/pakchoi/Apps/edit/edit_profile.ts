namespace pages {

    export class edit_profile extends Bootstrap {

        get appName(): string {
            return "edit/profile";
        }

        protected init(): void {
            let vm = this;

            webapp.hookImagePreviews("#inputGroupFile02", "#avatar-preview");

            $ts("#save").onclick = function () {
                vm.save();
            }
        }

        private save() {
            // 先保存头像
            // 如果存在文件值的话
            let avatar = $input("#inputGroupFile02").files;

            if (!isNullOrUndefined(avatar) && (avatar.length > 0)) {
                // 有值，则post回服务器先
                $ts.upload("@api:uploadAvatar", avatar[0], function (result) {

                });
            }

            // 将profile数据post回服务器
            let profile = {
                whats_up: $ts.value("#whatsup"),
                email: $ts.value("#email"),
                nickname: $ts.value("#nickname")
            }

            $ts.post("@api:save", profile, function (result) {
                if (result.code == 0) {
                    $goto("/profile");
                } else {
                    webapp.displayMsg(<string>result.info);
                }
            })
        }
    }
}