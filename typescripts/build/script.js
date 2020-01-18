var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
        return extendStatics(d, b);
    }
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var pages;
(function (pages) {
    var index = /** @class */ (function (_super) {
        __extends(index, _super);
        function index() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        Object.defineProperty(index.prototype, "appName", {
            get: function () {
                return "index";
            },
            enumerable: true,
            configurable: true
        });
        index.prototype.init = function () {
            $ts("#enter").onclick = function () {
                $goto("/login");
            };
        };
        return index;
    }(Bootstrap));
    pages.index = index;
})(pages || (pages = {}));
var pages;
(function (pages) {
    var login = /** @class */ (function (_super) {
        __extends(login, _super);
        function login() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        Object.defineProperty(login.prototype, "appName", {
            get: function () {
                return "login";
            },
            enumerable: true,
            configurable: true
        });
        login.prototype.init = function () {
            var vm = this;
            $ts.select(".people-link").onClick(function (sender) { return vm.doLogin(sender.getAttribute("people")); });
        };
        login.prototype.doLogin = function (people) {
            var vm = this;
            clearInterval();
            $ts("#open-msg").click();
            $ts.post("@api:login", { people: people }, function (result) {
                if (result.code == 0) {
                    setInterval(function () {
                        vm.doCheckLogin();
                    }, 1000);
                }
                else {
                    console.error(result.info);
                }
            });
        };
        login.prototype.doCheckLogin = function () {
            $ts.get("@api:check", function (result) {
                if (result.code == 0) {
                    if (result.info == "1") {
                        $goto("/home");
                    }
                }
                else {
                    console.error(result.info);
                }
            });
        };
        return login;
    }(Bootstrap));
    pages.login = login;
})(pages || (pages = {}));
var pages;
(function (pages) {
    var home = /** @class */ (function (_super) {
        __extends(home, _super);
        function home() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        Object.defineProperty(home.prototype, "appName", {
            get: function () {
                return "home";
            },
            enumerable: true,
            configurable: true
        });
        home.prototype.init = function () {
            $ts.select(".type0").ForEach(function (card) { return card.style.display = "none"; });
        };
        return home;
    }(Bootstrap));
    pages.home = home;
})(pages || (pages = {}));
var pages;
(function (pages) {
    var chat = /** @class */ (function (_super) {
        __extends(chat, _super);
        function chat() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        Object.defineProperty(chat.prototype, "appName", {
            get: function () {
                return "chat";
            },
            enumerable: true,
            configurable: true
        });
        chat.prototype.init = function () {
            var vm = this;
            setInterval(function () {
                vm.fetchMessage();
            }, 1000);
            $ts("#send").onclick = function () {
                vm.sendComment();
            };
        };
        chat.prototype.sendComment = function () {
            var text = $ts.value("#comment");
            var data = {
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
        };
        chat.prototype.fetchMessage = function () {
        };
        return chat;
    }(Bootstrap));
    pages.chat = chat;
})(pages || (pages = {}));
var pages;
(function (pages) {
    var share_photo = /** @class */ (function (_super) {
        __extends(share_photo, _super);
        function share_photo() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        Object.defineProperty(share_photo.prototype, "appName", {
            get: function () {
                return "share_photo";
            },
            enumerable: true,
            configurable: true
        });
        share_photo.prototype.init = function () {
            var vm = this;
            $ts("#do-upload").onclick = function () {
                vm.doUpload();
            };
            webapp.hookImagePreviews("#inputGroupFile02", "previews");
        };
        share_photo.prototype.doUpload = function () {
            var file = $input("#inputGroupFile02").files[0];
            $ts.upload("@api:upload", file, function (result) {
                if (result.code == 0) {
                    // then save description info
                    $ts.post("@api:addnote", {
                        note: $ts.value("#note"),
                        res: result.info
                    }, function (result) {
                        $goto("/gallery");
                    });
                }
                else {
                    console.error(result.info);
                }
            });
        };
        return share_photo;
    }(Bootstrap));
    pages.share_photo = share_photo;
})(pages || (pages = {}));
var pages;
(function (pages) {
    var view_photo = /** @class */ (function (_super) {
        __extends(view_photo, _super);
        function view_photo() {
            var _this = _super !== null && _super.apply(this, arguments) || this;
            _this.resourceId = $ts("@data:resource");
            return _this;
        }
        Object.defineProperty(view_photo.prototype, "appName", {
            get: function () {
                return "view/photo";
            },
            enumerable: true,
            configurable: true
        });
        view_photo.prototype.init = function () {
            var vm = this;
            $ts("#send").onclick = function () {
                vm.sendComment();
            };
            // load comments belongs to this resource file
            webapp.models.fetchComments(this.resourceId);
        };
        view_photo.prototype.sendComment = function () {
            var text = $ts.value("#comment");
            var data = {
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
        };
        return view_photo;
    }(Bootstrap));
    pages.view_photo = view_photo;
})(pages || (pages = {}));
var pages;
(function (pages) {
    var edit_profile = /** @class */ (function (_super) {
        __extends(edit_profile, _super);
        function edit_profile() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        Object.defineProperty(edit_profile.prototype, "appName", {
            get: function () {
                return "edit/profile";
            },
            enumerable: true,
            configurable: true
        });
        edit_profile.prototype.init = function () {
            var vm = this;
            webapp.hookImagePreviews("#inputGroupFile02", "#avatar-preview");
            $ts("#save").onclick = function () {
                vm.save();
            };
        };
        edit_profile.prototype.save = function () {
            // 先保存头像
            // 如果存在文件值的话
            var avatar = $input("#inputGroupFile02").files;
            if (!isNullOrUndefined(avatar) && (avatar.length > 0)) {
                // 有值，则post回服务器先
                $ts.upload("@api:uploadAvatar", avatar[0], function (result) {
                });
            }
            // 将profile数据post回服务器
            var profile = {
                whats_up: $ts.value("#whatsup"),
                email: $ts.value("#email"),
                nickname: $ts.value("#nickname")
            };
            $ts.post("@api:save", profile, function (result) {
                if (result.code == 0) {
                    $goto("/profile");
                }
                else {
                    webapp.displayMsg(result.info);
                }
            });
        };
        return edit_profile;
    }(Bootstrap));
    pages.edit_profile = edit_profile;
})(pages || (pages = {}));
/// <reference path="../build/linq.d.ts" />
/// <reference path="Apps/index.ts" />
/// <reference path="Apps/login.ts" />
/// <reference path="Apps/home.ts" />
/// <reference path="Apps/chat.ts" />
/// <reference path="Apps/share_photo.ts" />
/// <reference path="Apps/view_photo.ts" />
/// <reference path="Apps/edit_profile.ts" />
var webapp;
(function (webapp) {
    function start() {
        Router.AddAppHandler(new pages.index());
        Router.AddAppHandler(new pages.login());
        Router.AddAppHandler(new pages.share_photo());
        Router.AddAppHandler(new pages.view_photo());
        Router.AddAppHandler(new pages.edit_profile());
        Router.AddAppHandler(new pages.home());
        Router.AddAppHandler(new pages.chat());
        Router.RunApp();
    }
    webapp.start = start;
})(webapp || (webapp = {}));
$ts.mode = Modes.debug;
$ts(webapp.start);
var webapp;
(function (webapp) {
    function hookImagePreviews(inputId, previewImgId) {
        var image = $image(previewImgId);
        var file;
        $input(inputId).onchange = function (evt) {
            file = $input(inputId).files[0];
            image.src = URL.createObjectURL(file);
        };
    }
    webapp.hookImagePreviews = hookImagePreviews;
    function displayMsg(msg) {
    }
    webapp.displayMsg = displayMsg;
})(webapp || (webapp = {}));
var webapp;
(function (webapp) {
    var models;
    (function (models) {
        function fetchComments(resourceId, lastId) {
            if (lastId === void 0) { lastId = ""; }
            var api = "@api:load?resource=" + resourceId + "&lastid=" + lastId;
            $ts.get(api, function (result) {
                if (result.code == 0) {
                    appendComments($ts("#comment-list"), result.info);
                }
            });
        }
        models.fetchComments = fetchComments;
        function appendComments(list, messages) {
            for (var _i = 0, messages_1 = messages; _i < messages_1.length; _i++) {
                var msg = messages_1[_i];
                var row = $ts("<div>", { class: "col-md-4" });
                row.append($ts("<img>", {
                    src: msg.avatar,
                    class: "img-fluid rounded-circle shadow-lg",
                    style: "width: 24px;"
                })).append($ts("<span>", {
                    style: "font-size:0.9em;"
                }).display(msg.message));
                list.append($ts("<div>", { class: "row" }).display(row));
            }
        }
    })(models = webapp.models || (webapp.models = {}));
})(webapp || (webapp = {}));
//# sourceMappingURL=script.js.map