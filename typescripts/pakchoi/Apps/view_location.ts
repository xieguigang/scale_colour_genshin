namespace pages {

    export class view_location extends Bootstrap {

        get appName(): string {
            return "view/location";
        }

        private activityId: string = <any>$ts("@data:activityId");

        protected init(): void {
            $ts.get(`@api:getLocation?id=${this.activityId}`, function (result) {
                console.log(result);
            });
        }


    }
}