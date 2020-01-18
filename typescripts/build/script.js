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
            webapp.hookImagePreviews("#inputGroupFile02", "#avatar-preview");
        };
        return edit_profile;
    }(Bootstrap));
    pages.edit_profile = edit_profile;
})(pages || (pages = {}));
/// <reference path="../build/linq.d.ts" />
/// <reference path="Apps/index.ts" />
/// <reference path="Apps/login.ts" />
/// <reference path="Apps/home.ts" />
/// <reference path="Apps/share_photo.ts" />
/// <reference path="Apps/edit_profile.ts" />
var webapp;
(function (webapp) {
    function start() {
        Router.AddAppHandler(new pages.index());
        Router.AddAppHandler(new pages.login());
        Router.AddAppHandler(new pages.share_photo());
        Router.AddAppHandler(new pages.edit_profile());
        Router.AddAppHandler(new pages.home());
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
})(webapp || (webapp = {}));
//# sourceMappingURL=script.js.map