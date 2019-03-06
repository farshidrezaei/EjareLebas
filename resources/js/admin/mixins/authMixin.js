import Auth from "../auth";
import {
    mapMutations,
    mapState
} from 'vuex'
export default {
    data() {
        return {
            auth: new Auth()
        }
    },
    methods: {

        login: function () {
            axios.post('api/auth/login', {username: 'farshid.net1@yahoo.com', password: '123123123'})
                .then(response => {
                    console.log(response.data);
                    window.localStorage.auth = JSON.stringify(response.data.response);
                    this.auth = {
                        check: true,
                        token: response.data.response.token,
                        user: response.data.response.user,
                        id: response.data.response.user.id
                    }
                })
                .catch(response => {
                    console.log(response);
                })
        },
        logout: function () {
            axios.post('api/auth/logout', {}, {
                headers:
                    {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + this.auth.token
                    }
            }).then(response => {
                console.log(response.data);
                window.localStorage.removeItem('auth');
                this.auth = {
                    check: false,
                    token: null,
                    user: null,
                    id: null
                }
            })
                .catch(response => {
                    console.log(response);
                });
        },
        getAuth:function (auth=null) {

        }
    },

}