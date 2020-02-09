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
        latest_id: string;
        protected init(): void;
        private loadMoreNews;
        private showActivities;
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
    class gallery extends Bootstrap {
        readonly appName: string;
        protected init(): void;
        private showGallery;
    }
}
declare namespace pages {
    class profile extends Bootstrap {
        readonly appName: string;
        protected init(): void;
        private renderLoginList;
        private renderVisitList;
    }
}
declare namespace pages {
    class memorials extends Bootstrap {
        readonly appName: string;
        protected init(): void;
        private show_memorials;
    }
    interface memorial {
        date: string;
        description: string;
        add_user: string;
        name: string;
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
    class share_memorial extends Bootstrap {
        readonly appName: string;
        protected init(): void;
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
    class view_location extends Bootstrap {
        readonly appName: string;
        private activityId;
        protected init(): void;
        private renderBaidDuMapLocation;
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
declare namespace webapp.modules {
    function getLocation(): void;
    interface ILocation {
        fallback: boolean;
    }
    interface baiduMapLocation extends ILocation {
        address: string;
        content: {
            address: string;
            point: {
                x: number;
                y: number;
            };
            address_detail: {
                province: string;
                city: string;
                district: string;
                street: string;
                street_number: string;
                city_code: string;
            };
        };
    }
}
declare namespace webapp.modules {
    interface message {
        send_from: string;
        message_time: string;
        message: string;
        avatar: string;
        id: string;
        target?: {
            title: string;
            href: string;
        };
    }
    function fetchComments(resourceId: string, getLastMsgId?: Delegate.Sub): void;
    function appendComments(list: IHTMLElement, messages: message[]): void;
}
declare namespace webapp.modules {
    function startNotification(): void;
}
