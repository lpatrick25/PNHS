import axios from "axios";
import { Buffer } from 'buffer';

export class LoginRouter {
    username: string;
    password: string;

    constructor(user: string, pass: string) {
        this.username = user;
        this.password = pass;
    }

    async initLogin() {
        let responseData;
        const user: string = Buffer.from(this.username, 'utf8').toString('base64');
        const pass: string = Buffer.from(this.password, 'utf8').toString('base64');

        const parameter: any = {
            isTest: "false",
            goformId: "LOGIN",
            username: user,
            password: pass
        };

        try {
            const response = await axios.post('http://127.0.0.1:8000/proxy-login', new URLSearchParams(parameter));
            responseData = response.data.result == 0 ? true : false;
        } catch (error) {
            console.error('Error in login:', error);
            responseData = false;
        }

        return responseData;
    }
}
