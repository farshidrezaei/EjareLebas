export default class Auth {

    constructor() {
    };

    static check() {
        if (window.localStorage.getItem('auth')) {
            return JSON.parse(window.localStorage.getItem('auth')).check;
        } else return false;
    };

    static user() {
        if (window.localStorage.getItem('auth')) {

            return JSON.parse(window.localStorage.getItem('auth')).user;
        } else return null;
    };

    static token() {
        if (window.localStorage.getItem('auth')) {

            return JSON.parse(window.localStorage.getItem('auth')).token;
        } else return null;
    };

}
