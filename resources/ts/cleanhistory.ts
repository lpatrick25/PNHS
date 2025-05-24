import axios from "axios";

export class GetmessageId {

    public async getMessageId() {
        let msgid: string = '';

        const url: string = "http://127.0.0.1:8000/proxy-get-message-id";

        await axios({
            method: "get",
            url: url,
        }).then(async function (response) {
            const idData = await response.data;
            const idLen = response.data.messages.length;

            if (idLen < 5) return;

            for (let i = 0; i < idData.messages.length; i++) {
                msgid += `${idData.messages[i].id};`;
            }
        })
        return msgid;
    }
}

export class Deletehistory {
    id: string;

    constructor(messageId: string) {
        this.id = messageId;
    }

    public async deleteMessage() {
        const getContent_length: number = Buffer.byteLength(this.id, 'utf-8');
        const contentValue: number = (getContent_length + 64);
        console.log(contentValue)

        const URL: string = "http://127.0.0.1:8000/proxy-delete-message";

        const BODY: any = {
            "isTest": "false",
            "goformId": "DELETE_SMS",
            "msg_id": this.id,
            "notCallback": "true"
        }

        await axios({
            method: 'post',
            url: URL,
            data: new URLSearchParams(BODY),

        }).then(async function (response) {
            console.log(response.data)
        });
    }
}
