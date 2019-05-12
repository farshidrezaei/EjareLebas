import Vue from 'vue'

// Components
import './components'

// Plugins
import './plugins'

//auth
import Auth from '../admin/auth';


window.Auth = Auth;

// Sync router with store
import {sync} from 'vuex-router-sync'

// Application imports
import App from './App';

// i18n import
import i18n from './i18n';

//router import
import router from './router';

//store import
import store from './store'

//mixins
import AuthMixin from './mixins/authMixin';

// Sync store with router
sync(store, router);

Vue.config.productionTip = false;

Vue.mixin(AuthMixin);

import {
    mapMutations,
    mapState
} from 'vuex'

/* eslint-disable no-new */
new Vue({
    i18n,
    router,
    store,

    methods: {
        ...mapMutations('auth', ['setAuthCheck', 'setAuthUser', 'setAuthToken']),
    },

    created() {
        if (window.localStorage.auth) {
            this.setAuthCheck(JSON.parse(window.localStorage.auth).check);
            this.setAuthUser(JSON.parse(window.localStorage.auth).user);
            this.setAuthToken(JSON.parse(window.localStorage.auth).token);
        }
    },
    mounted() {
        // this.$echo.private('user')
        //     .listen('UserUpdated', (response) => {
        //         console.log(response);
        //     });
    },
    render: h => h(App)
}).$mount('#app');


