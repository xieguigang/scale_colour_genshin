/// <reference path="../build/linq.d.ts" />

/// <reference path="Apps/index.ts" />

namespace webapp {

    export function start() {
        Router.AddAppHandler(new pages.index());

        Router.RunApp();
    }
}

$ts.mode = Modes.debug;
$ts(webapp.start);