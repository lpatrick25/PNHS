import { LoginRouter } from './login';
import { Sendmsg } from './send';
import { GetmessageId, Deletehistory } from './cleanhistory';

export async function sendMessageSequence(phoneNumber: string, messageBody: string) {
    try {
        // login
        const login = new LoginRouter('user', '@l03e1t3');
        const responseLogin = await login.initLogin();
        console.log(responseLogin); // Responds boolean if login success

        // send sms
        const sms = new Sendmsg(phoneNumber, messageBody); // (Mobile number , MessageBody)
        const smsResponse = await sms.sendSms();
        console.log(smsResponse);

        // Get Message ID
        const getMsgID = new GetmessageId();
        const responseData = await getMsgID.getMessageId();

        // Delete Message
        const cleanMsgHistory = new Deletehistory(responseData);
        await cleanMsgHistory.deleteMessage();
    } catch (error) {
        console.error('Error during message sequence:', error);
    }
}

declare global {
    interface Window {
        sendMessageSequence: (phoneNumber: string, messageBody: string) => Promise<void>;
    }
}

window.sendMessageSequence = sendMessageSequence;
