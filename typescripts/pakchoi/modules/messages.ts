namespace webapp.modules {

    export interface message {
        send_from: string;
        message_time: string;
        message: string;
        avatar: string;
        id: string;
        target?: {
            title: string;
            href: string;
        }
    }

    export function fetchComments(resourceId: string, type: number, getLastMsgId: Delegate.Sub = null) {
        let api: string = `@api:load?resource=${resourceId}&type=${type}`;

        $ts.get(api, function (result: IMsg<webapp.modules.message[]>) {
            if (result.code == 0) {
                let msgs = <webapp.modules.message[]>result.info;
                let container = $ts("#comment-list");

                appendComments(container, msgs);

                if (!isNullOrUndefined(getLastMsgId) && msgs.length > 0) {
                    getLastMsgId(msgs[msgs.length - 1].id);
                }
            }
        });
    }

    export function appendComments(list: IHTMLElement, messages: message[]) {
        for (let msg of messages) {
            let row = $ts("<div>", { class: "col-md-4" });

            row.appendElement($ts("<img>", {
                src: msg.avatar,
                class: "img-fluid rounded-circle shadow-lg",
                style: "width: 24px;"
            }));

            let timeSpan = $ts("<span>", {
                style: "font-size:0.7em; color: lightgray"
            }).display(msg.message_time + "<br />");
            let msgSpan = $ts("<span>", {
                style: "font-size:0.9em;"
            }).display(msg.message);

            if (isNullOrUndefined(msg.target)) {
                row.appendElement(timeSpan).appendElement(msgSpan);
            } else {
                let visitResource = $ts("<span>").display(msg.target.title + "<br />");
                row.appendElement(timeSpan).appendElement(visitResource).appendElement(msgSpan);
            }

            list.appendElement($ts("<div>", { class: "row" }).display(row));
        }
    }
}