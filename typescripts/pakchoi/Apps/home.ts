namespace pages {

    export class home extends Bootstrap {

        get appName(): string {
            return "home";
        }

        protected init(): void {
            $ts.select(".type0").ForEach(card => card.style.display = "none");
        }


    }
}