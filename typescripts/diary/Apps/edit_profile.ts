namespace pages {

    export class edit_profile extends Bootstrap {

        get appName(): string {
            return "edit/profile";
        }

        protected init(): void {
            webapp.hookImagePreviews("#inputGroupFile02", "#avatar-preview");
        }


    }
}