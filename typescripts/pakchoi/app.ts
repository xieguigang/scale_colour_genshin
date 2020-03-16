/// <reference path="../build/linq.d.ts" />
/// <reference path="../layer.d.ts" />

/// <reference path="Apps/index.ts" />
/// <reference path="Apps/login.ts" />
/// <reference path="Apps/home.ts" />
/// <reference path="Apps/chat.ts" />
/// <reference path="Apps/gallery.ts" />
/// <reference path="Apps/goals.ts" />
/// <reference path="Apps/profile.ts" />
/// <reference path="Apps/memorials.ts" />
/// <reference path="Apps/share/share_photo.ts" />
/// <reference path="Apps/share/share_memorial.ts" />
/// <reference path="Apps/view/view_photo.ts" />
/// <reference path="Apps/view/view_location.ts" />
/// <reference path="Apps/view/view_memorial.ts" />
/// <reference path="Apps/edit/edit_profile.ts" />

namespace webapp {

    export function start() {
        Router.AddAppHandler(new pages.index());
        Router.AddAppHandler(new pages.login());
        Router.AddAppHandler(new pages.share_photo());
        Router.AddAppHandler(new pages.share_memorial());
        Router.AddAppHandler(new pages.view_photo());
        Router.AddAppHandler(new pages.view_location());
        Router.AddAppHandler(new pages.view_memorial());
        Router.AddAppHandler(new pages.edit_profile());
        Router.AddAppHandler(new pages.home());
        Router.AddAppHandler(new pages.chat());
        Router.AddAppHandler(new pages.gallery());
        Router.AddAppHandler(new pages.memorials());
        Router.AddAppHandler(new pages.profile());
        Router.AddAppHandler(new pages.goals());

        if (Notification.permission == "granted") {
            webapp.modules.startNotification();
        } else {
            console.log(Notification.permission);
        }

        Router.RunApp();
    }
}

$ts.mode = Modes.debug;
$ts(webapp.start);