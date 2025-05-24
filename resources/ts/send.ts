import axios from "axios";
import { Buffer } from 'buffer';

export class Sendmsg {
    mobile: string;
    msgBody: string;

    constructor(mobileNumber: string, msg: string) {
        this.mobile = mobileNumber;
        this.msgBody = msg;
    }

    async sendSms() {
        let resultData: any;

        // Converting utf8 to utf16
        const msgContent = Buffer.from(this.msgBody, 'utf16le').toString('hex');
        const _msgContent = msgContent.length > 0 ? `00${msgContent.slice(0, msgContent.length - 2)}` : '';

        // Creating timestamp
        const dateNow: Date = new Date();
        const year: number = dateNow.getFullYear();
        const day: number = dateNow.getDate();
        const month: number = dateNow.getMonth();
        const hour: number = dateNow.getHours();
        const minute: number = dateNow.getMinutes();
        const seconds: number = dateNow.getSeconds();
        // year;month;day;hour;minute;seconds
        const timestamp: string = `${year.toString().slice(2)};${month < 10 ? `0${month + 1}` : month + 1};${day < 10 ? `0${day}` : day};${hour < 10 ? `0${hour}` : hour};${minute < 10 ? `0${minute}` : minute};${seconds < 10 ? `0${seconds}` : seconds};+8`;

        const bodyData = {
            isTest: "false",
            goformId: "SEND_SMS",
            notCallback: "true",
            Number: this.mobile,
            sms_time: timestamp,
            MessageBody: _msgContent,
            ID: "-1",
            encode_type: "GSM7_default"
        };

        try {
            const response = await axios.post('http://127.0.0.1:8000/proxy-send-sms', new URLSearchParams(bodyData));
            resultData = {
                result: response.data.result
            };
        } catch (error: any) {
            console.error('Error in sending SMS:', error);
            resultData = { error: error.message };
        }

        return resultData;
    }
}
