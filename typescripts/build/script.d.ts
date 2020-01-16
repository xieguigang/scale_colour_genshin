/// <reference path="linq.d.ts" />
declare namespace pages {
    class index extends Bootstrap {
        readonly appName: string;
        protected init(): void;
    }
}
declare namespace webapp {
    function start(): void;
}
declare namespace pages {
    class login extends Bootstrap {
        readonly appName: string;
        protected init(): void;
    }
}
