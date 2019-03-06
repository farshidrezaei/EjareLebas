import Vue from 'vue'

// Components
import './components'

// Plugins
import './plugins'


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

/* eslint-disable no-new */
new Vue({
    i18n,
    router,
    store,
    render: h => h(App)
}).$mount('#app');

