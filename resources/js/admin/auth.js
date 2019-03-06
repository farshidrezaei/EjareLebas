
export default class Auth {
    constructor() {
        if (window.localStorage.getItem('auth')) {
            let auth = JSON.parse(window.localStorage.getItem('auth'));
            this.check = true;
            this.token = auth.token;
            this.user = auth.user;
            this.id = auth.user.id;
        }
        else{
            this.check = false;
            this.token = null;
            this.user = null;
            this.id = null;
        }
    }
}
