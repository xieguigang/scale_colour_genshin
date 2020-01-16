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
/// <reference path="../build/linq.d.ts" />
/// <reference path="Apps/index.ts" />
var webapp;
(function (webapp) {
    function start() {
        Router.AddAppHandler(new pages.index());
        Router.RunApp();
    }
    webapp.start = start;
})(webapp || (webapp = {}));
$ts.mode = Modes.debug;
$ts(webapp.start);
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
            $ts.select(".people-link").onClick(function (sender) {
                var people = sender.getAttribute("people");
                $ts("#open-msg").click();
            });
        };
        return login;
    }(Bootstrap));
    pages.login = login;
})(pages || (pages = {}));
//# sourceMappingURL=script.js.map