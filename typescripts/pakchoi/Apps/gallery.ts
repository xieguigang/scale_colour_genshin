namespace pages {

    export class gallery extends Bootstrap {

        public get appName(): string {
            return "gallery";
        };

        protected init(): void {
            let vm = this;

            $ts.get("@api:gallery", function (result) {
                if (result.code == 0) {
                    vm.showGallery(<any>result.info);
                } else {
                    webapp.displayMsg(<string>result.info);
                }
            });
        }

        private showGallery(data: photo[]) {
            let list = $ts("#photos");
            let img: HTMLElement;

            for (let photo of data) {
                img = $ts("<div>", { class: "row" }).display(`
<div class="col-12 col-md-4">
                                <div class="square" style="background-image:url('${photo.url}?type=preview');"></div>
                            </div>`);

                list.append(img);
            }
        }
    }

    interface photo {
        id: string;
        url: string;
    }
}