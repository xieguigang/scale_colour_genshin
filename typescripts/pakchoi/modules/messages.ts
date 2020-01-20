namespace webapp.modules {

    export interface message {
        send_from: string;
        message_time: string;
        message: string;
        avatar: string;
        id: string;
    }

    export function fetchComments(resourceId: string, lastId: string = "", getLastMsgId: Delegate.Sub = null) {
        let api: string = `@api:load?resource=${resourceId}&lastid=${lastId}`;

        $ts.get(api, function (result: IMsg<webapp.models.message[]>) {
            if (result.code == 0) {
                let msgs = <webapp.models.message[]>result.info;
                let container = $ts("#comment-list");

                appendComments(container, msgs);

                if (!isNullOrUndefined(getLastMsgId) && msgs.length > 0) {
                    getLastMsgId(msgs[0].id);
                }
            }
        });
    }

    function appendComments(list: IHTMLElement, messages: message[]) {
        for (let msg of messages) {
            let row = $ts("<div>", { class: "col-md-4" });

            row.append($ts("<img>", {
                src: msg.avatar,
                class: "img-fluid rounded-circle shadow-lg",
                style: "width: 24px;"
            })).append($ts("<span>", {
                style: "font-size:0.9em;"
            }).display(msg.message));

            list.append($ts("<div>", { class: "row" }).display(row));
        }
    }
}