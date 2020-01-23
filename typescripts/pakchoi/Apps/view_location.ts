namespace pages {

    export class view_location extends Bootstrap {

        get appName(): string {
            return "view/location";
        }

        private activityId: string = <any>$ts("@data:activityId");

        protected init(): void {
            let vm = this;

            $ts.get(`@api:getLocation?id=${this.activityId}`, function (result: IMsg<webapp.modules.ILocation>) {
                if (result.code == 0) {
                    let location = <webapp.modules.ILocation>result.info;

                    if (location.fallback) {
                        vm.renderBaidDuMapLocation(<any>location);
                    }
                }
            });
        }

        private renderBaidDuMapLocation(location: webapp.modules.baiduMapLocation) {
            let address: string = `${location.address}: [${location.content.point.x}, ${location.content.point.y}]`; 

            console.log(location);
            $ts("#info").clear().display(address);
        }

    }
}