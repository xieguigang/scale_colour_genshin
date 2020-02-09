namespace pages {

    export class home extends Bootstrap {

        get appName(): string {
            return "home";
        }

        latest_id: string;

        protected init(): void {
            let vm = this;

            $ts.select(".type0").ForEach(card => card.style.display = "none");
            $ts("#share_geo").onclick = function () {
                webapp.modules.getLocation();
            }
            $ts("#granted").onclick = function () {
                if (Notification.permission != "granted") {
                    Notification.requestPermission()
                        .then(function (permission) {
                            if (permission == "granted") {
                                webapp.modules.startNotification();
                            } else {
                                webapp.displayMsg("消息权限被拒绝");
                            }
                        });
                } else {

                }

                console.log(Notification.permission);
                webapp.modules.startNotification();
            }

            if (($ts.location.url.protocol == "https") && (Notification.permission != "granted")) {
                $("#open-msg").click();
            }

            $ts("#load-more").onclick = function () {
                vm.loadMoreNews();
            }

            vm.latest_id = <any>$ts("@latest_id");
            vm.loadMoreNews();
        }

        private loadMoreNews() {
            let vm = this;

            $ts.get(`@api:more?latest_id=${vm.latest_id}`, function (result) {
                if (result.code == 0) {
                    vm.showActivities(<any>result.info);
                } else {
                    webapp.displayMsg(<string>result.info);
                }
            });
        }

        private showActivities(data: user_activity[]) {
            let list = $ts("#activity-list");
            let item: HTMLElement;

            for (let record of data) {
                item = $ts("<div>", { class: "row" }).display(`
					<div class="col-md-4">
						<div class="component">
							<div class="card mb-4">
								<div class="card-header">
									<img class="card-img" src='${record.resource}'>
								</div>
								<div class="card-body">
									<span class="badge badge-success mb-2">${record.tag}</span>
									<h4 class="card-title">${record.create_time}</h4>
									<p class="card-text">${record.content}</p>
								</div>
								<div class='card-footer type${record.type}'>
									<a href='${record.link}' class="btn btn-primary">查看</a>
								</div>
							</div>
						</div>
					</div>`);
                list.append(item);

                this.latest_id = record.id;
            }
        }
    }

    interface user_activity {
        resource: string;
        tag: string;
        create_time: string;
        content: string;
        type: string;
        link: string;
        id: string;
    }
}