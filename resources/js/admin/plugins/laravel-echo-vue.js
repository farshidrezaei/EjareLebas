import Vue from 'vue'
import LaravelEchoVue from 'vue-echo-laravel'

import Echo from 'laravel-echo';

const EchoInstance = new Echo({
    broadcaster: 'pusher',
    host: window.location.hostname + ':8000',
    namespace: 'App.Events',
});
Vue.use(LaravelEchoVue, EchoInstance);

