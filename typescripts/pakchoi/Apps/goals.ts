namespace pages {

    export class goals extends Bootstrap {

        public get appName(): string {
            return "goals";
        };

        protected init(): void {
            let vm = this;

            $ts("#").onclick = function () {
                vm.create_goal();
            }

            vm.show_goals();
        }

        private create_goal() {

        }

        private show_goals() {

        }
    }
}