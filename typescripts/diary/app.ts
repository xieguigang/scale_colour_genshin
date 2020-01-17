/// <reference path="../build/linq.d.ts" />

/// <reference path="Apps/index.ts" />
/// <reference path="Apps/login.ts" />
/// <reference path="Apps/share_photo.ts" />

namespace webapp {

    export function start() {
        Router.AddAppHandler(new pages.index());
        Router.AddAppHandler(new pages.login());
        Router.AddAppHandler(new pages.share_photo());

        Router.RunApp();
    }
}

$ts.mode = Modes.debug;
$ts(webapp.start);