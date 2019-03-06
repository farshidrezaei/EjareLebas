/**
 * Vuex
 *
 * @library
 *
 * https://vuex.vuejs.org/en/
 */

// Lib imports
import Vue from 'vue'
import Vuex from 'vuex'

// Store functionality
import state from './state'
import actions from './actions'
import getters from './getters'
import modules from './modules'
import mutations from './mutations'

Vue.use(Vuex);

// Create a new store
const store = new Vuex.Store({
    actions,
    getters,
    modules,
    mutations,
    state
});

export default store
