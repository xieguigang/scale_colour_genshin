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
/// <reference path="../build/linq.d.ts" />
/// <reference path="Apps/index.ts" />
/// <reference path="Apps/login.ts" />
var webapp;
(function (webapp) {
    function start() {
        Router.AddAppHandler(new pages.index());
        Router.AddAppHandler(new pages.login());
        Router.RunApp();
    }
    webapp.start = start;
})(webapp || (webapp = {}));
$ts.mode = Modes.debug;
$ts(webapp.start);
//# sourceMappingURL=script.js.map