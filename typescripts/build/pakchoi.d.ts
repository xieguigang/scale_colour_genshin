/// <reference path="linq.d.ts" />
declare namespace pages {
    class index extends Bootstrap {
        readonly appName: string;
        protected init(): void;
    }
}
declare namespace pages {
    class login extends Bootstrap {
        readonly appName: string;
        protected init(): void;
        private doLogin;
        private doCheckLogin;
    }
}
declare namespace pages {
    class home extends Bootstrap {
        readonly appName: string;
        protected init(): void;
    }
}
declare namespace pages {
    class chat extends Bootstrap {
        readonly appName: string;
        protected init(): void;
        private sendComment;
        /**
         * The latest message id
        */
        private lastId;
        private fetchMessage;
    }
}
declare namespace pages {
    class share_photo extends Bootstrap {
        readonly appName: string;
        protected init(): void;
        private doUpload;
    }
}
declare namespace pages {
    class view_photo extends Bootstrap {
        readonly appName: string;
        private resourceId;
        protected init(): void;
        private sendComment;
    }
}
declare namespace pages {
    class edit_profile extends Bootstrap {
        readonly appName: string;
        protected init(): void;
        private save;
    }
}
declare namespace webapp {
    function start(): void;
}
declare namespace webapp {
    function hookImagePreviews(inputId: string, previewImgId: string): void;
    function displayMsg(msg: string): void;
}
declare namespace webapp.models {
    function getLocation(): void;
}
declare namespace webapp.models {
    interface message {
        send_from: string;
        message_time: string;
        message: string;
        avatar: string;
        id: string;
    }
    function fetchComments(resourceId: string, lastId?: string, getLastMsgId?: Delegate.Sub): void;
}
